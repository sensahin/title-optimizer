<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://twitter.com/sengpt
 * @since      1.0.0
 *
 * @package    Title_Optimizer
 * @subpackage Title_Optimizer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Title_Optimizer
 * @subpackage Title_Optimizer/admin
 * @author     Senol Sahin <senols@gmail.com>
 */
class Title_Optimizer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
		add_action('admin_init', array($this, 'register_plugin_settings'));
		add_filter('post_row_actions', array($this, 'add_improve_title_link'), 10, 2);
		add_action('wp_ajax_improve_title_action', array($this, 'improve_title_function'));
	}

	public function add_plugin_admin_menu() {
		add_menu_page(
			'Title Optimizer', 
			'Title Optimizer', 
			'manage_options', 
			'title-optimizer', 
			array($this, 'display_plugin_admin_page'), 
			'dashicons-admin-generic'
		);
	}



	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Title_Optimizer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Title_Optimizer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/title-optimizer-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style('thickbox');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Title_Optimizer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Title_Optimizer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/title-optimizer-admin.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script('thickbox');

	}

	public function display_plugin_admin_page() {
		include_once('partials/title-optimizer-admin-display.php');
	}

	public function register_plugin_settings() {
		register_setting('title_optimizer_options_group', 'title_optimizer_api_key');
		register_setting('title_optimizer_options_group', 'title_optimizer_enable');
	}

	public function add_improve_title_link($actions, $post) {
		// Eğer "Enable" seçeneği aktifse linki ekle
		if (get_option('title_optimizer_enable') == 1) {
			$actions['improve_title'] = '<a href="#" class="improve-title-action" data-post-id="' . $post->ID . '">Improve This Title</a>';
		}
		return $actions;
	}
	

	public function improve_title_function() {
		$postId = $_POST['post_id'];
		$postTitle = get_the_title($postId);
		
		$apiKey = get_option('title_optimizer_api_key');
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
			"model" => "gpt-3.5-turbo",
			"messages" => array(
				array(
					"role" => "system",
					"content" => "You are a helpful assistant."
				),
				array(
					"role" => "user",
					"content" => "Improve this title: " . $postTitle
				)
			)
		)));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"Authorization: Bearer " . $apiKey
		));
	
		$response = curl_exec($ch);
		curl_close($ch);
		$responseArr = json_decode($response, true);
	
		$improvedTitle = $responseArr['choices'][0]['message']['content'];
		
		// Başlığı güncelleme
		wp_update_post(array(
			'ID' => $postId,
			'post_title' => $improvedTitle
		));
		
		echo "Title improved successfully!";
		wp_die();
	}
	


}
