<?php

/**
 * @wordpress-plugin
 * Plugin Name:       PayPal Payment Buttons
 * Plugin URI:        https://www.premiumdev.com/
 * Description:       PayPal Payment Buttons Developed by an Certified PayPal Developer, official PayPal Partner.
 * Version:           1.0.5
 * Author:            mbj-webdevelopment
 * Author URI:        https://www.premiumdev.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       paypal-payment-buttons
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!defined('PAYPAL_BUTTON_PLUGIN_BASENAME')) {
    define('PAYPAL_BUTTON_PLUGIN_BASENAME', plugin_basename(__FILE__));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-paypal-payment-buttons-activator.php
 */
function activate_paypal_payment_buttons() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-paypal-payment-buttons-activator.php';
    Paypal_Payment_Buttons_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-paypal-payment-buttons-deactivator.php
 */
function deactivate_paypal_payment_buttons() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-paypal-payment-buttons-deactivator.php';
    Paypal_Payment_Buttons_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_paypal_payment_buttons');
register_deactivation_hook(__FILE__, 'deactivate_paypal_payment_buttons');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-paypal-payment-buttons.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_paypal_payment_buttons() {

    $plugin = new Paypal_Payment_Buttons();
    $plugin->run();
}

run_paypal_payment_buttons();