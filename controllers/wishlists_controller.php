<?php
	class WishlistsController extends ShopAppController{
		var $name = 'Wishlists';

		var $helpers = array(
			'Filter.Filter'
		);

		function index(){
			$userId = $this->Session->read('Auth.User.id');
			if($userId){
				$wishlists = $this->Wishlist->find(
					'all',
					array(
						'conditions' => array(
							'Wishlist.user_id' => $userId
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

			if(empty($wishlists)){
				$this->notice(
					__('Your wishlist is empty', true),
					array(
						'redirect' => array('controller' => 'products', 'action' => 'index')
					)
				);
			}

			$this->set(compact('wishlists', 'amounts'));
		}

		function adjust(){
			if(!isset($this->params['named']['product_id'])){
				$this->Infinitas->noticeInvalidRecord();
			}

			$this->params['named']['quantity'] = 0;

			$product = $this->Wishlist->Product->find(
				'first',
				array(
					'conditions' => array(
						'Product.id' => $this->params['named']['product_id']
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

			if(empty($product) || $product['Product']['active'] == false){
				$this->Infinitas->noticeInvalidRecord();
			}

			if(isset($product['Special']) && !empty($product['Special'][0])){
				$product['Product']['price'] = $product['Product']['price'] - (($product['Product']['price'] / 100) * $product['Special'][0]['discount']);
			}

			if($userId = $this->Session->read('Auth.User.id') > 0){
				$this->Shop->dbCartSave($this->Wishlist, $product);
			}

			$this->Shop->sessionCartSave($this->Wishlist, $product);
		}

		function move($product_id = null){
			if(!$product_id){
				$this->Infinitas->noticeInvalidRecord();
			}

			$product = $this->Wishlist->Product->find(
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

			if(isset($product['Special']) && !empty($product['Special'][0])){
				$product['Product']['price'] = $product['Product']['price'] - (($product['Product']['price'] / 100) * $product['Special'][0]['discount']);
			}

			$Cart = ClassRegistry::init('Shop.Cart');
			$this->params['named']['product_id'] = $product_id;
			$this->params['named']['quantity'] = 1;


			$userId = $this->Session->read('Auth.User.id');
			if($userId){
				$this->Wishlist->enableSoftDeletable('delete', false);

				$deleteConditions = array(
					'Wishlist.user_id' => $userId,
					'Wishlist.product_id' => $product_id
				);

				if(!$this->Wishlist->deleteAll($deleteConditions)){
					$this->notice(
						__('There was a problem moving the product', true),
						array(
							'redirect' => true
						)
					);
				}

				$this->Shop->dbCartSave($Cart, $product);
			}
			else{
				$wishlists = $this->Session->read('Wishlist.TempWishlist');
				foreach($wishlists as &$wishlist){
					if($wishlist['Wishlist']['product_id'] == $product_id){
						unset($wishlist);
					}
				}
				$this->Session->write('Wishlist.TempWishlist', $wishlists);


				$this->Shop->sessionCartSave($Cart, $product);
			}
		}

		function admin_index(){
			$this->paginate = array(
				'fields' => array(
					'Wishlist.id',
					'Wishlist.user_id',
					'Wishlist.product_id',
					'Wishlist.price',
					'Wishlist.created',
					'Wishlist.deleted',
					'Wishlist.deleted_date'
				),
				'conditions' => array(
					'Wishlist.deleted' => 1
				),
				'contain' => array(
					'User',
					'Product'
				),
				'order' => array(
					'User.username'
				)
			);

			$wishlists = $this->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'user_id' => $this->Wishlist->User->find('list'),
				'product_id' => $this->Wishlist->Product->find('list'),
			);
			$this->set(compact('wishlists','filterOptions'));
		}
	}