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
define( 'DB_NAME', 'digrix_db' );

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
define( 'AUTH_KEY',         ';0N9>zIw=K:QpUs9N,=dj$?PiSZgCl77BuhPrOF8^ySMFV,q03lsCQgj8+Iq1-/h' );
define( 'SECURE_AUTH_KEY',  'o:n9VBiBJE^F75p^_yD[x2N!J>_CW0}fbVhG9J!$.V2P6a~as*d;(c]KCP9sv#uy' );
define( 'LOGGED_IN_KEY',    '(N?|:^5^soG^!p6vrMx b*p++OS6PP@UM9ACrJJn7_k >D @7{7gRO0KK1riR- C' );
define( 'NONCE_KEY',        ',g&Bcd]pr  O|a.W]X&mA,T~c,,bF_g|]0z={.oD%[Gf)ikp/L~`ocIQL 4<~1SU' );
define( 'AUTH_SALT',        '@O35<j75d:<D-N>JQERRQFO{(]b}%maI85iS90IQJ&gy;d})wfR1OsMA?d7IqzMG' );
define( 'SECURE_AUTH_SALT', '3SvS~,,4Q5%n~]v6l^m{.^|({9r&[ 4j,=5Q[b@!@M& yO3w-qe}ew?8_aVDaQsn' );
define( 'LOGGED_IN_SALT',   'EMxM^itHgF{u%%}O9bwQaC&i;6F.w&3?JN,hLap$4Ko>`2-!7w$H7>^^||B- 9as' );
define( 'NONCE_SALT',       '];!7H);p*<F{ =`E)7TyFyHkRc.vF}~%>Q&1`Y~P[#J8RxHJdFaictT,3izlwFyR' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'dx_';

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
