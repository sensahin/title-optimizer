<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://twitter.com/sengpt
 * @since             1.0.0
 * @package           Title_Optimizer
 *
 * @wordpress-plugin
 * Plugin Name:       Title Optimizer
 * Plugin URI:        https://titleoptimizer.com
 * Description:       Title Optimizer harnesses the power of OpenAI technology to optimize your WordPress content titles. It's the perfect tool for crafting compelling, SEO-friendly, and reader-engaging headlines with just a click. Elevate your titles to perfection!
 * Version:           1.0.0
 * Author:            Senol Sahin
 * Author URI:        https://twitter.com/sengpt/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       title-optimizer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TITLE_OPTIMIZER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-title-optimizer-activator.php
 */
function activate_title_optimizer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-title-optimizer-activator.php';
	Title_Optimizer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-title-optimizer-deactivator.php
 */
function deactivate_title_optimizer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-title-optimizer-deactivator.php';
	Title_Optimizer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_title_optimizer' );
register_deactivation_hook( __FILE__, 'deactivate_title_optimizer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-title-optimizer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_title_optimizer() {

	$plugin = new Title_Optimizer();
	$plugin->run();

}
run_title_optimizer();
