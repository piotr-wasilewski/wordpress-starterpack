#!/bin/bash

if [ -z "$ENV_MYSQL_HOST" ]
then
      echo "Brak wpisu w .profile"
      echo "export \$ENV_MYSQL_HOST=host"
      exit 1
fi

if [ -z "$ENV_MYSQL_USER" ]
then
      echo "Brak wpisu w .profile"
      echo "export \$ENV_MYSQL_USER=user"
      exit 1
fi

if [ -z "$ENV_MYSQL_PASS" ]
then
      echo "Brak wpisu w .profile"
      echo "export \$ENV_MYSQL_PASS=password"
      exit 1
fi

DIR=~/domains/projekty.pwa.com.pl/public_html/
WP=wordpress-starterpack
SITE=`echo "print('$1'.lower())" | python` # to lower case
DNS=http://projekty.pwa.com.pl/$SITE
MYSQL_SITE_DB="${ENV_MYSQL_USER}_${SITE}"

if [ -z "$SITE" ]; then
  echo "Nie podano domeny. Proszę podać jako parametr nową domenę"
  exit 1
fi

if [ ! -d "$DIR$WP" ]; then
  echo "Brak WP Starterpacka \"$WP\". Przerywam dodawanie strony"
  exit 1
fi

if [ -d "$DIR$SITE" ]; then
  echo "Folder \"$SITE\" już istnieje. Przerywam dodawanie strony"
  exit 1
fi

echo "Rozpoczynam kopiowanie danych"
cp -r $DIR$WP $DIR$SITE
rm $DIR$SITE/start-new-site.sh
echo "Folder \"$SITE\" utworzony poprawnie"

echo "Rozpoczynam kopiowanie bazy danych MySQL"
devil mysql db add projects_${SITE} $ENV_MYSQL_USER

mysqldump --host $ENV_MYSQL_HOST --user $ENV_MYSQL_USER -p$ENV_MYSQL_PASS ${ENV_MYSQL_USER}_wp_starterpack > $MYSQL_SITE_DB.sql
mysql --host $ENV_MYSQL_HOST --user $ENV_MYSQL_USER -p$ENV_MYSQL_PASS $MYSQL_SITE_DB < $MYSQL_SITE_DB.sql
mysql --host $ENV_MYSQL_HOST --user $ENV_MYSQL_USER -p$ENV_MYSQL_PASS $MYSQL_SITE_DB -e "UPDATE wp_options SET option_value = '$DNS' WHERE wp_options.option_id IN (1,2);"

rm $MYSQL_SITE_DB.sql

echo "# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /$SITE/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /$SITE/index.php [L]
</IfModule>" > $DIR$SITE/.htaccess

echo "Preapring config"

head -n 8 wp-config-sample.php | cat > "$DIR$SITE/wp-config.php"

wget https://api.wordpress.org/secret-key/1.1/salt/
cat "index.html" >> "$DIR$SITE/wp-config.php"
rm "index.html"

tail -n 5 wp-config-sample.php | cat >> "$DIR$SITE/wp-config.php"

# zamiana bazy danych w configu
sed -i -e "s/database_name_here/$MYSQL_SITE_DB/g" "$DIR$SITE/wp-config.php"
sed -i -e "s/username_here/$ENV_MYSQL_USER/g" "$DIR$SITE/wp-config.php"
sed -i -e "s/password_here/$ENV_MYSQL_PASS/g" "$DIR$SITE/wp-config.php"
sed -i -e "s/localhost/$ENV_MYSQL_HOST/g" "$DIR$SITE/wp-config.php"

echo "Site is ready: $DNS"
echo "ALL DONE :)"
