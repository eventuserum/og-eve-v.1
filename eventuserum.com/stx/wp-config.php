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
define('DB_NAME', 'eventuse_wordpressf8e');

/** MySQL database username */
define('DB_USER', 'eventuse_wordf8e');

/** MySQL database password */
define('DB_PASSWORD', 'KN4wBFCeeRjJ');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY', '*lnDEkc{{/Iaur_KY$$u^=-HAQsxw;lRM;[x$%sFnqTfU^&nLTvctItw^[&-ix|Z]K<iiu&awRvrT$_qrLpDCX[j>PS--?sizC(k;A_ylv|hgQ<{mTzYcu/Gxt=Y%b^e');
define('SECURE_AUTH_KEY', 'b@DbyN*}(MaQQr[bIRsnj||N>SDCzZ<JG+*^W[ifROss^fbNYP+nG)p%X(TM|nIIpLSHgb+mMP+z^LE>X^_lvqc]TZiaAsr>LC*kSTfSxIx=M%H!(<%*%){!nu>JNNnJ');
define('LOGGED_IN_KEY', 'h}!tPN?*dbM@g-p{Jp<@SEYhNX@y=@QHrLB&V&Qls?qwW?PbbIV-fO}=xjE_WlXfYCX-;sjgNGhgIgm%OLiw+i/)G?x{OLCXgRy&oS!n+$</b%AeV}nyC^wD(VpA/D@}');
define('NONCE_KEY', '^NH$YvHLZGpr!H@a&JZCRXJ}t)f>yCQ|?mGD[tlO{GP{[qIlCFmRc)b*W];qFaSAI)rr}qrZin+*$TAF[g_Lq=+*A|/i+-X!eNwlZ}Qi|>x=eXGKc+RtF&vMDHTN$pX_');
define('AUTH_SALT', 'p^m|yi@zlrvNh_A}$g^i)pcd^?FsEwY/%<HmbsN+Z$>WkvO[|elbAP_@FlqP$jpG(;odn>Mjt|dvARJ(?[pewCqIuAAmq^]rlNo+Mz{}MLQ!utbNU)}kOy}<[@vTnLBU');
define('SECURE_AUTH_SALT', 'enUrc)d^oVg>L|QsGmSUvLlNZEEYgsaTt<oNuAw;QAq+xYkey=oR]rnkoG)EHk;P=)!UFR=O|f%BNObp*Sc>YsGa]!ez^Dr@m/qFu+kIS%nb_+RBJV]cLoIVIHJor)sT');
define('LOGGED_IN_SALT', ']{pXX])@|jsm%?(]e]-?WatoTzgzW}jOD%&fz&xxdnXeyU*I{gblDfbCGu-}FS-T]j/^nZ}@Nw>$ngzCeRr_g$>_X|c<LZvOE{+CLv+yE<MmCs||JX^I+y|}bzH>%Dk%');
define('NONCE_SALT', 'ZQ?N&Q*Sdt!@}nHg)|GAIjJYwGUfi)E%HoaWCGddQ-Xd+H]MGITYN@L=L;cfXo%oJow@fxqTuiM;OK/g()+]XWMlniie;r-c|gI{xou(Uc*tiBRM-r!WfeikZPgiOO%L');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_rvca_';

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
