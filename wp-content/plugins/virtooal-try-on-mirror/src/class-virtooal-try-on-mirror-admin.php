<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'interface-virtooal-try-on-mirror.php' );
require_once( 'class-virtooal-try-on-mirror.php' );

/*
* Virtooal_Try_On_Mirror_Admin class for setting virtooal settings.
*/
class Virtooal_Try_On_Mirror_Admin extends Virtooal_Try_On_Mirror implements Virtooal_Try_On_Mirror_Interface
{
	//Set up base actions
	public function init() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_filter( 'woocommerce_product_data_tabs', array ( $this, 'add_product_data_tab' ), 99, 1 ) ;
		add_action( 'woocommerce_product_data_panels', array ( $this, 'add_product_data_panel' ) );
	}

	public function add_product_data_panel() {
		global $woocommerce;
		$query_data = array();
		if ( $this->username && $this->apikey ) {
			$product_id = get_the_ID();
			$product = wc_get_product( $product_id );
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
			$query_data['url'] = get_permalink( $product_id );
			if ($image) {
				$query_data['img'] = $image[0];
			}
			$query_data['title']      = $product->get_name();
			$query_data['product_id'] = $product_id;
			$query_data['iframe']     = 1;
			$query_data['platform']   = 6;
			$this->render( 'data-panel.php', array(
				'query_data' => http_build_query($query_data),
			) );
		}
	}

	public function add_product_data_tab( $product_data_tabs ) {
		if ( $this->username && $this->apikey ) {
			$product_data_tabs['virtooal-tab'] = array(
				'label'  => __( 'Virtooal', 'virtooal-try-on-mirror' ),
				'target' => 'virtooal_product_data',
			);
		}
		return $product_data_tabs;
	}

	//Add plugin to woocommerce admin menu.
	public function admin_menu() {
		add_submenu_page( 'woocommerce', 'Virtooal', 'Virtooal', 'manage_options', 'wc-virtooal', array( $this, 'settings' ) );
		register_setting( 'virtooal-try-on-mirror', 'virtooal-username' );
		register_setting( 'virtooal-try-on-mirror', 'virtooal-apikey' );
		register_setting( 'virtooal-try-on-mirror', 'virtooal-automirror' );
	}
	//Output form with settings.
	public function settings() {
		$title =  __( 'Virtooal Setup', 'virtooal-try-on-mirror' );
		$site_url = home_url();
		$admin_url = admin_url();
		$this->render( 'admin-template.php', array(
			'title'               => $title,
			'site_url'            => $site_url,
			'admin_url'           => $admin_url,
			'virtooal_username'   => esc_attr($this->username),
			'virtooal_apikey'     => esc_attr($this->apikey),
			'virtooal_automirror' => esc_attr($this->automirror),
		) );
	}
}
