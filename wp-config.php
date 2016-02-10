<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache





define('WP_HOME', 'http://earmilk.com');
define('WP_SITEURL', 'http://earmilk.com');
define('WP_ALLOW_REPAIR', true);
define('WP_POST_REVISIONS', true);
/* var_dump($_SERVER); */
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
define('WP_MEMORY_LIMIT', '512M');
define('WP_ALLOW_MULTISITE', false);
define( 'UPLOADS', 'wp-content/'.'uploads' );
define( 'COOKIE_DOMAIN', '.earmilk.com' );
define( 'COOKIEPATH', '/' );
define('DISABLE_WP_CRON', true);
define('WP_DEBUG', false);
define('FS_METHOD','direct');
// ** MySQL settings - You can get this info from your web host ** //
$host = $_SERVER['HTTP_HOST'];
if ($host == 'earmilk.com' || $host == 'earmilk.com') {
	define('DB_NAME', 'earmilkdb');
	define('DB_USER', 'earmilk');
	define('DB_PASSWORD', 'caphydra43');
	define('DB_HOST', 'db01');
} else {
	define('DB_NAME', 'earmilkdb');
	define('DB_USER', 'earmilk');
	define('DB_PASSWORD', 'caphydra43');
	define('DB_HOST', 'db01');
}
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');
/** The Database Collate type. Dont change this if in doubt. */
define('DB_COLLATE', 'utf8_general_ci');
define('DISALLOW_FILE_EDIT', TRUE); // Sucuri Security: Thu, 08 Oct 2015 19:59:33 +0000
/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',        'QWsm:O=K8L@AHQYq.gBK<e:G3-]kFGus[W(I;:cSAmGiiL~CpcE1GH`$zc>Q8l:N');
define('SECURE_AUTH_KEY', ':.2Ral REKpY;b-ge{nNyiAJmD3`%|UB`9|RgpDba%8n+l)rqo;;[-JVc$I#{:6F');
define('LOGGED_IN_KEY',   'V8-dUIF?C*0-+BQhm~L5l@8U<6VdsYG(;/8;c-Hm %_h{k(k^4&<)!M4k9s@-Zu-');
define('NONCE_KEY',       '^6U-!9YH]`DN`ox1)MNMU,-+^A+Vr!$QGbB[JczR]K5L$$+{e>r<3)8;ca#k~F@!');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';
/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');
/** Enable W3 Total Cache */
/* That's all, stop editing! Happy blogging. */
/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
?>