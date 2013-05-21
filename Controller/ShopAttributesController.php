<?php
/**
 * ShopAttributes controller
 *
 * @brief Add some documentation for ShopAttributes controller.
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

class ShopAttributesController extends ShopAppController {

/**
 * @brief the index method
 *
 * Show a paginated list of ShopAttribute records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'ShopAttributeGroup',
			)
		);

		$shopAttributes = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('shopAttributes', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopAttribute
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

		$shopAttribute = $this->ShopAttribute->getViewData(
			array($this->ShopAttribute->alias . '.' . $this->ShopAttribute->primaryKey => $id)
		);

		$this->set(compact('shopAttribute'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopAttribute records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$shopAttributeGroups = $this->ShopAttribute->ShopAttributeGroup->find('list');
		$this->set(compact('shopAttributeGroups'));
	}

/**
 * @brief admin edit action
 *
 * Edit old ShopAttribute records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$shopAttributeGroups = $this->ShopAttribute->ShopAttributeGroup->find('list');
		$this->set(compact('shopAttributeGroups'));
	}

	public function admin_delete($id) {
		$this->saveRedirectMarker();
		if ($this->{$this->modelClass}->delete($id)) {
			return $this->notice('deleted');
		}

		return $this->notice('not_deleted');
	}
}