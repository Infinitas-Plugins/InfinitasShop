<?php
/**
 * ShopCurrencies controller
 *
 * @brief Add some documentation for ShopCurrencies controller.
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

class ShopCurrenciesController extends ShopAppController {
/**
 * @brief overlaod beforeFilter to add some notices
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->notice['updated'] = array(
			'message' => __d('shop', 'Exchange rates have been updated'),
			'redirect' => true,
		);

		$this->notice['not_updated'] = array(
			'message' => __d('shop', 'There was a problem updating the currencies'),
			'redirect' => true,
			'level' => 'warning'
		);
	}

/**
 * @brief change the currency being displayed
 *
 * Change the currency that products are displayed in
 *
 * @return void
 */
	public function change() {
		$this->saveRedirectMarker();

		if(empty($this->request->code)) {
			$this->notice(__d('shop', 'No currency selected'), array(
				'level' => 'warning',
				'redirect' => ''
			));
		}

		try {
			ShopCurrencyLib::setCurrency($this->request->code);
			$this->notice(__d('shop', 'Your currency has been changed'), array(
				'redirect' => ''
			));
		} catch(Exception $e) {
			$this->notice($e);
		}
	}

/**
 * @brief the index method
 *
 * Show a paginated list of ShopCurrency records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$shopCurrencies = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
			'code'
		);

		$this->set(compact('shopCurrencies', 'filterOptions'));
	}

/**
 * @brief overload the mass actions for the update method
 *
 * @return void
 */
	public function admin_mass() {
		if($this->MassAction->getAction() == 'update') {
			$this->_update();
		}

		parent::admin_mass();
	}

/**
 * @brief manually update the currency exchange rates
 *
 * @return void
 */
	protected function _update() {
		if($this->{$this->modelClass}->updateCurrencies(true)) {
			$this->notice('updated');
		}
		$this->notice('not_updated');
	}

}