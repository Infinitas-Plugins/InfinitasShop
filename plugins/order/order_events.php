<?php
	class OrderEvents{
		public function onSetupCache() {
			return array(
				'name' => 'orders',
				'config' => array(
					'duration' => 3600,
					'probability' => 100,
					'prefix' => 'orders.',
					'lock' => false,
					'serialize' => true
				)
			);
		}

		public function onUserLogin(&$event, $data) {
			// check if order status has changed and notify
		}

		public function onSetupThemeLayout(&$event, $data) {
			if($data['params']['plugin'] == 'order' && $data['params']['controller'] == 'orders' && $data['params']['action'] == 'pay') {
				return 'checkout';
			}
		}
	}