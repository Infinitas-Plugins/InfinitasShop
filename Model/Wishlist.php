<?php
	class Wishlist extends ShopAppModel{
		public $name = 'Wishlist';

		/**
		 * sub_total is the line total
		 * @var unknown_type
		 */
		public $virtualFields = array(
			'sub_total' => 'Wishlist.quantity * Wishlist.price'
		);

		public $belongsTo = array(
			'Product' => array(
				'className' => 'Shop.Product',
				'fields' => array(
					'Product.id',
					'Product.name',
					'Product.slug'
				)
			),
			'User' => array(
				'className' => 'Users.User',
				'fields' => array(
					'User.id',
					'User.username'
				)
			)
		);

		public function getWishlistData($user_id = null){
			if((int)$user_id > 0){
				$cacheName = cacheName('wishlist', $user_id);
				$wishlistData = Cache::read($cacheName, 'shop');
				if($wishlistData !== false){
					return $wishlistData;
				}

				$wishlistData = $this->find(
					'all',
					array(
						'conditions' => array(
							'Wishlist.user_id' => $user_id
						),
						'contain' => array(
							'User',
							'Product'
						)
					)
				);

				Cache::write($cacheName, $wishlistData, 'shop');

				return $wishlistData;
			}

			App::import('CakeSession');
			$this->Session = new CakeSession();

			$wishlistData = $this->Session->read('Wishlist.TempWishlist');

			return (array)$wishlistData;
		}

		public function afterSave($created){
			return $this->dataChanged('afterSave');
		}

		public function afterDelete(){
			return $this->dataChanged('afterDelete');
		}

		public function dataChanged($from){
			App::import('CakeSession');
			$this->Session = new CakeSession();

			Cache::delete(cacheName('wishlist', $this->Session->read('Auth.User.id')), 'shop');

			return true;
		}
	}