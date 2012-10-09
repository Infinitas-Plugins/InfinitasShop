<?php
App::uses('AuthComponent', 'Controller/Component');
/**
 * @brief ShopAppModel
 */

class ShopAppModel extends AppModel {
/**
 * @brief get the current users id
 *
 * This will return the users id or the guest id, which ever is present
 *
 * @return string.
 */
	public function currentUserId() {
		$userId = AuthComponent::user('id');

		return $userId ? $userId : CakeSession::read('Shop.Guest.id');
	}

/**
 * @brief check if the user is a guest
 *
 * @return boolean
 */
	public function isGuest() {
		return $this->isUser() == false;
	}

/**
 * @brief check if the user is logged in
 *
 * Returns true if the user is logged in
 *
 * @return boolean
 */
	public function isUser() {
		$userId = AuthComponent::user('id');
		if(!$userId) {
			return false;
		}

		return ClassRegistry::init('Users.User')->exists($userId);
	}
}