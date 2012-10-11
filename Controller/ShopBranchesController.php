<?php
/**
 * ShopBranches controller
 *
 * @brief Add some documentation for ShopBranches controller.
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

class ShopBranchesController extends ShopAppController {
/**
 * The helpers linked to this controller
 *
 * @access public
 * @var array
 */
	public $helpers = array(
		//'Shop.Shop', // uncoment this for a custom plugin controller
		//'Libs.Gravatar',
	);

/**
 * @brief the index method
 *
 * Show a paginated list of ShopBranch records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'ContactBranch',
				'Manager',
			)
		);

		$shopBranches = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'id',
			'active' => (array)Configure::read('CORE.active_options'),
		);

		$this->set(compact('shopBranches', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopBranch
 *
 * @todo update the documentation 
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function admin_view($id = null) {
		if(!$id) {
			$this->Infinitas->noticeInvalidRecord();
		}

		$shopBranch = $this->ShopBranch->getViewData(
			array($this->ShopBranch->alias . '.' . $this->ShopBranch->primaryKey => $id)
		);

		$this->set(compact('shopBranch'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopBranch records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$contactBranches = $this->ShopBranch->ContactBranch->find('list');
		$managers = $this->ShopBranch->Manager->find('list');
		$this->set(compact('contactBranches', 'managers'));
	}

/**
 * @brief admin edit action
 *
 * Edit old ShopBranch records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$contactBranches = $this->ShopBranch->ContactBranch->find('list');
		$managers = $this->ShopBranch->Manager->find('list');
		$this->set(compact('contactBranches', 'managers'));
	}
}