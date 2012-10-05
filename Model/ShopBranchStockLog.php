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
			'className' => 'Shop.ShopBranchStock',
			'foreignKey' => 'shop_branch_stock_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'shop_branch_stock_id' => array(
				'validateRecordExists' => array(
					'rule' => array('validateRecordExists'),
					'message' => __d('shop', 'Specified branch / product combination does not exist'),
					'allowEmpty' => false,
					'required' => true
				),
			),
			'change' => array(
				'validateStockAmount' => array(
					'rule' => array('validateStockAmount'),
					'message' => __d('shop', 'The specified amount is invalid, should be non-zero number'),
					'allowEmpty' => false,
					'required' => true
				),
			),
			'notes' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('shop', 'No notes specified for stock change'),
					'allowEmpty' => false,
					'required' => true
				),
			),
		);
	}

/**
 * @brief validate the stock amount is correct
 *
 * There is no point adding stock
 * @param type $field
 * @return type
 */
	public function validateStockAmount($field) {
		$field = current($field);
		return is_int($field) && $field !== 0;
	}
}
