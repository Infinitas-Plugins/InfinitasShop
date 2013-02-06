<?php
/**
 * ShopAttributeGroups controller
 *
 * @brief Add some documentation for ShopAttributeGroups controller.
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

class ShopAttributeGroupsController extends ShopAppController {

/**
 * @brief the index method
 *
 * Show a paginated list of ShopAttributeGroup records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'ShopAttribute'
			)
		);

		$shopAttributeGroups = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('shopAttributeGroups', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopAttributeGroup
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

		$shopAttributeGroup = $this->{$this->modelClass}->getViewData(
			array($this->{$this->modelClass}->alias . '.' . $this->{$this->modelClass}->primaryKey => $id)
		);

		$this->set(compact('shopAttributeGroup'));
	}

	public function admin_product($shopProductId) {
		if ($this->request->data) {
			$saved = $this->{$this->modelClass}->saveAttributes($this->request->data);
			if ($saved) {
				return $this->notice('saved');
			}
			return $this->notice('not_saved');
		}

		$shopAttributeGroups = $this->{$this->modelClass}->find('forManage', array(
			'shop_product_id' => $shopProductId
		));
		$shopProduct = Hash::flatten(ClassRegistry::init('Shop.ShopProduct')->find('product', array(
			$shopProductId	
		)));
		foreach ($shopProduct as $k => $v) {
			if (strstr($k, 'ShopImage') !== false && strstr($k, 'full') !== false) {
				if (strstr($v, 'no-image') === false) {
					continue;	
				}
			}
			unset($shopProduct[$k]);
		}
		$shopProductImages = array_unique(array_values($shopProduct));
		$this->set(compact('shopAttributeGroups', 'shopProductImages', 'shopProductId'));
		$this->saveRedirectMarker();
	}

/**
 * @brief admin create action
 *
 * Adding new ShopAttributeGroup records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

	}

/**
 * @brief admin edit action
 *
 * Edit old ShopAttributeGroup records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

	}
}