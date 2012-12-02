<?php
/**
 * ShopBranchStockLog Model
 *
 * @property ShopBranchStock $ShopBranchStock
 */

class ShopBranchStockLog extends ShopAppModel {

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

/**
 * Constructor
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->order = array(
			$this->alias . '.created' => 'desc'
		);

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
 * validate the stock amount is correct
 *
 * There is no point adding stock
 * @param type $field
 * @return type
 */
	public function validateStockAmount(array $field) {
		$field = current($field);
		return is_int($field) && $field !== 0;
	}
}
