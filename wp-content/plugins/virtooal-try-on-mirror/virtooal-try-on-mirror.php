<?php
/**
 * Plugin Name: Virtooal Try-on Mirror
 * Plugin URI: http://wordpress.org/plugins/virtooal-try-on-mirror/
 * Description: This plugin allows to quickly install Virtooal Try-on Mirror on any WooCommerce website.
 * Version: 1.1.8
 * WC requires at least: 3.0.0
 * WC tested up to: 4.1.0
 * Author: Virtooal
 * Author URI: https://try.virtooal.com
 * Text Domain: virtooal-try-on-mirror
 * Copyright: © 2020 Virtooal.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	// Check if there is admin user
	if ( is_admin() ) {
		require_once( dirname( __FILE__ ) . '/src/class-virtooal-try-on-mirror-admin.php' );
		$virtooal_try_on_mirror = new Virtooal_Try_On_Mirror_Admin();
	} else {
		require_once( dirname( __FILE__ ) . '/src/class-virtooal-try-on-mirror.php' );
		$virtooal_try_on_mirror = new Virtooal_Try_On_Mirror();
	}

	$virtooal_try_on_mirror->init();
} else {
	//wp_die('Sorry, but this plugin requires the Parent Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
}

add_action( 'admin_init', 'virtooal_has_woocommerce' );
function virtooal_has_woocommerce() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) && !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        add_action( 'admin_notices', 'virtooal_notice' );

        deactivate_plugins( plugin_basename( __FILE__ ) );

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}

function virtooal_notice(){
	echo '<div class="error"><p>' . __( 
		'Sorry, but Virtooal Try-on Mirror requires WooCommerce version 3.0.0 or above to be installed and active.', 
		'virtooal-try-on-mirror' 
	) .'</p></div>';
}