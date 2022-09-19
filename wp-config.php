<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'u598424622_gfIOW' );

/** Database username */
define( 'DB_USER', 'u598424622_9590n' );

/** Database password */
define( 'DB_PASSWORD', '5IP70YMLgU' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',          ')RbUC3JrRj=$mWUi@NrGKyC8#F5b>G?!%r=k@QNx2tDDaEtUbl<NQ|+Gi)wDKFIW' );
define( 'SECURE_AUTH_KEY',   '!JjbPr[a~k5S<P>r.RxD!?5PQ/:6R;wPH)5N492]y~s=y]mV{2~tjG*EI]y0gP<B' );
define( 'LOGGED_IN_KEY',     'QDzwF_cB^lA*,vlHsj$g$}.9=mCyf[8ZPLb1/#@IA1=&.~~7^yy^KMeycUCwr1)[' );
define( 'NONCE_KEY',         ')y~kT T#XU}_:]m,xM@_5gD8F|A+A|19g@i}eYGov_yz`dpQ:]dbQn WEXH>{P(L' );
define( 'AUTH_SALT',         '~th98<#Yu>:j,XDhD0HFtUtcEd36Hm:Z^.EMw8.V[S(xCr<JsH>M.Nw yPuW~VF%' );
define( 'SECURE_AUTH_SALT',  '{To?4Cu_m%Oh]@GZnII^*#tSr[[M^>v|TLg[18i|/BH,F$E68>_<jPx![1RIf[{v' );
define( 'LOGGED_IN_SALT',    'bxP/&oW;025X~mLW0NF+d]EI^:bf(GvYy;FIFyiE(uRjn).o6lCf~t&UQ%S[bk^ ' );
define( 'NONCE_SALT',        'Qk||Z%te_MhywafF!G<f]&mq;.:IwA>Rc<n%@Lfg+cO%Y=dCh)ehyCq{{~ p{95*' );
define( 'WP_CACHE_KEY_SALT', '=5k-m6LOI$l?4>#!6Au9IUO?#LVE!,PP{B-2K^)7GcE_HQc;&m^ cEZdC/LwGQ|p' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
