<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopShippingMethod Model
 *
 * @property ShopList $ShopList
 * @property ShopOrder $ShopOrder
 */
class ShopShippingMethod extends ShopAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopList' => array(
			'className' => 'ShopList',
			'foreignKey' => 'shop_shipping_method_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopOrder' => array(
			'className' => 'ShopOrder',
			'foreignKey' => 'shop_shipping_method_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
