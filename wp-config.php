<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '^Qi)bFB$8|6N)oXhYRS]sKU_uG6+}A_JfsA7Y/9G/)lLZVk;eD=5Ng1!S9*s7Drl');
define('SECURE_AUTH_KEY',  '_bt_Vf7susO-AP?HUkf*jyL+<Jd1 _4QO!e>O6R:h*bE3U!&>#zQ>JsAK(XSDO?F');
define('LOGGED_IN_KEY',    '[]xm}^-oodU7d:D_&FTIzN=i706eKLc9D#B%p?9+K23ms$jZvG{u*Kb)z975 Yam');
define('NONCE_KEY',        '^7,Q9x1-Q6n+]$pq/Kyb</l<Rz<:;#*Ow)*TW-KhjxKuePY{U3n#^Fl!4i7pi*1X');
define('AUTH_SALT',        '$O:3)ODa{%Ey.O5j#}/KeW6nVv5riYjA43!GJyq50}II3YO-RfXo}3&cl%uU,fy~');
define('SECURE_AUTH_SALT', '9O73`xsP<Q1p/$~Zjesw4zd-heDhyKbE;DB$*-HarB,|<b, RW#szijn9(^DqBE,');
define('LOGGED_IN_SALT',   '>N;.2eq_5x>5dTYdv44}%arbF$`J8ZyQMwd8qh;,0J}$!oB(jZrRJDQOgSiDTzqb');
define('NONCE_SALT',       '*-I2),mMvuNFxsmU-eq+@g,qL}GAo|~:Koj9+;H$FZLj[KH9Lx<Cw9IZF1dLH{d3');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
