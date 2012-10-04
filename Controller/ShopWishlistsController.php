<?php
	class ShopWishlistsController extends ShopAppController {
		public function index() {
			$userId = $this->Auth->user('id');
			if($userId) {
				$wishlists = $this->{$this->modelClass}->find(
					'all',
					array(
						'conditions' => array(
							$this->modelClass . '.user_id' => $userId
						),
						'contain' => array(
							'Product'
						)
					)
				);
			}
			else{
				$wishlists = $this->Session->read('Wishlist.TempWishlist');
			}

			if(empty($wishlists)) {
				$this->notice(
					__d('shop', 'Your wishlist is empty'),
					array(
						'redirect' => array('controller' => 'products', 'action' => 'index')
					)
				);
			}

			$this->set(compact('wishlists', 'amounts'));
		}

		public function adjust() {
			if(!isset($this->request->params['named']['product_id'])) {
				$this->notice('invalid');
			}

			$this->request->params['named']['quantity'] = 0;

			$product = $this->{$this->modelClass}->Product->find(
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
						'Product.added_to_wishlist'
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

			if($userId = $this->Auth->user('id') > 0) {
				$this->Shop->dbCartSave($this->{$this->modelClass}, $product);
			}

			$this->Shop->sessionCartSave($this->{$this->modelClass}, $product);
		}

		public function move($product_id = null) {
			if(!$product_id) {
				$this->notice('invalid');
			}

			$product = $this->{$this->modelClass}->Product->find(
				'first',
				array(
					'conditions' => array(
						'Product.id' => $product_id
					),
					'fields' => array(
						'Product.id',
						'Product.name',
						'Product.price',
						'Product.active',
						'Product.added_to_cart'
					),
					'contain' => array(
						'Special'
					)
				)
			);

			if(isset($product['Special']) && !empty($product['Special'][0])) {
				$product['Product']['price'] = $product['Product']['price'] - (($product['Product']['price'] / 100) * $product['Special'][0]['discount']);
			}

			$Cart = ClassRegistry::init('Shop.Cart');
			$this->request->params['named']['product_id'] = $product_id;
			$this->request->params['named']['quantity'] = 1;


			$userId = $this->Auth->user('id');
			if($userId) {
				$this->{$this->modelClass}->enableSoftDeletable('delete', false);

				$deleteConditions = array(
					$this->modelClass . '.user_id' => $userId,
					$this->modelClass . '.product_id' => $product_id
				);

				if(!$this->{$this->modelClass}->deleteAll($deleteConditions)) {
					$this->notice(
						__d('shop', 'There was a problem moving the product'),
						array(
							'redirect' => true
						)
					);
				}

				$this->Shop->dbCartSave($Cart, $product);
			}
			else{
				$wishlists = $this->Session->read('Wishlist.TempWishlist');
				foreach($wishlists as &$wishlist) {
					if($wishlist[$this->modelClass]['product_id'] == $product_id) {
						unset($wishlist);
					}
				}
				$this->Session->write($this->modelClass . '.TempWishlist', $wishlists);


				$this->Shop->sessionCartSave($Cart, $product);
			}
		}

		public function admin_index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.user_id',
					$this->modelClass . '.product_id',
					$this->modelClass . '.price',
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

			$wishlists = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'user_id' => $this->{$this->modelClass}->User->find('list'),
				'product_id' => $this->{$this->modelClass}->Product->find('list'),
			);
			$this->set(compact('wishlists', 'filterOptions'));
		}
	}