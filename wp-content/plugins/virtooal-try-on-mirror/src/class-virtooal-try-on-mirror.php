<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'interface-virtooal-try-on-mirror.php' );

/*
* Virtooal_Try_On_Mirror class
*/
class Virtooal_Try_On_Mirror implements Virtooal_Try_On_Mirror_Interface
{
	private $is_div_open = false;

	private $plugin_version = '1.1.8';

	protected $apikey;
	protected $username;
	protected $automirror;

	public function __construct() {
		$this->apikey     = get_option( 'virtooal-apikey' );
		$this->username   = get_option( 'virtooal-username' );
		$this->automirror = get_option( 'virtooal-automirror' );
	}

	//Set up base actions
	public function init() {
		//small mirror
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'show_small_mirror' ), 5 );
		if(!$this->automirror) {
			// try button
			add_action( 'woocommerce_after_add_to_cart_quantity', array( $this, 'add_open_div' ) );
			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'show_try_button_single' ) );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'show_try_button_loop' ), 20 );
			// big mirror0
			add_action( 'wp_footer', array( $this, 'show_big_mirror' ) );
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts_styles' ) );

		// load the settings
		$settings = wp_remote_retrieve_body( 
			wp_remote_get( 'https://api.virtooal.com/api/settings?api_key=' . $this->apikey ) 
		);

	    if ( $settings ) {
	        $this->virtooal_settings = json_decode( $settings );
		}
	}

	public function load_scripts_styles() {
		if ( !$this->username || !$this->apikey ) {
			return;
		}
		wp_enqueue_style( 'wc-virtooal-style', plugins_url( 'css/style.css', __FILE__ ), array(), $this->plugin_version );

		if($this->automirror) {
			wp_enqueue_script( 
				'virtooal-automirror', 
				'//mirror.virtooal.com/assets/js/automirror.php?p=' . $this->virtooal_settings->username . '&a=' . $this->apikey, 
				array(), 
				$this->plugin_version,
				true
			);
		} else {
			wp_enqueue_script( 
				'virtooal-mirror-widget',
				'https://mirror.virtooal.com/assets/js/widget.js',
				array(),
				$this->plugin_version,
				true
			);
			wp_add_inline_script( 
				'virtooal-mirror-widget',
				'virtooalMirrorSettings = { userName: "' . $this->username . '" } ' 
			);
			wp_enqueue_script( 
				'virtooal-crossmirror',
				'https://mirror.virtooal.com/assets/js/crossmirror.php?api_key=' . $this->apikey . '&_t='.date('Ymd'),
				array(),
				$this->plugin_version,
				true
			);
		}

		if( is_product() ) {
			wp_enqueue_script(
				'virtooal-widget',
				'//widget.virtooal.com/' . $this->username . '/' . $this->apikey . '/en/' . get_the_ID(),
				array(),
				$this->plugin_version,
				true
			);
		}
		
	}

	public function show_small_mirror() {
		global $product;
		$product_id = $product->get_id();
		if ( $this->username && $this->apikey && $product_id ) {
			$this->render( 'small-mirror.php' );
		}
	}

	public function show_big_mirror() {
		if ( ( is_woocommerce() || is_front_page() ) &&  $this->username && $this->apikey ) {
			$this->render('big-mirror.php');
		}
	}

	public function add_open_div() {
		if ( !$this->is_div_open ) {
			echo '<div style="overflow: hidden;">';
			$this->is_div_open = true;
		}
	}

	public function show_try_button_single() {
		$this->show_try_button( 'try-button-single' );
		if ( $this->is_div_open ) echo '</div>';
	}

	public function show_try_button_loop() {
		$this->show_try_button( 'try-button-loop' );
	}

	private function show_try_button( $view ){
		if($this->automirror == 1) {
			return;
		}
		global $product;
		$product_id = $product->get_id();

		if ( isset( $this->virtooal_settings->tryon_text ) && $this->virtooal_settings->tryon_text != '' ) {
			$tryon_text = $this->virtooal_settings->tryon_text;
		} else {
			$tryon_text = 'TRY ON';
		}

		$this->render( $view . '.php', array(
			'product_id' => $product_id,
			'tryon_text' => $tryon_text,
		) );
	}

	//render template
	public function render( $template_name, array $parameters = array(), $render_output = true ) {
		foreach ( $parameters as $name => $value ) {
			${$name} = $value;
		}
		ob_start();
		include __DIR__ . '/../view/' . $template_name;
		$output = ob_get_contents();
		ob_end_clean();

		if ( $render_output ) {
			echo $output;
		} else {
			return $output;
		}
	}
}
