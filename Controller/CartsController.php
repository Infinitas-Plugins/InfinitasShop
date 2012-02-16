<?php
	class CartsController extends ShopAppController{
		public $name = 'Carts';

		public function index(){
			$userId = $this->Session->read('Auth.User.id');

			if(!$userId){
				$this->notice(
					__('You must be logged in to checkout'),
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
			if(empty($addresses)){
				$this->notice(
					__('Please setup your address before checking out'),
					array(
						'redirect' => array('plugin' => 'management', 'controller' => 'addresses', 'action' => 'add')
					)
				);
			}

			$carts = $this->Cart->getCartData($userId);

			if(empty($carts)){
				$this->notice(
					__('Your cart is empty'),
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

			$this->set(compact('addresses', 'carts', 'amounts'));
		}

		public function adjust(){
			if(!isset($this->request->params['named']['product_id'])){
				$this->notice('invalid');
			}

			if(!isset($this->request->params['named']['quantity'])){
				$this->request->params['named']['quantity'] = 1;
			}

			$product = $this->Cart->Product->find(
				'first',
				array(
					'conditions' => array(
						'Product.id' => $this->request->params['named']['product_id']
					),
					'fields' => array(
						'Product.id',
						'Product.name',
						'Product.slug',
						'Product.price',
						'Product.active',
						'Product.added_to_cart'
					),
					'contain' => array(
						'Special'
					)
				)
			);

			if(empty($product) || $product['Product']['active'] == false){
				$this->notice('invalid');
			}

			if(isset($product['Special']) && !empty($product['Special'][0])){
				$product['Product']['price'] = $product['Product']['price'] - (($product['Product']['price'] / 100) * $product['Special'][0]['discount']);
			}

			if($userId = $this->Session->read('Auth.User.id') > 0){
				$this->Shop->dbCartSave($this->Cart, $product);
			}

			$this->Shop->sessionCartSave($this->Cart, $product);
		}

		public function change_shipping_method(){
			if(isset($this->data['Cart']['shipping_method']) && !empty($this->data['Cart']['shipping_method'])){
				$this->Session->write('Shop.shipping_method', $this->data['Cart']['shipping_method']);

				$this->notice(
					__('Shipping method updated'),
					array(
						'redirect' => true
					)
				);
			}

			$methods = $this->Session->read('Shop.shipping_methods');
			if(count($methods) < 2){
				$this->notice(
					__('There are no other options at this time'),
					array(
						'redirect' => true
					)
				);
			}
		}

		public function admin_index(){
			$this->paginate = array(
				'fields' => array(
					'Cart.id',
					'Cart.user_id',
					'Cart.product_id',
					'Cart.price',
					'Cart.quantity',
					'sub_total',
					'Cart.created',
					'Cart.deleted',
					'Cart.deleted_date'
				),
				'conditions' => array(
					'Cart.deleted' => 1
				),
				'contain' => array(
					'User',
					'Product'
				),
				'order' => array(
					'User.username'
				)
			);

			$carts = $this->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'user_id' => $this->Cart->User->find('list'),
				'product_id' => $this->Cart->Product->find('list'),
			);
			$this->set(compact('carts','filterOptions'));
		}
	}