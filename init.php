<?php 
/*
 * Plugin Name: Xunhu Wechat Payment For Easy Digital Downloads
 * Plugin URI: http://www.wpweixin.net
 * Description: Easy Digital Downloads 新增微信支付网关，同时支持电脑端扫码支付，微信H5原生支付。
 * Version: 1.0.3
 * Author: 迅虎网络 
 * Author URI:http://www.wpweixin.net 
 * Text Domain: Xunhu Wechat Payment For Easy Digital Downloads
 */
if (! defined ( 'ABSPATH' )) exit (); // Exit if accessed directly

if (! defined ( 'XH_WECHAT_PAYMENT_EDD' )) define ( 'XH_WECHAT_PAYMENT_EDD', 'XH_WECHAT_PAYMENT_EDD' ); else return;

define('XH_WECHAT_PAYMENT_EDD_FILE',__FILE__);
define('XH_WECHAT_PAYMENT_EDD_VERSION', '1.0.3');
define('XH_WECHAT_PAYMENT_EDD_DIR',rtrim(plugin_dir_path(XH_WECHAT_PAYMENT_EDD_FILE),'/'));
define('XH_WECHAT_PAYMENT_EDD_URL',rtrim(plugin_dir_url(XH_WECHAT_PAYMENT_EDD_FILE),'/'));

load_plugin_textdomain( XH_WECHAT_PAYMENT_EDD, false,dirname( plugin_basename( __FILE__ ) ) . '/lang/'  );

require_once XH_WECHAT_PAYMENT_EDD_DIR.'/class-xh-wechat-edd-api.php';
$api = new XH_Wechat_Payment_EDD_Api();
register_activation_hook ( XH_WECHAT_PAYMENT_EDD_FILE, array($api,'register_activation_hook') );
add_filter( 'plugin_action_links_'. plugin_basename(XH_WECHAT_PAYMENT_EDD_FILE ),array($api,'plugin_action_links'),10,1);
add_action( "edd_{$api->id}_cc_form", '__return_false' );
add_filter('edd_payment_gateways', array($api,'edd_payment_gateways') ,10,1);
add_filter('edd_settings_gateways', array($api,'edd_settings_gateways'),10,1);
add_filter( 'edd_settings_sections_gateways', array($api,'edd_settings_sections_gateways'), 10, 1 );
add_filter('edd_currencies', array($api,'edd_currencies'),10,1);
add_action( "edd_gateway_{$api->id}", array($api,'edd_gateway'),10,1 );
add_filter( 'edd_currency_symbol', array($api,'edd_currency_symbol'),10,2 );
add_filter( 'edd_' . strtolower( 'CNY' ) . '_currency_filter_after',array($api,'currency_filter_after'),10,3 );
add_filter( 'edd_' . strtolower( 'CNY' ) . '_currency_filter_before',array($api,'currency_filter_before'),10,3 );

add_action('init', array($api,'init'));