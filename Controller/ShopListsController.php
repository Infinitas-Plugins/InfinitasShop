<?php
/**
 * ShopLists controller
 *
 * Add some documentation for ShopLists controller.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.Controller
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

class ShopListsController extends ShopAppController {

/**
 * Set the shipping method for the currently selected list
 *
 * @param string $id the id of the shipping method to use
 *
 * @return void
 */
	public function set_shipping_method($id = null) {
		if ($id) {
			try {
				if ($this->{$this->modelClass}->setShippingMethod($id)) {
					$this->notice(__d('shop', 'Shipping method has been changed'), array(
						'redirect' => true
					));
				}
				var_dump($this->{$this->modelClass}->validationErrors);
				exit;
			} catch (Exception $e) {
				$this->notice($e);
			}
		}

		$this->notice(__d('shop', 'No shipping method selected'), array(
			'redirect' => true,
			'level' => 'warning'
		));
	}

/**
 * Set the payment method for the currently selected list
 *
 * @param string $id the id of the payment method to use
 *
 * @return void
 */
	public function set_payment_method($id = null) {
		if ($id) {
			try {
				if ($this->{$this->modelClass}->setPaymentMethod($id)) {
					$this->notice(__d('shop', 'Payment method has been changed'), array(
						'redirect' => true
					));
				}
			} catch (Exception $e) {
				$this->notice($e);
			}
		}

		$this->notice(__d('shop', 'No payment method selected'), array(
			'redirect' => true,
			'level' => 'warning'
		));
	}

	public function change_list($id = null) {
		try {
			if ($this->{$this->modelClass}->setCurrentList($id)) {
				$this->notice(__d('shop', 'List has been changed'), array(
					'redirect' => array(
						'controller' => 'shop_list_products',
						'action' => 'index'
					)
				));
			}
		} catch (Exception $e) {
			$this->notice($e);
		}
		$this->notice(__d('shop', 'Failed to change the list'), array(
			'level' => 'warning',
			'redirect' => true,
			'redirect' => array(
				'controller' => 'shop_list_products',
				'action' => 'index'
			)
		));
	}

/**
 * the index method
 *
 * Show a paginated list of ShopList records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'User',
				'ShopShippingMethod',
				'ShopPaymentMethod',
			),
			'conditions' => array(
				$this->modelClass . '.user_id' => $this->{$this->modelClass}->currentUserId()
			)
		);

		$shopLists = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('shopLists', 'filterOptions'));
	}

	public function add() {
		$this->saveRedirectMarker();
		$userId = $this->{$this->modelClass}->currentUserId();
		if ($this->request->is('post')) {
			$this->request->data[$this->modelClass]['user_id'] = $userId;
			if ($this->{$this->modelClass}->save($this->request->data[$this->modelClass])) {
				$this->notice('saved');
			}
		}
		$this->notice('not_saved');
	}

	public function delete($id = null) {
		if (!$id) {
			$this->notice('not_found');
		}

		$deleted = $this->{$this->modelClass}->deleteAll(array(
			$this->modelClass . '.' . $this->{$this->modelClass}->primaryKey => $id,
			$this->modelClass . '.user_id' => $this->{$this->modelClass}->currentUserId()
		));
		$this->saveRedirectMarker();
		if ($deleted)  {
			if ($this->Session->read('Shop.current_list') == $id) {
				$this->Session->delete('Shop.current_list');
			}
			return $this->notice('deleted');
		}

		return $this->notice('not_deleted');
	}

/**
 * the index method
 *
 * Show a paginated list of ShopList records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'User',
				'ShopShippingMethod',
				'ShopPaymentMethod',
			)
		);

		$shopLists = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('shopLists', 'filterOptions'));
	}

/**
 * view method for a single row
 *
 * Show detailed information on a single ShopList
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function admin_view($id = null) {
		if (!$id) {
			$this->Infinitas->noticeInvalidRecord();
		}

		$shopList = $this->ShopList->getViewData(
			array($this->ShopList->alias . '.' . $this->ShopList->primaryKey => $id)
		);

		$this->set(compact('shopList'));
	}

/**
 * admin create action
 *
 * Adding new ShopList records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$users = $this->ShopList->User->find('list');
		$shopShippingMethods = $this->ShopList->ShopShippingMethod->find('list');
		$shopPaymentMethods = $this->ShopList->ShopPaymentMethod->find('list');
		$this->set(compact('users', 'shopShippingMethods', 'shopPaymentMethods'));
	}

/**
 * admin edit action
 *
 * Edit old ShopList records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$users = $this->ShopList->User->find('list');
		$shopShippingMethods = $this->ShopList->ShopShippingMethod->find('list');
		$shopPaymentMethods = $this->ShopList->ShopPaymentMethod->find('list');
		$this->set(compact('users', 'shopShippingMethods', 'shopPaymentMethods'));
	}
}