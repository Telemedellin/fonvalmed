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
define('DB_NAME', 'fonvalmed');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'lY 1Y,/~bfb~~<HtbrLAAHkPN{~$i)Xig2<Vw6uCVjLKPyzmG+AXOs!xoFP|-Y8-');
define('SECURE_AUTH_KEY',  'oocT4t1@<r%k + uf%gZj~uH7YjI:~g0?(}K]eR9:EA0tt5R+&|~RecDs |D%v!s');
define('LOGGED_IN_KEY',    '.rq{3|lr|5FU$-<j 2|>gh6%/HyHKv?6qcx4)4VgU!W.]-A Ek.O!RV)g+@ZSCnA');
define('NONCE_KEY',        'xS#utl2lc8D7(f?^Rp|$g|Bv!0LKNZz/TOfk3/0qQVgld)9bk#DPoTHIjw0,n+:^');
define('AUTH_SALT',        'hCv1MY!-;fc]QAi(x5|&_+:@lg)PoW|nKxd6Dq%~5Q#>Z8.5%so4N_K+#xOPPi-~');
define('SECURE_AUTH_SALT', '1yhqa6z_>7jR)th{RkvenK#+.Qu-](sbqxU.^3gU r3ES>||~N$KAZVL-3VBIW>?');
define('LOGGED_IN_SALT',   '{9;.iLL5(,{DmPC$4/nt}cg2k+i&}G-WR}PBnS)^%GcCvh[T,~2{e|S9y;z-|O5B');
define('NONCE_SALT',       'mMKA>N$KX+ztMouVihK+V?c3T-rJw?JJR =HN^^(j:}:44.z4Ym-by.j>yCag|Cp');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
