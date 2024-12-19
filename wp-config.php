<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '2^~(pw_x^+aGWl)~Av6(Il?<dTuB$f`u7ux1qD8Uk1*X^pGx$*}bqb?L{v/qh]`J' );
define( 'SECURE_AUTH_KEY',   'L1vqi2=ivo//[_dz sAR(pR,}uE$XNiCnpO:a{3wTmzWyk{*39j|F*MZe JQ]NH|' );
define( 'LOGGED_IN_KEY',     'K~/@0-/^k+!+:%5Wwq%i9F.Sl=,:Iy,@Drj^Z>YhB}>9sqH!z|R:8sPwPT!H!FC*' );
define( 'NONCE_KEY',         '0!G9l~C%.<~1~FxJ6,gE7d6ZCek^izx{U,, tY9 acQ#)`-t`RXg7ziPr&fGK@P6' );
define( 'AUTH_SALT',         'd3j?Ndcn-CLW3~Trw9UY6E=xFAZhP7zFIAD(W6*fQG|Y}`6y|Td}0D30+}r^w)fZ' );
define( 'SECURE_AUTH_SALT',  '0e]04Ghs}N8nK!90#=a<XE(^<N;%[lp!%hl9|]Y+R: ~Cyf`pCI0l#FH/(8c!,A2' );
define( 'LOGGED_IN_SALT',    'jP#Y6-e3!b-|LDth@{E,C!<@2a}unEOHLYTU]R|+Ke!XRd|Dp7iz2W@c/%ppc&v2' );
define( 'NONCE_SALT',        'x$wehTU^FA& !C}Ao&wVF~&Iyl{r3uD CX&p~_X?e=%WN^#dOV58]@>di]1@iVC+' );
define( 'WP_CACHE_KEY_SALT', 'J4!{UF|<C4zv(;u{|XGQ$jtO:$$7RB0!!G$yBLM+:*hgl&4 2!zTA#5oYw@@<oj^' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', '2297153ba2e94d613e5a6f71692ecf0e' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */
define('WP_DEBUG_LOG', true);

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
