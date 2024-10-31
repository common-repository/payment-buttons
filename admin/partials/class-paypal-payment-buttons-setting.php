<?php

/**
 * @since      1.0.0
 * @package    Paypal_Payment_Buttons
 * @subpackage Paypal_Payment_Buttons/includes
 * @author     mbj-webdevelopment <mbjwebdevelopment@gmail.com>
 */
class Paypal_Payment_Buttons_Buttons_Setting {

    public static function init() {
        add_action('paypal_payment_buttons_setting', array(__CLASS__, 'paypal_payment_buttons_setting'), 12);
        add_action('paypal_payment_buttons_setting_save_field', array(__CLASS__, 'paypal_payment_buttons_setting_save_field'), 8);
    }

    public static function paypal_for_wordpress_payment_button_setting_fields() {
        $fields[] = array('title' => __('Paypal Payment Buttons Options Setting Panel', 'paypal-payment-buttons'), 'type' => 'title', 'desc' => '', 'id' => 'general_options');
        $fields[] = array(
            'title' => __('Paypal Merchant id / PayPal Email', 'paypal-payment-buttons'),
            'desc' => __('<a target="_blank" href="https://www.paypal-community.com/t5/Selling-on-your-website/how-do-I-find-my-merchant-id/td-p/284430?profile.language=en-gb">Need help?</a>', 'paypal-payment-buttons'),
            'id' => 'merchant_id',
            'type' => 'text',
            'css' => 'min-width:300px;',
        );
        $fields[] = array('type' => 'sectionend', 'id' => 'general_options');
        return $fields;
    }

    public static function paypal_payment_buttons_setting() {
        $paypal_payment_buttons_setting_fields = self::paypal_for_wordpress_payment_button_setting_fields();
        $Html_output = new Paypal_Payment_Buttons_Html_output();
        ?>
        <form id="paypal_payment_buttons_form" enctype="multipart/form-data" action="" method="post">
        <?php $Html_output->init($paypal_payment_buttons_setting_fields); ?>
            <p class="submit">
                <input type="submit" name="paypal_payment_buttons" class="button-primary" value="<?php esc_attr_e('Save changes', 'Option'); ?>" />
            </p>
        </form>
        <?php
    }

    public static function paypal_payment_buttons_setting_save_field() {
        $paypal_payment_buttons_setting_fields = self::paypal_for_wordpress_payment_button_setting_fields();
        $Html_output = new Paypal_Payment_Buttons_Html_output();
        $Html_output->save_fields($paypal_payment_buttons_setting_fields);
    }

}

Paypal_Payment_Buttons_Buttons_Setting::init();