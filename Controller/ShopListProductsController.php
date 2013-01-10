<?php
/**
 * ShopListProductsController
 *
 * @package Shop.Controller
 */

/**
 * ShopListProductsController
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 * @link http://infinitas-cms.org/Shop
 * @package Shop.Controller
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

class ShopListProductsController extends ShopAppController {

	public function beforeFilter() {
		parent::beforeFilter();

		$this->notice['added_to_cart'] = array(
			'message' => __d('shop', 'The product has been added to your list'),
			'level' => 'sucsess'
		);

		$this->notice['not_added_to_cart'] = array(
			'message' => __d('shop', 'The product has been added to your list'),
			'redirect' => ''
		);
	}

/**
 * the index method
 *
 * Show a paginated list of ShopListProduct records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function index() {
		$shopList = $this->{$this->modelClass}->ShopList->find('details');

		$shopListProducts = $this->{$this->modelClass}->ShopProductVariant->ShopProduct->find('productsForList');
		$listTotalCost = $this->{$this->modelClass}->ShopProductVariant->ShopProduct->find('costForList');
		try {
			$shopShippingMethod = $this->{$this->modelClass}->ShopList->ShopShippingMethod->find('productList');
		} catch (Exception $e) {
			$shopShippingMethod = array();
		}
		$shopShippingMethods = $this->{$this->modelClass}->ShopList->ShopShippingMethod->find('available');
		$shopPaymentMethods = $this->{$this->modelClass}->ShopList->ShopPaymentMethod->find('available');

		$this->set(compact('shopList', 'shopListProducts', 'listTotalCost', 'shopShippingMethod', 'shopShippingMethods', 'shopPaymentMethods'));
	}

/**
 * Process the users cart
 *
 * Get the details of the order and request the payment if required.
 *
 * @return void
 */
	public function checkout() {
		try {
			$result = $this->{$this->modelClass}->ShopList->checkout($this->request->data);
			$this->redirect($result['redirect']);
		} catch (Exception $e) {
			$this->notice($e);
		}
	}

	public function process() {

	}

/**
 * Update the contents of the list
 *
 * @return array
 */
	protected function _update() {
		if (empty($this->request->data[$this->modelClass]) || !is_array($this->request->data[$this->modelClass])) {
			$this->notice('invalid');
		}

		if ($this->{$this->modelClass}->updateListProducts($this->request->data[$this->modelClass])) {
			$this->notice(__d('shop', 'Product list has been updated'), array(
				'redirect' => ''
			));
		}

		$this->notice(__d('shop', 'Product list has been updated'), array(
			'redirect' => '',
			'level' => 'warning'
		));
	}

/**
 * Add products to the current list
 *
 * @return void
 */
	public function add() {
		$this->saveRedirectMarker();
		if (!$this->request->is('post')) {
			$this->notice('not_found');
		}

		try {
			if ($this->{$this->modelClass}->addToList($this->request->data)) {
				$this->notice('added_to_cart');
			}
		} catch (Exception $e) {
			$this->notice($e);
		}

		$this->notice('not_added_to_cart');
	}

/**
 * Remove a product from a list
 *
 * @param string $id the id of the list product to remove
 *
 * @return void
 */
	public function delete($id = null) {
		if (!$this->{$this->modelClass}->delete($id)) {
			$this->notice('not_deleted');
		}

		$this->notice('deleted');
	}

/**
 * Handle mass actions
 *
 * @return void
 */
	public function mass() {
		$this->saveRedirectMarker();
		switch ($this->MassAction->getAction()) {
			case 'update':
				$this->_update();
				break;

			case 'checkout':
				$this->checkout();
				break;
		}

		$this->notice(__d('shop', 'Invalid option selected'), array(
			'level' => 'warning',
			'redirect' => true
		));
	}
}