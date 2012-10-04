<?php
	class ShopWishlist extends ShopAppModel {
		/**
		 * sub_total is the line total
		 * @var unknown_type
		 */
		public $virtualFields = array();

		public $belongsTo = array(
			'Product' => array(
				'className' => 'Shop.ShopProduct',
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

		public function __construct($id = false, $table = null, $ds = null) {
			parent::__construct($id, $table, $ds);

			$this->virtualFields = array(
				'sub_total' => sprintf('%s.quantity * %s.price', $this->alias, $this->alias)
			);
		}

		public function getWishlistData($user_id = null) {
			if((int)$user_id > 0) {
				$cacheName = cacheName('wishlist', $user_id);
				$wishlistData = Cache::read($cacheName, 'shop');
				if($wishlistData !== false) {
					return $wishlistData;
				}

				$wishlistData = $this->find(
					'all',
					array(
						'conditions' => array(
							$this->alais . '.user_id' => $user_id
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

			$wishlistData = CakeSession::read($this->alais . '.TempWishlist');

			return (array)$wishlistData;
		}
	}