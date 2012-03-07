<?php
	class PaymentPaypalEvents{
		public function onLoadPaymentGateways(&$event){
			Configure::load('PaymentPaypal.config');
			return 'paypal';
		}
	}