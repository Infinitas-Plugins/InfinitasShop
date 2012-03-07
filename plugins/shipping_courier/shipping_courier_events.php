<?php
	class ShippingCourierEvents{
		public function onShopLoad(&$event){
			Configure::write('Shop.shipping_method', 'courier');
			Configure::write('Shop.shipping_methods', array_merge((array)Configure::read('Shop.shipping_methods'), array('courier')));
		}

		public function onCalculateShipping(&$event, $data){
			switch($data['method']){
				case 'pick_up':
					return 0;
					break;

				case 'courier':
					if(isset($data['total'])){
						if($data['total'] > 150){
							return 0;
						}
						else{
							return 35;
						}
					}
					break;
			}
		}
	}