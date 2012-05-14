<?php
	final class ShopEvents extends AppEvents {	
		public function onPluginRollCall() {
			return array(
				'name' => 'Shop',
				'description' => 'Online eCommerce',
				'icon' => '/shop/img/icon.png',
				'author' => 'Infinitas',
				'dashboard' => array(
					'plugin' => 'shop',
					'controller' => 'shop',
					'action' => 'dashboard'
				)
			);
		}
		
		public function onSetupCache() {
			return array(
				'name' => 'shop',
				'config' => array(
					'duration' => 3600,
					'probability' => 100,
					'prefix' => 'shop.',
					'lock' => false,
					'serialize' => true
				)
			);
		}

		public function onSlugUrl($event, $data) {
			switch($data['type']) {
				case 'products':
					return array(
						'plugin' => 'shop',
						'controller' => 'products',
						'action' => $data['data']['action'],
						'id' => $data['data']['id'],
						'slug' => $data['data']['slug']
					);
					break;

				case 'categories':
					return array(
						'plugin' => 'shop',
						'controller' => 'shop_categories',
						'action' => $data['data']['action'],
						'id' => $data['data']['id'],
						'slug' => $data['data']['slug']
					);
					break;
			} // switch
		}

		public function onSetupThemeLayout($event, $data) {
			if($data['params']['plugin'] == 'shop' && $data['params']['controller'] == 'carts' && $data['params']['action'] == 'index') {
				//return 'checkout';
			}
		}

		public function onSetupTabs($event, $data) {
			echo 'yey: shop event';
			exit;
		}

		public function onUserLogin($event, $data) {
			try {
				if(ClassRegistry::init('Shop.Cart')->moveSessionToDb(CakeSession::read('Cart.TempCart'), $data) === true) {
					CakeSession::delete('Cart');
				}

				if(ClassRegistry::init('Shop.Wishlist')->moveSessionToDb(CakeSession::read('Wishlist.TempWishlist'), $data) === true) {
					CakeSession::delete('Wishlist');
				}
			}
			
			catch(Exception $e) {
				
			}
		}

		public function onRequireHelpersToLoad() {
			return array(
				'Shop.Shop'
			);
		}

		public function onRequireComponentsToLoad() {
			return array(
				//'Libs.Voucher'
			);
		}
		
		public function onRequireCssToLoad($event, $data = null) {
			if($event->Handler->request->params['admin'] || $event->Handler->request->params['plugin'] != 'shop') {
				return;
			}
			
			return array(
				'Shop.shop'
			);
		}
		
		public function onRequireJavascriptToLoad($event, $data = null) {
			if($event->Handler->request->params['admin'] || $event->Handler->request->params['plugin'] != 'shop') {
				return;
			}
			
			return array(
				'Shop.shop'
			);
		}
	}