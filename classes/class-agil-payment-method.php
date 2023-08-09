<?php

defined( 'ABSPATH' ) || exit;

class AgilPaymentMethod {

    public static function activation() {
    }

    public static function deactivation() {
    }

    public static function uninstall() {
    }

    public static function init() {
        require_once 'class-wc-gateway-agil-pay.php';
        add_filter( 'woocommerce_payment_gateways', [__CLASS__, 'add_payment_method']);
        add_action( 'woocommerce_checkout_process', [__CLASS__, 'validate_agilpay_credentials']);
    }

    public static function add_payment_method( $load_gateways ) {
        $load_gateways[] = 'WC_Gateway_AgilPay';
        return $load_gateways;
    }

    public static function validate_agilpay_credentials(){
        if( isset( $_POST['payment_method'] ) && $_POST['payment_method']=='agilpay' ) {
            $error_message = "";
            // agilpay_card_number
            if(
                !isset( $_POST['agilpay_card_number'] ) ||
                $_POST['agilpay_card_number']==''
            ) {
                 $error_message .= "Card Number Required! <br/>";
            } else if ( isset( $_POST['agilpay_card_number'] ) && !is_numeric($_POST['agilpay_card_number']) ) {
                $error_message .= "Card Number no valid! <br/>";
            } else if ( isset( $_POST['agilpay_card_number'] ) && strlen($_POST['agilpay_card_number'])!=16 ) {
                $error_message .= "Card Number length no valid!";
            }
            //agilpay_card_expiry

            //agilpay_card_cvv
            if(
                !isset( $_POST['agilpay_card_cvv'] ) ||
                $_POST['agilpay_card_cvv']==''
            ) {
                 $error_message .= "CVV Required! <br/>";
            } else if ( isset( $_POST['agilpay_card_cvv'] ) && !is_numeric($_POST['agilpay_card_cvv']) ) {
                $error_message .= "CVV no valid! <br/>";
            } else if ( isset( $_POST['agilpay_card_cvv'] ) && strlen($_POST['agilpay_card_cvv'])!=3 ) {
                $error_message .= "CVV length no valid!";
            }

            if( strlen( $error_message )>0 ) {
                throw new Exception($error_message);
            }
        }
    }

}
