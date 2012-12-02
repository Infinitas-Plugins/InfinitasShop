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

		$shopListProducts = $this->{$this->modelClass}->ShopProduct->find('productsForList');
		$shopShippingMethods = $this->{$this->modelClass}->ShopList->ShopShippingMethod->find('available');
		$shopPaymentMethods = $this->{$this->modelClass}->ShopList->ShopPaymentMethod->find('available');

		$this->set(compact('shopList', 'shopListProducts', 'shopShippingMethods', 'shopPaymentMethods'));
	}

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

	public function delete($id = null) {
		if (!$this->{$this->modelClass}->delete($id)) {
			$this->notice('not_deleted');
		}

		$this->notice('deleted');
	}
}