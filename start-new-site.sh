#!/bin/bash

DIR=~/domains/projekty.pwa.com.pl/public_html/
WP=wordpress-starterpack
SITE=`echo "print('$1'.lower())" | python` # to lower case
DNS=http://projekty.pwa.com.pl/$SITE
MYSQL_USER=m1547_projects
MYSQL_SITE_DB=m1547_$SITE

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
echo "Folder \"$SITE\" utworzony poprawnie"

echo "Rozpoczynam kopiowanie bazy danych MySQL"
devil mysql db add $SITE $MYSQL_USER

mysqldump --host mysql11.mydevil.net --user $MYSQL_USER -pnQpw2ysSqrwBakXRG0vR m1547_wp_starterpack > $MYSQL_SITE_DB.sql
mysql --host mysql11.mydevil.net --user $MYSQL_USER -pnQpw2ysSqrwBakXRG0vR $MYSQL_SITE_DB < $MYSQL_SITE_DB.sql
mysql --host mysql11.mydevil.net --user $MYSQL_USER -pnQpw2ysSqrwBakXRG0vR $MYSQL_SITE_DB -e "UPDATE wp_options SET option_value = '$DNS' WHERE wp_options.option_id IN (1,2);"

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

# zamiana bazy danych w configu
sed -i -e "s/m1547_wp_starterpack/$MYSQL_SITE_DB/g" "$DIR$SITE/wp-config.php"


echo "Site is ready: $DNS"
echo "ALL DONE :)"


