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
 * @brief the index method
 *
 * Show a paginated list of ShopListProduct records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'ShopList',
				'ShopProduct',
			)
		);

		$shopListProducts = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'id',
		);

		$this->set(compact('shopListProducts', 'filterOptions'));
	}

	public function add() {
		$this->saveRedirectMarker();
		if (!$this->request->is('post')) {
			$this->notice('not_found');
		}

		try {
			if($this->{$this->modelClass}->addToList($this->request->data)) {
				$this->notice('added_to_cart');
			}
		} catch (Exception $e) {
			$this->notice($e);
		}

		$this->notice('not_added_to_cart');
	}
}