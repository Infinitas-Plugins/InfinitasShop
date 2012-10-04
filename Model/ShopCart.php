<?php
	class ShopCart extends ShopAppModel {
		/**
		 * sub_total is the line total
		 * @var unknown_type
		 */
		public $virtualFields = array(
			'sub_total' => 'Cart.quantity * Cart.price'
		);

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

		public function getCartData($user_id = null) {
			if((int)$user_id > 0) {
				$cacheName = cacheName('cart', $user_id);
				$cartData = Cache::read($cacheName, 'shop');
				if($cartData !== false) {
					return $cartData;
				}

				$cartData = $this->find(
					'all',
					array(
						'conditions' => array(
							'Cart.user_id' => $user_id
						),
						'contain' => array(
							'User',
							'Product'
						)
					)
				);

				Cache::write($cacheName, $cartData, 'shop');

				return $cartData;
			}

			$data = CakeSession::read('Cart.TempCart');

			return (array)$data;
		}

		public function clearCart($user_id = null) {
			if(!$user_id) {
				return false;
			}

			$this->enableSoftDeletable(false);
			$status = $this->deleteAll(
				array(
					'Cart.user_id' => $user_id
				),
				null,
				true
			);

			if($status) {
				$this->dataChanged('afterDelete');
			}
			return $status;
		}
	}