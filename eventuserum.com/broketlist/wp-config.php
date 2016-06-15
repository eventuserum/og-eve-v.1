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
define('DB_NAME', 'eventuse_wordpress6ca');

/** MySQL database username */
define('DB_USER', 'eventuse_word6ca');

/** MySQL database password */
define('DB_PASSWORD', 'eIXjxOdiuDjb');

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
define('AUTH_KEY', '@ai&u}al*cvjy-+JdproQ@!xypu;|i<FP>exCGSwPPhGHetesiW)GTyz&]Yt+got]u|*$]|HaPKP_uHYhNn{eEFyvSV%RBg$}*O-JZs+(m/s|>vH/URcISq&so$oY%FO');
define('SECURE_AUTH_KEY', 'A!Lvv)VPOs])>icBUfqiCtrc[[(DEdfRkkYK/PyX{P!iOatCPrGq;_;}$^gh)!-SnBXvMm=I&CHTy$?ZYopvJuR_Cz}M@plt_nAFi+NUZST_]Fyng;)|/wYHzg;qg|(c');
define('LOGGED_IN_KEY', 'n)i]=VvclPafwo!f%?Hbu_;!MmxS|ubljhxw+iqHNVpmv/|TPhRR_[K<ZcQCguKG&ZHpDFGFMbSWIW_bYv[Q}AWCD=htN[yB/>!/UH!(J-acq[NvS>H]uTMHUuPkzZxc');
define('NONCE_KEY', 'L-ozHpis{/qUH{M;TE&jEbkGbJEYM>yUR_>KBdE$oBK+NP&nKhF%QquTV<Yz(D(KIlnZXD|tR<dPBl&F$/PZ=t?qJE<[%HdM*(YaFEbNyPjR@P!H$uE*-Zi)^prYAg%<');
define('AUTH_SALT', 'lSDXmHuMCdXFuUycpfoH;;p!kJQ;ELQvZ>$D{;wXvnVF?z+Od+pXY{}wsZnJ[$wIpxdgFEJ]U*v&*(lNL;_p|q&YSojDk$nMKu^yh}huoorRBoT]Z([qdI+nubeCfs_{');
define('SECURE_AUTH_SALT', 'OIOD=|meUG*OFmU>JwkUhccf+taEsa|wZyX%&&_*FAhGFW&lVPeqM?Mw@lS;$UREmEGawO|aN%qjs&(xOxRepJP[/)S>vD*ud_NMkoo=%MfpFpC?A|kt-]yT+FWrXn>l');
define('LOGGED_IN_SALT', 'VJsZ(r*]+q=xSZtaj@InB-jnuTPMZBQ^]sfxSear;TXd=xeYP&waaNzUm/QDb%wt*bapO/jL}obeZ+|k$tG)PJvyC@Lk_sx@$}=zj&muTsIt+EzZ$+lLH|<aH!cO?YQ-');
define('NONCE_SALT', 'Ye+/*_mtKCQp{VYIklm}^fIaeW;^=T!K|h=RB|awIviCuOqCr|%FV%B?HAba{H%[;>|e^LF^i>Np=pakQ(PlEixYVd*f$wMa+;sc>DoDlR]TZ>V<oT<ltyd(kKlCN|gr');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_uwis_';

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
