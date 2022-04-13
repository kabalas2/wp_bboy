<?php
/**
 * Plugin Name: Extra Labels
 * Plugin URI: https://github.com/kabalas2
 * Description: Plugin who shows extra labels bellow cart
 * Version: 1.0.0
 * Author: Arnoldas
 * Author URI: https://github.com/kabalas2
 * Text Domain: extra-labels
 * Domain Path: /i18n/languages/
 * Requires at least: 5.7
 * Requires PHP: 7.0
 *
 */

add_action('admin_init', 'or_acf_installed');
function or_acf_installed()
{
    if (is_admin() && current_user_can('activate_plugins') && !is_plugin_active('advamced-custom-fields/acf.php')) {
        add_action('admin_notices', 'child_plugin_notice');

        deactivate_plugins(plugin_basename(__FILE__));

        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
    }
}

function child_plugin_notice()
{
    ?>
    <div class="error"><p>Sorry, but Extra labeles requires the ACF plugin to be installed and active.</p></div><?php
}

add_action('woocommerce_after_add_to_cart_button', 'shipping_note');

function shipping_note()
{
    $warehouse = get_field('werhouse');
    if ($warehouse == 'us') {
        echo "<div class='shipping-note'>Shipping will take about 2-4 weeks</div>";
    } elseif ($warehouse == 'uk') {
        echo "<div class='shipping-note'>Shipping will take about 1-2 weeks</div>";
    } else {
        echo "<div class='shipping-note'>Shipping will take about 3-5 d.</div>";
    }

}

add_action('woocommerce_after_add_to_cart_button', 'discount_over_20');

function discount_over_20()
{
    global $product;
    if ($product->price > 30) {
        echo "<div class='discount-note'>You will get 7% discount</div>";
    } elseif ($product->price > 20) {
        echo "<div class='discount-note'>You will get 5% discount</div>";
    }
}
