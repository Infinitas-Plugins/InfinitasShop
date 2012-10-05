<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopBranchStockLog Model
 *
 * @property ShopBranchStock $ShopBranchStock
 */
class ShopBranchStockLog extends ShopAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopBranchStock' => array(
			'className' => 'ShopBranchStock',
			'foreignKey' => 'shop_branch_stock_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
