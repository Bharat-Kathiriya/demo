<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'training' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'sbJ?|sxg2Uf[jHnQJtO.WPAwcU|)trbjpiCa},#6fP%t*|8<ILIOY~ySxt.z<Ebs' );
define( 'SECURE_AUTH_KEY',  'M&F?I+6$_[RY)*i9zy>|Xt&FhHBqt+5{6Oi;}c:~gYv:Wy{/:RT6R,`njzz0]>/<' );
define( 'LOGGED_IN_KEY',    'uxc^H~^wu(.>Ja2,Uw8+_kDt34w/TJ?RGKDm+S0YqltQ[3*jxBKsbkrp#$a6A<3-' );
define( 'NONCE_KEY',        ' &>yKu.w79gz4<4zL$j~+<1TaL$O>qh1=v03(xgQ9Afk)q]Ia4F|8x_1r/xHl)Cg' );
define( 'AUTH_SALT',        'BA}?(k!wfH[m`s?X`@%-5R}tq7JIE[=-+HuMam!E&}Q@4pvx=J4rgOl5Vilpr^_|' );
define( 'SECURE_AUTH_SALT', '4;7G0.63 2^>?{AUKWgb1<ZqF-bXs}O@u~X11]<s|rW$ZZVz1UDDJN12pmXvdpd[' );
define( 'LOGGED_IN_SALT',   'L.-}}L.<,G%]/5oiF]=y;CN(sL`oEqXFK%O tk(<ZD~^7lZdVX/*r,p_?(d<w_Sv' );
define( 'NONCE_SALT',       'vJ@Wc,:caviO`,@~hGdAQ|>51S;slhsW>.D2b28P6n!s)L/p)`wn3|y9~d!H!04|' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'training_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );          // Enable debugging
define( 'WP_DEBUG_LOG', true );      // Log errors to file
define( 'WP_DEBUG_DISPLAY', true ); // Hide errors on screen
@ini_set( 'display_errors', 0 );     // Force hide PHP errors

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
