<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopListProductOption Model
 *
 * @property ShopListProduct $ShopListProduct
 * @property ShopOption $ShopOption
 * @property ShopOptionValue $ShopOptionValue
 */
class ShopListProductOption extends ShopAppModel {
/**
 * @brief validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * @brief custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'options' => true
	);

/**
 * @brief belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopListProduct' => array(
			'className' => 'Shop.ShopListProduct',
			'foreignKey' => 'shop_list_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopOption' => array(
			'className' => 'Shop.ShopOption',
			'foreignKey' => 'shop_option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopOptionValue' => array(
			'className' => 'Shop.ShopOptionValue',
			'foreignKey' => 'shop_option_value_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * @brief overload construct for translated validation
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(

		);
	}
}
