<?php
/**
 * ShopProductTypes controller
 *
 * @brief Add some documentation for ShopProductTypes controller.
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

class ShopProductTypesController extends ShopAppController {
/**
 * @brief the index method
 *
 * Show a paginated list of ShopProductType records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'joins' => array(
				//$this->{$this->modelClass}->autoJoinModel('Shop.ShopProduct'),
				//$this->{$this->modelClass}->autoJoinModel('Shop.ShopCategory'),
			)
		);

		$shopProductTypes = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('filterOptions', 'shopProductTypes'));
	}
}