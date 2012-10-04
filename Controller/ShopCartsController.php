<?php
	class ShopCartsController extends ShopAppController {
		public function index() {
			$userId = $this->Auth->user('id');

			if(!$userId) {
				$this->notice(
					__d('shop', 'You must be logged in to checkout'),
					array(
						'redirect' => array(
							'plugin' => 'users',
							'controller' => 'users',
							'action' => 'login'
						)
					)
				);
			}

			$addresses = ClassRegistry::init('Management.Address')->getAddressByUser($userId);
			if(empty($addresses)) {
				$this->notice(
					__d('shop', 'Please setup your address before checking out'),
					array(
						'redirect' => array('plugin' => 'management', 'controller' => 'addresses', 'action' => 'add')
					)
				);
			}

			$carts = $this->{$this->modelClass}->getCartData($userId);

			if(empty($carts)) {
				$this->notice(
					__d('shop', 'Your cart is empty'),
					array(
						'redirect' => array('plugin' => 'shop', 'controller' => 'product', 'action' => 'dashboard')
					)
				);
			}

			$amounts['sub_total'] = array_sum((array)Set::extract('/Cart/sub_total', $carts));
			$eventData = $this->Event->trigger(
				'calculateShipping',
				array(
					'total' => $amounts['sub_total'] ,
					'items' => $carts,
					'method' => $this->Session->read('Shop.shipping_method')
				)
			);

			$amounts['shipping']   = (float)$eventData['calculateShipping']['shipping'.$this->Session->read('Shop.shipping_method')];
			$amounts['total_excl'] = $amounts['sub_total'] + $amounts['shipping'];
			$amounts['vat']        = Configure::read('Shop.vat_rate') > 0 ? ($amounts['total_excl'] / 100) * (int)Configure::read('Shop.vat_rate') : 0;
			$amounts['total_due']  = $amounts['total_excl'] + $amounts['vat'];

			$this->set(compact('addresses', 'shopCarts', 'amounts'));
		}

		public function adjust() {
			if(!isset($this->request->params['named']['product_id'])) {
				$this->notice('invalid');
			}

			if(!isset($this->request->params['named']['quantity'])) {
				$this->request->params['named']['quantity'] = 1;
			}

			$product = $this->{$this->modelClass}->Product->find(
				'first',
				array(
					'conditions' => array(
						$this->modelClass . '.id' => $this->request->params['named']['product_id']
					),
					'fields' => array(
						$this->modelClass . '.id',
						$this->modelClass . '.name',
						$this->modelClass . '.slug',
						$this->modelClass . '.price',
						$this->modelClass . '.active',
						$this->modelClass . '.added_to_cart'
					),
					'contain' => array(
						'Special'
					)
				)
			);

			if(empty($product) || $product['Product']['active'] == false) {
				$this->notice('invalid');
			}

			if(isset($product['Special']) && !empty($product['Special'][0])) {
				$product['Product']['price'] = $product['Product']['price'] - (($product['Product']['price'] / 100) * $product['Special'][0]['discount']);
			}

			if($this->Auth->user('id')) {
				$this->Shop->dbCartSave($this->{$this->modelClass}, $product);
			}

			$this->Shop->sessionCartSave($this->{$this->modelClass}, $product);
		}

		public function change_shipping_method() {
			if(isset($this->data[$this->modelClass]['shipping_method']) && !empty($this->data[$this->modelClass]['shipping_method'])) {
				$this->Session->write('Shop.shipping_method', $this->data[$this->modelClass]['shipping_method']);

				$this->notice(
					__d('shop', 'Shipping method updated'),
					array(
						'redirect' => true
					)
				);
			}

			$methods = $this->Session->read('Shop.shipping_methods');
			if(count($methods) < 2) {
				$this->notice(
					__d('shop', 'There are no other options at this time'),
					array(
						'redirect' => true
					)
				);
			}
		}

		public function admin_index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.user_id',
					$this->modelClass . '.product_id',
					$this->modelClass . '.price',
					$this->modelClass . '.quantity',
					'sub_total',
					$this->modelClass . '.created',
					$this->modelClass . '.deleted',
					$this->modelClass . '.deleted_date'
				),
				'conditions' => array(
					$this->modelClass . '.deleted' => 1
				),
				'contain' => array(
					'User',
					'Product'
				),
				'order' => array(
					'User.username'
				)
			);

			$carts = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'user_id' => $this->{$this->modelClass}->User->find('list'),
				'product_id' => $this->{$this->modelClass}->Product->find('list'),
			);
			$this->set(compact('shopCarts','filterOptions'));
		}
	}