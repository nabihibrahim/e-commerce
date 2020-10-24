<?php
/**
 * إعدادات الووردبريس الأساسية
 *
 * عملية إنشاء الملف wp-config.php تستخدم هذا الملف أثناء التنصيب. لا يجب عليك
 * استخدام الموقع، يمكنك نسخ هذا الملف إلى "wp-config.php" وبعدها ملئ القيم المطلوبة.
 *
 * هذا الملف يحتوي على هذه الإعدادات:
 *
 * * إعدادات قاعدة البيانات
 * * مفاتيح الأمان
 * * بادئة جداول قاعدة البيانات
 * * المسار المطلق لمجلد الووردبريس
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** إعدادات قاعدة البيانات - يمكنك الحصول على هذه المعلومات من مستضيفك ** //

/** اسم قاعدة البيانات لووردبريس */
define( 'DB_NAME', 'test-ecommerce' );

/** اسم مستخدم قاعدة البيانات */
define( 'DB_USER', 'root' );

/** كلمة مرور قاعدة البيانات */
define( 'DB_PASSWORD', '' );

/** عنوان خادم قاعدة البيانات */
define( 'DB_HOST', 'localhost' );

/** ترميز قاعدة البيانات */
define( 'DB_CHARSET', 'utf8mb4' );

/** نوع تجميع قاعدة البيانات. لا تغير هذا إن كنت غير متأكد */
define( 'DB_COLLATE', '' );

/**#@+
 * مفاتيح الأمان.
 *
 * استخدم الرابط التالي لتوليد المفاتيح {@link https://api.wordpress.org/secret-key/1.1/salt/}
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '1$]&RYe:>Wx#u!yf;jF Fl/#e{^`.z>/6EpC/9Vt[d*} )(tIr#o*jd{yFOzSh9+' );
define( 'SECURE_AUTH_KEY',  'w)E@h2[*:8s8)|r)X/>|*u>#}3q_,;I5^XzCWYpjB>hKhCBhPo)(?&m9te Ye;wu' );
define( 'LOGGED_IN_KEY',    '<hW@Bhd6JU@3T4i_%w6~Oh SF$~IG|O2f(5WNu[Z]}mA@(9?|.C]r[II9[Bhwy3z' );
define( 'NONCE_KEY',        '8AE+*^!;T;Cj<)pgWJOaD0i]G+GDp}.2JdBuC&UnZ[ew-:Igrv1-Wxz9=NwXcMRf' );
define( 'AUTH_SALT',        'gM8ZARKduOu9;JjA}ATE#=T.jz0qR,>$q<w[K;f32UcPmr:W/Ap7@JB:X.hJ58[_' );
define( 'SECURE_AUTH_SALT', 'px?-[8Hf+TErg0-PC>uqb<{{x.BLB|yEoDRDX.#IQ11I1PY0X>09={U?.G|h4)wL' );
define( 'LOGGED_IN_SALT',   ')},Z2tCF+)9}g=%>V.LFh!w}K@[v}[t~]S9lZir0e:pC]nZ`I35`*&!WQ^DRm0!H' );
define( 'NONCE_SALT',       'Q4io5k$AC(~[#D1~Q`+5&IQR&jdLBe)02th_yHTEsTC7[_S=Ca/heiwn36E]$x2u' );

/**#@-*/

/**
 * بادئة الجداول في قاعدة البيانات.
 *
 * تستطيع تركيب أكثر من موقع على نفس قاعدة البيانات إذا أعطيت لكل موقع بادئة جداول مختلفة
 * يرجى استخدام حروف، أرقام وخطوط سفلية فقط!
 */
$table_prefix = 'wp_';

/**
 * للمطورين: نظام تشخيص الأخطاء
 *
 * قم بتغييرالقيمة، إن أردت تمكين عرض الملاحظات والأخطاء أثناء التطوير.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* هذا هو المطلوب، توقف عن التعديل! نتمنى لك التوفيق. */

/** المسار المطلق لمجلد ووردبريس. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** إعداد متغيرات الووردبريس وتضمين الملفات. */
require_once( ABSPATH . 'wp-settings.php' );
