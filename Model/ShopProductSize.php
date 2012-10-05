<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopProductSize Model
 *
 * @property ShopProduct $ShopProduct
 * @property ShopUnit $ShopUnit
 */
class ShopProductSize extends ShopAppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopProduct' => array(
			'className' => 'ShopProduct',
			'foreignKey' => 'shop_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopUnit' => array(
			'className' => 'ShopUnit',
			'foreignKey' => 'shop_unit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
