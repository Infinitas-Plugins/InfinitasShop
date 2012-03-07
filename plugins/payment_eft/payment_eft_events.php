<?php
	class PaymentEftEvents{
		public function onLoadPaymentGateways(&$event){
			Configure::load('PaymentEft.config');
			return 'eft';
		}
	}