<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Paypal_Payment_Buttons
 * @subpackage Paypal_Payment_Buttons/admin
 * @author     mbj-webdevelopment <mbjwebdevelopment@gmail.com>
 */
class Paypal_Payment_Buttons_Admin {

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
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/paypal-payment-buttons-admin.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . '-bootstrap', plugin_dir_url(__FILE__) . 'css/paypal-payment-buttons-bootstrap.min.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/paypal-payment-buttons-admin.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . '-min', plugin_dir_url(__FILE__) . 'js/paypal-button.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . '-bootstrap', plugin_dir_url(__FILE__) . 'js/paypal-payment-buttons-bootstrap.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . '-app', plugin_dir_url(__FILE__) . 'js/paypal-button-app.js', array('jquery'), $this->version, false);
        $translation_array = array(
            'paypal_button_min_js' => __(plugin_dir_url(__FILE__) . 'js/paypal-button.min.js', 'paypal-payment-buttons')
        );
        wp_localize_script($this->plugin_name . '-min', 'paypal_payment_buttons_js', $translation_array);
    }

    public function paypal_payment_buttons_plugin_options_page() {
        add_options_page('PayPal Button', 'PayPal Button', 'manage_options', 'paypal-payment-buttons-setting-panel', array($this, 'paypal_payment_buttons_setting_panel_option_page'));
    }

    public function paypal_payment_buttons_setting_panel_option_page() {
        do_action('paypal_payment_buttons_setting_save_field');
        do_action('paypal_payment_buttons_setting');
        ?>
        <ul class="ppb-nav ppb-nav-tabs">
            <li class="active"><a data-toggle="tab" href="#buynow"><?php echo __('Buy Now', 'paypal-payment-buttons'); ?></a></li>
            <li class=""><a data-toggle="tab" href="#cart"><?php echo __('Add to Cart', 'paypal-payment-buttons'); ?></a></li>
            <li class=""><a data-toggle="tab" href="#donate"><?php echo __('Donate', 'paypal-payment-buttons'); ?></a></li>
            <li class=""><a data-toggle="tab" href="#subscribe"><?php echo __('Subscribe', 'paypal-payment-buttons'); ?></a></li>
        </ul>
        <div class="ppb-tab-content">
            <div id="buynow" class="ppb-tab-pane paypale-payment-button-example active">
                <p><?php echo __('Buy Now buttons are perfect for single item purchases', 'paypal-payment-buttons'); ?></p>
                <p style="color: #FF009F;font-size: 16px;"><?php echo __('<span>copy the code below and paste it on page or post or widget.', 'paypal-payment-buttons'); ?>
                    <a href="#buyNowModal" class="paypale-payment-button-edit" role="button" data-toggle="modal" data-keyboard="true"><span class="icon icon-edit"></span><?php echo __(' Customize &amp; Preview', 'paypal-payment-buttons'); ?></a></p>
                <textarea class="wp-ui-text-highlight code txtarea_response" readonly="readonly" cols="70" rows="10">&lt;script src="<?php echo plugin_dir_url(__FILE__) . 'js/paypal-button.min.js'; ?>?merchant=<?php echo get_option('merchant_id') ?>"
                                                                                            data-button="buynow"
                                                                                            data-name="My product"
                                                                                            data-amount="1.00"
                                                                                            async
                                                                                        &gt;&lt;/script&gt;</textarea>
                <div id="buyNowModal" class="ppb-modal hide fade" role="dialog" aria-hidden="true">
                    <div class="ppb-modal-dialog">
                        <div class="ppb-modal-content">
                            <form action="#" class="ppb-modal-body ppb-form-horizontal">
                                <input type="hidden" name="button" value="buynow">
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowMerchant"><?php echo __('Merchant', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowMerchant" name="business" required="required" value="<?php echo get_option('merchant_id'); ?>" autocomplete="off">
                                        <span class="ppb-help-inline"><?php echo __('Required', 'paypal-payment-buttons'); ?></span>
                                        <span class="ppb-help-inline"><?php echo __('Email address or merchant ID', 'paypal-payment-buttons'); ?></span>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowName"><?php echo __('Name', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowName" name="name" placeholder="My product" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowQuantity"><?php echo __('Quantity', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowQuantity" name="quantity" value="" placeholder="1" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowAmount"><?php echo __('Amount', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowAmount" name="amount" placeholder="5.00" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowCurrency"><?php echo __('Currency', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <select name="currency">
                                            <?php
                                            $get_currency = $this->Get_Currency_With_Code();
                                            foreach ($get_currency as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowShipping"><?php echo __('Shipping', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowShipping" name="shipping" placeholder="0.75" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowTax"><?php echo __('Tax', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowTax" name="tax" placeholder="3.50" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowCallback"><?php echo __('Callback URL', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowCallback" name="callback" placeholder="http://mysite.com/callback" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowEnvironment"><?php echo __('Environment', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <label class="checkbox">
                                            <input type="checkbox" id="buyNowEnvironment" name="env" value="sandbox">
                                            <?php echo __('Sandbox', 'paypal-payment-buttons'); ?>
                                        </label>
                                    </div>
                                </div>
                            </form>
                            <div class="ppb-modal-footer">
                                <button class="btn button" data-dismiss="modal"><?php echo __('Close', 'paypal-payment-buttons'); ?></button>
                                <button class="btn btn-primary button-primary" data-modal-save="true"><?php echo __('Preview', 'paypal-payment-buttons'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tryit">
                    <script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script><script src="<?php echo plugin_dir_url(__FILE__) . 'js/paypal-button.min.js'; ?>?merchant=" data-button="buynow" data-name="My product!" data-amount="1.00" async=""></script>
                </div>
            </div>
            <div id="cart" class="ppb-tab-pane paypale-payment-button-example">
                <p><?php echo __('Add To Cart buttons let users add multiple items instantly giving your website a cart ', 'paypal-payment-buttons'); ?></p>
                <p style="color: #FF009F;font-size: 16px;"><?php echo __('<span>copy the code below and paste it on page or post or widget.', 'paypal-payment-buttons'); ?>                
                    <a href="#cartModal" class="paypale-payment-button-edit" role="button" data-toggle="modal" data-keyboard="true"><span class="icon icon-edit"></span><?php echo __(' Customize &amp; Preview', 'paypal-payment-buttons'); ?></a></p>
                <textarea class="wp-ui-text-highlight code txtarea_response" readonly="readonly" cols="70" rows="10">&lt;script src="<?php echo plugin_dir_url(__FILE__) . 'js/paypal-button.min.js'; ?>?merchant=<?php echo get_option('merchant_id') ?>"
                                                                                            data-button="cart"
                                                                                            data-name="Product in your cart"
                                                                                            data-amount="1.00"
                                                                                            async
                                                                                        &gt;&lt;/script&gt;</textarea>
                <div id="cartModal" class="ppb-modal hide fade" role="dialog" aria-hidden="true">
                    <div class="ppb-modal-dialog">
                        <div class="ppb-modal-content">
                            <form action="#" class="ppb-modal-body ppb-form-horizontal">
                                <input type="hidden" name="button" value="cart">
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="cartMerchant"><?php echo __('Merchant', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="cartMerchant" name="business" required="required" value="<?php echo get_option('merchant_id'); ?>" autocomplete="off">
                                        <span class="ppb-help-inline"><?php echo __('Required', 'paypal-payment-buttons'); ?></span>
                                        <span class="ppb-help-inline"><?php echo __('Email address or merchant ID', 'paypal-payment-buttons'); ?></span>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="cartName"><?php echo __('Name', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="cartName" name="name" required="required" placeholder="Product in your cart" value="" autocomplete="off">
                                        <span class="ppb-help-inline"><?php echo __('Required', 'paypal-payment-buttons'); ?></span>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="cartQuantity"><?php echo __('Quantity', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="cartQuantity" name="quantity" value="" placeholder="1" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="cartAmount"><?php echo __('Amount', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="cartAmount" name="amount" required="required" placeholder="5.00" value="" autocomplete="off">
                                        <span class="ppb-help-inline"><?php echo __('Required', 'paypal-payment-buttons'); ?></span>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="cartCurrency"><?php echo __('Currency', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <select name="currency">
                                            <?php
                                            $get_currency = $this->Get_Currency_With_Code();
                                            foreach ($get_currency as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="cartShipping"><?php echo __('Shipping', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="cartShipping" name="shipping" placeholder="0.75" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="cartTax"><?php echo __('Tax', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="cartTax" name="tax" placeholder="3.50" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="cartCallback"><?php echo __('Callback URL', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="cartCallback" name="callback" value="" autocomplete="off" placeholder="http://mysite.com/callback">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="cartEnvironment"><?php echo __('Environment', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <label class="checkbox">
                                            <input type="checkbox" id="cartEnvironment" name="env" value="sandbox">
                                            <?php echo __('Sandbox', 'paypal-payment-buttons'); ?>
                                        </label>
                                    </div>
                                </div>
                            </form>
                            <div class="ppb-modal-footer">
                                <button class="btn button " data-dismiss="modal"><?php echo __('Close', 'paypal-payment-buttons'); ?></button>
                                <button class="btn btn-primary button-primary" data-modal-save="true"><?php echo __('Preview', 'paypal-payment-buttons'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tryit">
                    <script src="<?php echo plugin_dir_url(__FILE__) . 'js/paypal-button.min.js'; ?>?merchant=" data-button="cart" data-name="Product in your cart" data-amount="1.00" async=""></script>
                </div>
            </div>
            <div id="donate" class="ppb-tab-pane paypale-payment-button-example">
                <p><?php echo __('Donate buttons are great for accepting donations from users ', 'paypal-payment-buttons'); ?></p>
                <p style="color: #FF009F;font-size: 16px;"><?php echo __('<span>copy the code below and paste it on page or post or widget.', 'paypal-payment-buttons'); ?>
                    <a href="#donateModal" class="paypale-payment-button-edit" role="button" data-toggle="modal" data-keyboard="true"><span class="icon icon-edit"></span><?php echo __(' Customize &amp; Preview', 'paypal-payment-buttons'); ?></a></p>
                <textarea class="wp-ui-text-highlight code txtarea_response" readonly="readonly" cols="70" rows="10">&lt;script src="<?php echo plugin_dir_url(__FILE__) . 'js/paypal-button.min.js'; ?>?merchant=<?php echo get_option('merchant_id') ?>"
                                                                                            data-button="donate"
                                                                                            data-name="My product"
                                                                                            data-amount="1.00"
                                                                                            async
                                                                                        &gt;&lt;/script&gt;</textarea>
                <div id="donateModal" class="ppb-modal hide fade" role="dialog" aria-hidden="true">
                    <div class="ppb-modal-dialog">
                        <div class="ppb-modal-content">
                            <form action="#" class="ppb-modal-body ppb-form-horizontal">
                                <input type="hidden" name="button" value="donate">
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowMerchant"><?php echo __('Close', 'paypal-payment-buttons'); ?>Merchant</label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowMerchant" name="business" required="required" value="<?php echo get_option('merchant_id'); ?>" autocomplete="off">
                                        <span class="ppb-help-inline"><?php echo __('Required', 'paypal-payment-buttons'); ?></span>
                                        <span class="ppb-help-inline"><?php echo __('Email address or merchant ID', 'paypal-payment-buttons'); ?></span>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowName"><?php echo __('Name', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowName" name="name" placeholder="My product" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowQuantity"><?php echo __('Quantity', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowQuantity" name="quantity" value="" placeholder="1" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowAmount"><?php echo __('Amount', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowAmount" name="amount" placeholder="5.00" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowCurrency"><?php echo __('Currency', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <select name="currency">
                                            <?php
                                            $get_currency = $this->Get_Currency_With_Code();
                                            foreach ($get_currency as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowShipping"><?php echo __('Shipping', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowShipping" name="shipping" placeholder="0.75" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowTax"><?php echo __('Tax', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowTax" name="tax" placeholder="3.50" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowCallback"><?php echo __('Callback URL', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowCallback" name="callback" placeholder="http://mysite.com/callback" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowEnvironment"><?php echo __('Environment', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <label class="checkbox">
                                            <input type="checkbox" id="buyNowEnvironment" name="env" value="sandbox">
                                            <?php echo __('Sandbox', 'paypal-payment-buttons'); ?>
                                        </label>
                                    </div>
                                </div>
                            </form>
                            <div class="ppb-modal-footer">
                                <button class="btn button" data-dismiss="modal"><?php echo __('Close', 'paypal-payment-buttons'); ?></button>
                                <button class="btn btn-primary button-primary" data-modal-save="true"><?php echo __('Preview', 'paypal-payment-buttons'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tryit">
                    <script src="<?php echo plugin_dir_url(__FILE__) . 'js/paypal-button.min.js'; ?>?merchant=" data-button="donate" data-name="My product!" data-amount="1.00" async=""></script>
                </div>
            </div>
            <div id="subscribe" class="ppb-tab-pane paypale-payment-button-example">
                <p><?php echo __('Subscribe buttons can be used to set up payment subscriptions with your users ', 'paypal-payment-buttons'); ?></p>
                <p style="color: #FF009F;font-size: 16px;"><?php echo __('<span>copy the code below and paste it on page or post or widget.', 'paypal-payment-buttons'); ?>   
                    <a href="#subscribeModal" class="paypale-payment-button-edit" role="button" data-toggle="modal" data-keyboard="true"><span class="icon icon-edit"></span><?php echo __(' Customize &amp; Preview', 'paypal-payment-buttons'); ?></a></p>
                <textarea class="wp-ui-text-highlight code txtarea_response" readonly="readonly" cols="70" rows="10">&lt;script src="<?php echo plugin_dir_url(__FILE__) . 'js/paypal-button.min.js'; ?>?merchant=<?php echo get_option('merchant_id') ?>"
                                                                                            data-button="subscribe"
                                                                                            data-name="My product"
                                                                                            data-amount="1.00"
                                                                                            data-recurrence="1"
                                                                                            data-period="M"
                                                                                            async
                                                                                        &gt;&lt;/script&gt;               
                </textarea>
                <div id="subscribeModal" class="ppb-modal hide fade" role="dialog" aria-hidden="true">
                    <div class="ppb-modal-dialog">
                        <div class="ppb-modal-content">
                            <form action="#" class="ppb-modal-body ppb-form-horizontal">
                                <input type="hidden" name="button" value="subscribe">
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowMerchant"><?php echo __('Merchant', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowMerchant" name="business" required="required" value="<?php echo get_option('merchant_id'); ?>" autocomplete="off">
                                        <span class="ppb-help-inline"><?php echo __('Required', 'paypal-payment-buttons'); ?></span>
                                        <span class="ppb-help-inline"><?php echo __('Email address or merchant ID', 'paypal-payment-buttons'); ?></span>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowName"><?php echo __('Name', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowName" name="name" placeholder="My product" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowRecurringAmount"><?php echo __('Amount', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowRecurringAmount" name="amount" placeholder="5.00" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowRecurringCurrency"><?php echo __('Currency', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <select name="currency">
                                            <?php
                                            $get_currency = $this->Get_Currency_With_Code();
                                            foreach ($get_currency as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowNumberOfPeriods"><?php echo __('Recurrences', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowNumberOfPeriods" name="recurrence" placeholder="2" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowPeriodType"><?php echo __('Type of Period', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <select id="buyNowPeriodType" name="period">
                                            <option value="D"><?php echo __('Days', 'paypal-payment-buttons'); ?></option>
                                            <option value="W"><?php echo __('Weeks', 'paypal-payment-buttons'); ?></option>
                                            <option value="M"><?php echo __('Months', 'paypal-payment-buttons'); ?></option>
                                            <option value="Y"><?php echo __('Years', 'paypal-payment-buttons'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowCallback"><?php echo __('Callback URL', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <input type="text" id="buyNowCallback" name="callback" placeholder="http://mysite.com/callback" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="ppb-control-group">
                                    <label class="ppb-control-label" for="buyNowEnvironment"><?php echo __('Environment', 'paypal-payment-buttons'); ?></label>
                                    <div class="ppb-controls">
                                        <label class="checkbox">
                                            <input type="checkbox" id="buyNowEnvironment" name="env" value="sandbox">
                                            <?php echo __('Sandbox', 'paypal-payment-buttons'); ?>
                                        </label>
                                    </div>
                                </div>
                            </form>
                            <div class="ppb-modal-footer">
                                <button class="btn button" data-dismiss="modal"><?php echo __('Close', 'paypal-payment-buttons'); ?></button>
                                <button class="btn btn-primary button-primary" data-modal-save="true"><?php echo __('Preview', 'paypal-payment-buttons'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tryit">
                    <script src="<?php echo plugin_dir_url(__FILE__) . 'js/paypal-button.min.js'; ?>?merchant=" data-button="subscribe" data-name="My product!" data-a3="1.00" data-p3="1" data-t3="M" async=""></script>
                </div>
            </div>           
        </div>
        <p><em><?php echo __('Important:', 'paypal-payment-buttons'); ?></em> <?php echo __('Unless you enable the sandbox environment, all payments made using this code will be live and not test payments.', 'paypal-payment-buttons'); ?></p>
        <?php
    }

    public function Get_Currency_With_Code() {
        return array(
            'AED' => __('United Arab Emirates Dirham (Ø¯.Ø¥)', 'paypal-payment-buttons'),
            'AUD' => __('Australian Dollars (&#36;)', 'paypal-payment-buttons'),
            'BDT' => __('Bangladeshi Taka (&#2547;&nbsp;)', 'paypal-payment-buttons'),
            'BRL' => __('Brazilian Real (&#82;&#36;)', 'paypal-payment-buttons'),
            'BGN' => __('Bulgarian Lev (&#1083;&#1074;.)', 'paypal-payment-buttons'),
            'CAD' => __('Canadian Dollars (&#36;)', 'paypal-payment-buttons'),
            'CLP' => __('Chilean Peso (&#36;)', 'paypal-payment-buttons'),
            'CNY' => __('Chinese Yuan (&yen;)', 'paypal-payment-buttons'),
            'COP' => __('Colombian Peso (&#36;)', 'paypal-payment-buttons'),
            'CZK' => __('Czech Koruna (&#75;&#269;)', 'paypal-payment-buttons'),
            'DKK' => __('Danish Krone (kr.)', 'paypal-payment-buttons'),
            'DOP' => __('Dominican Peso (RD&#36;)', 'paypal-payment-buttons'),
            'EUR' => __('Euros (&euro;)', 'paypal-payment-buttons'),
            'HKD' => __('Hong Kong Dollar (&#36;)', 'paypal-payment-buttons'),
            'HRK' => __('Croatia kuna (Kn)', 'paypal-payment-buttons'),
            'HUF' => __('Hungarian Forint (&#70;&#116;)', 'paypal-payment-buttons'),
            'ISK' => __('Icelandic krona (Kr.)', 'paypal-payment-buttons'),
            'IDR' => __('Indonesia Rupiah (Rp)', 'paypal-payment-buttons'),
            'INR' => __('Indian Rupee (Rs.)', 'paypal-payment-buttons'),
            'NPR' => __('Nepali Rupee (Rs.)', 'paypal-payment-buttons'),
            'ILS' => __('Israeli Shekel (&#8362;)', 'paypal-payment-buttons'),
            'JPY' => __('Japanese Yen (&yen;)', 'paypal-payment-buttons'),
            'KIP' => __('Lao Kip (&#8365;)', 'paypal-payment-buttons'),
            'KRW' => __('South Korean Won (&#8361;)', 'paypal-payment-buttons'),
            'MYR' => __('Malaysian Ringgits (&#82;&#77;)', 'paypal-payment-buttons'),
            'MXN' => __('Mexican Peso (&#36;)', 'paypal-payment-buttons'),
            'NGN' => __('Nigerian Naira (&#8358;)', 'paypal-payment-buttons'),
            'NOK' => __('Norwegian Krone (&#107;&#114;)', 'paypal-payment-buttons'),
            'NZD' => __('New Zealand Dollar (&#36;)', 'paypal-payment-buttons'),
            'PYG' => __('Paraguayan GuaranÃ­ (&#8370;)', 'paypal-payment-buttons'),
            'PHP' => __('Philippine Pesos (&#8369;)', 'paypal-payment-buttons'),
            'PLN' => __('Polish Zloty (&#122;&#322;)', 'paypal-payment-buttons'),
            'GBP' => __('Pounds Sterling (&pound;)', 'paypal-payment-buttons'),
            'RON' => __('Romanian Leu (lei)', 'paypal-payment-buttons'),
            'RUB' => __('Russian Ruble (&#1088;&#1091;&#1073;.)', 'paypal-payment-buttons'),
            'SGD' => __('Singapore Dollar (&#36;)', 'paypal-payment-buttons'),
            'ZAR' => __('South African rand (&#82;)', 'paypal-payment-buttons'),
            'SEK' => __('Swedish Krona (&#107;&#114;)', 'paypal-payment-buttons'),
            'CHF' => __('Swiss Franc (&#67;&#72;&#70;)', 'paypal-payment-buttons'),
            'TWD' => __('Taiwan New Dollars (&#78;&#84;&#36;)', 'paypal-payment-buttons'),
            'THB' => __('Thai Baht (&#3647;)', 'paypal-payment-buttons'),
            'TRY' => __('Turkish Lira (&#8378;)', 'paypal-payment-buttons'),
            'UAH' => __('Ukrainian Hryvnia (&#8372;)', 'paypal-payment-buttons'),
            'USD' => __('US Dollars (&#36;)', 'paypal-payment-buttons'),
            'VND' => __('Vietnamese Dong (&#8363;)', 'paypal-payment-buttons'),
            'EGP' => __('Egyptian Pound (EGP)', 'paypal-payment-buttons')
        );
    }

}