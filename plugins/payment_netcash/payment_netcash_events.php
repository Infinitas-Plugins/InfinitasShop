<?php
	class PaymentNetcashEvents{
		public function onLoadPaymentGateways(&$event) {
			Configure::load('PaymentNetcash.config');
			return 'netcash';
		}
	}