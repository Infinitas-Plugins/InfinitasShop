<?php
	/**
	 * Controller for shop branches
	 *
	 * manage the branches in the shop
	 *
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 *
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package shop
	 * @subpackage shop.controllers.shopBranches
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 0.8a
	 *
	 * @author Carl Sutton ( dogmatic69 )
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */

	class ShopBranchesController extends ShopAppController {
		public function admin_index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.branch_id',
					$this->modelClass . '.manager_id',
					$this->modelClass . '.ordering',
					$this->modelClass . '.active',
					$this->modelClass . '.modified',
				),
				'contain' => array(
					'BranchDetail',
					'Manager',
					'ShopCategory',
					'Product',
					'Special',
					'Spotlight'
				)
			);
			$branches = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'name',
				'active' => (array)Configure::read('CORE.active_options')
			);

			$this->set(compact('branches','filterOptions'));
		}

		public function admin_add() {
			parent::admin_add();

			$branchDetails = $this->_checkCanAddEdit();
			$managers = $this->{$this->modelClass}->find('managers');
			$this->set(compact('branchDetails', 'managers'));
		}

		public function admin_edit($id = null) {
			parent::admin_add($id);

			$branchDetails = $this->{$this->modelClass}->BranchDetail->find('list');
			$managers = $this->{$this->modelClass}->find('managers');
			$this->set(compact('branchDetails', 'managers'));

			if ($id && empty($this->data)) {
				$this->data = $this->{$this->modelClass}->read(null, $id);
			}
		}

		public function _checkCanAddEdit() {
			$branchDetails = $this->{$this->modelClass}->_getAvailableBranches();
			if (empty($branchDetails)) {
				$this->notice(
					__d('shop', 'Current branches are setup, add more in contacts first'),
					array(
						'redirect' => true
					)
				);
			}

			return $branchDetails;
		}
	}