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
define( 'DB_NAME', 'mp' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '(Q_tGHiO)T8~MJvW/`g<>;3e[3`TTS a6WyWH|mk`v=&$,_|GS%!>;kao(~60U_/' );
define( 'SECURE_AUTH_KEY',  '~^!L-2HfU*Ld)LWxaE+6|w+}YL(eI$$wGwWBN^L%3KKw%HM` `S?83?W@v__*Sk}' );
define( 'LOGGED_IN_KEY',    '.25%h#`/]Yt|J:b#!TvbMwp%jEZMSCeX^OD}@q&uMV_y XlY+S#f7xdY5gy0UH@E' );
define( 'NONCE_KEY',        'DrL0e5NaoKG,,cz $l|<qxWgW342RW$zl-?{>22{HE%gqN8L~BAmRIXBphQ#JRb/' );
define( 'AUTH_SALT',        'VCtvtr*>M8cAb&_.;i*C0nHC,79!jn+X~pI~aD7!D=I`i<(lmibX^+XhRnkUBONl' );
define( 'SECURE_AUTH_SALT', 'am.OTADe7MU6~(zeTH>2kNzJnB0eOXvX._Oip)AxklglS9*YG*?rq/0Cq2K0B8>r' );
define( 'LOGGED_IN_SALT',   '&A9$rxHMnHu)Sg/lM8|Nx#!I4/jeqJw59Kc+03UkJt>ofstI,x#V,qcGXI50?pq8' );
define( 'NONCE_SALT',       'F^Lnh|fMhouXZuR(zt$!6|Xos2Hza& (FdP#^m:?<Pvs[`1_`9}u]m:m.%EGy(M%' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
