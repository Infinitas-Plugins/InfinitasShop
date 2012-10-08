<?php

class ShopAppModel extends AppModel {
/**
 * @brief get the current users id
 *
 * This will return the users id or the guest id, which ever is present
 *
 * @return string.
 */
	public function currentUserId() {
		App::uses('AuthComponent', 'Controller/Component');
		$userId = AuthComponent::user('id');
		
		return $userId ? $userId : CakeSession::read('Shop.Guest.id');
	}
}