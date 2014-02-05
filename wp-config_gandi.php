<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'nude_website');

/** MySQL database username */
define('DB_USER', 'root_admin');

/** MySQL database password */
define('DB_PASSWORD', '!NudeAudi0');

/** MySQL hostname */
define('DB_HOST', 'nudeaudio.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'yC!xJi+y+|TB9z6$#CKF3)!{ayz-XbK}4|7x=||jX>*2(q7/ASeYng}Qb%[H`^4j');
define('SECURE_AUTH_KEY',  'H bNQz93@#/b]m1QQt} #j$@&#xetxWzXqO+VX[C5)m6:!.gJ:I<jQvQ|OD P]d+');
define('LOGGED_IN_KEY',    'j vJOU_I0tGbxF2cO:NcKuI73M w_gmcBLK7J.j@s92md/;[~SU&GAX^Ekh_E.3!');
define('NONCE_KEY',        'a(fJEE&blMan|=:DK]-fa&i#Vyrq ,yM]S_W`6_3FMLK~>>0ARHAHj?,]GZr1/ar');
define('AUTH_SALT',        'o4rHUSG}L>n4G,sYO}{]g_ir<.-C^eyXYYbNx3X7x?+1=I)JjNZ7jh]-3:p/YE^=');
define('SECURE_AUTH_SALT', 'FPl4K^1A79a$_;JBP|`d:+HgZbo5,jUX<98PJ~}mwdmC[dlydv1|v)CQa0n2HH+R');
define('LOGGED_IN_SALT',   'l0,6ftW>KRV1`yLnqN&kD{P`m<oF1rdmTVa5`ZO(_eKHt=6$Opv[Pw,opCd!N(lZ');
define('NONCE_SALT',       '%D6EK!S~.SmH+@yj0j?ud#IxD@]hu7^<%O*JhuLdG@4#?&F^L{kHzH2x@AL:z8[P');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'jj_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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


/** increase memory. */

define('WP_MEMORY_LIMIT', '64M');
