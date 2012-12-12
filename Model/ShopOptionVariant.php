<?php
/**
 * ShopOptionVariant
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/Shop
 * @package Shop.Model
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

class ShopOptionVariant extends ShopAppModel {

/**
 * belongsTo relations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopProductVariant' => array(
			'className' => 'Shop.ShopProductVariant',
			'foreignKey' => 'shop_product_variant_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
		'ShopOptionValue' => array(
			'className' => 'Shop.ShopOptionValue',
			'foreignKey' => 'shop_option_value_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		)
	);

/**
 * Constructor
 *
 * @param mixed $id string uuid or id
 * @param string $table the table that the model is for
 * @param string $ds the datasource being used
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
		);
	}
}
