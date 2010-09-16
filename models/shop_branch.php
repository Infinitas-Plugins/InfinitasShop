<?php
	/**
	 * shop branch model
	 *
	 * get/set branch data related to the shop.
	 *
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 *
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package shop
	 * @subpackage shop.models.shopBranch
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 0.8a
	 *
	 * @author Carl Sutton ( dogmatic69 )
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */

	class ShopBranch extends ShopAppModel{
		var $name = 'ShopBranch';

		/**
		 * group ids of possible managers.
		 * @var array
		 */
		var $managerGroups = array(
			1 // admin
		);

		var $actsAs = array(
			'Libs.SoftDeletable'
		);

		var $belongsTo = array(
			'BranchDetail' => array(
				'className' => 'Contact.Branch',
				'foreignKey' => 'branch_id',
				'fields' => array(
					'BranchDetail.id',
					'BranchDetail.name',
					'BranchDetail.slug',
					'BranchDetail.image',
					'BranchDetail.phone',
					'BranchDetail.fax',
					'BranchDetail.address_id'
				)
			),
			'Manager' => array(
				'className' => 'Users.User',
				'foreignKey' => 'manager_id',
				'fields' => array(
					'Manager.id',
					'Manager.username'
				)
			),
		);

		var $hasAndBelongsToMany = array(
			'ShopCategory' => array(
				'className' => 'Shop.ShopCategory',
				'foreignKey' => 'category_id',
				'associationForeignKey' => 'branch_id',
				'with' => 'Shop.BranchesCategory',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'ShopCategory.id',
					'ShopCategory.name'
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
			'Product' => array(
				'className' => 'Shop.Product',
				'foreignKey' => 'product_id',
				'associationForeignKey' => 'branch_id',
				'with' => 'Shop.BranchesProduct',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'Product.id',
					'Product.name',
					'Product.cost'
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
			'Stock' => array(
				'className' => 'Shop.Stock',
				'foreignKey' => 'stock_id',
				'associationForeignKey' => 'branch_id',
				'with' => 'Shop.Stock',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'Stock.id',
					'Stock.branch_id',
					'Stock.branch_id',
					'Stock.stock',
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
			'Special' => array(
				'className' => 'Shop.Special',
				'foreignKey' => 'special_id',
				'associationForeignKey' => 'branch_id',
				'with' => 'Shop.BranchesSpecial',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'Special.id',
					'Special.product_id',
					'Special.image_id',
					'Special.discount',
					'Special.amount',
					'Special.start_date',
					'Special.end_date',
					'Special.start_time',
					'Special.end_time'
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
			'Spotlight' => array(
				'className' => 'Shop.Spotlight',
				'foreignKey' => 'spotlight_id',
				'associationForeignKey' => 'branch_id',
				'with' => 'Shop.BranchesSpotlight',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'Spotlight.id',
					'Spotlight.product_id',
					'Spotlight.image_id',
					'Spotlight.start_date',
					'Spotlight.end_date',
					'Spotlight.start_time',
					'Spotlight.end_time'
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			)
		);

		function __construct($id = false, $table = null, $ds = null) {
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'branch_id' => array(
					'isUnique' => array(
						'rule' => 'isUnique',
						'message' => __('That Branch is already setup', true)
					)
				)
			);
		}

		/**
		 * Get people that can be managers of a branch.
		 *
		 * @return list of users.
		 */
		function getManagers(){
			$managers = $this->Manager->find(
				'list',
				array(
					'fields' => array(
						'Manager.id',
						'Manager.username'
					),
					'conditions' => array(
						'Manager.group_id' => $this->managerGroups
					)
				)
			);

			return $managers;
		}

		/**
		 * Get branches that are not set up
		 *
		 * Return a list of branches that can still be added to the shop.
		 *
		 * @return empty array or array of available branches
		 */
		function _getAvailableBranches(){
			$ids = $this->find(
				'list',
				array(
					'fields' => array(
						'ShopBranch.branch_id',
						'ShopBranch.branch_id'
					)
				)
			);

			$branchDetails = $this->BranchDetail->find(
				'list',
				array(
					'conditions' => array(
						'not' => array('BranchDetail.id' => $ids)
					)
				)
			);

			return $branchDetails;
		}

		function branchList(){
			$branches = $this->find(
				'all',
				array(
					'fields' => array(
						'ShopBranch.id'
					),
					'contain' => array(
						'BranchDetail' => array(
							'fields' => array(
								'BranchDetail.name'
							)
						)
					)
				)
			);

			$list = array();
			foreach($branches as $branch){
				$list[$branch['ShopBranch']['id']] = $branch['BranchDetail']['name'];
			}

			return $list;
		}

		function getList(){
			$ids = $this->find(
				'list',
				array(
					'fields' => array(
						'ShopBranch.branch_id',
						'ShopBranch.branch_id'
					)
				)
			);

			$branchDetails = $this->BranchDetail->find(
				'list',
				array(
					'conditions' => array(
						'BranchDetail.id' => $ids
					)
				)
			);

			$return = array();
			foreach($ids as $id){
				$return[$id] = $branchDetails[$id];
			}

			return $return;
		}
	}