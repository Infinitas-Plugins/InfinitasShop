<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopListProduct Model
 *
 * @property ShopList $ShopList
 * @property ShopProduct $ShopProduct
 * @property ShopListProductOption $ShopListProductOption
 */
class ShopListProduct extends ShopAppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	public $findMethods = array(
		'products' => true
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopList' => array(
			'className' => 'Shop.ShopList',
			'foreignKey' => 'shop_list_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'shop_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'ShopListProductOption' => array(
			'className' => 'Shop.ShopListProductOption'
		)
	);

/**
 * @brief overload construct for translated validation messages
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'shop_product_id' => array(
				'uuid' => array(
					'rule' => array('uuid'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
	}
}
