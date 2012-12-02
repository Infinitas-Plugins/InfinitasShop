<?php
/**
 * ShopProductTypesOption Model
 *
 * @property ShopOption $ShopOption
 * @property ShopProductType $ShopProductType
 */

class ShopProductTypesOption extends ShopAppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopOption' => array(
			'className' => 'Shop.ShopOption',
			'foreignKey' => 'shop_option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopProductType' => array(
			'className' => 'Shop.ShopProductType',
			'foreignKey' => 'shop_product_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}