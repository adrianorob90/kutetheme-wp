<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
//define('WP_CACHE', true); //Added by WP-Cache Manager

define( 'WPCACHEHOME', 'C:\xampp\htdocs\kutetheme-wp\wp-content\plugins\wp-super-cache/' ); //Added by WP-Cache Manager

define('DB_NAME', 'kutetheme-wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'OEriuY}BuUiYl| ,ttDr^upP+)<tGs${Up(F=%rOQ;x^v1tMkRYf]ruH~ vdt9qN');
define('SECURE_AUTH_KEY',  '^zoSeS^W=x^cu5HqUc@ Ys_W4Lp;|Fa4;g@RAr/i|J)%ZvIY^43HE{j}*GSW(52V');
define('LOGGED_IN_KEY',    'S(l}BIMx]XN|l7&-T&5PXVn6@}qe%Z4#9@nfz.5DH7@U%y6?`23t&dd]M*bz&k2<');
define('NONCE_KEY',        'tH+Kl_30xnr$X-A4+6&eV;+G[WQ8k4SI-)icz|DF<?E`/w-}l}o8+UU#F||h~Uw.');
define('AUTH_SALT',        '@Y&C8k>{/}%7yoGM Hulvk!8/8aQ+wUwwkb0fY+~1|L7z%Z_]vTk4-??!.ZV}00e');
define('SECURE_AUTH_SALT', '=p`l{G7M{+r5RsivE!}(]^sc7J&X9Ka!mOD{+P>VE$a:}-feoU<8g.:b5!nLquNI');
define('LOGGED_IN_SALT',   ':R?IP&O^f&{`>:Zlt72)AwvuQ96|JBY5TapLjM2mOPEs(;TR5yUC:FGIt,9etOd}');
define('NONCE_SALT',       '[o=Z{X)h`.AdkY++vC%fM3XW)H8a]sFYU+;3Q$UCD4T.L+v3sa*P3oa)6yB(PMj[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'kt_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
