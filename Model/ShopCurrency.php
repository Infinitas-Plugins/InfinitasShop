<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopCurrency Model
 *
 * @property ShopPaymentMethodApi $ShopPaymentMethodApi
 */
class ShopCurrency extends ShopAppModel {

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
		'ShopPaymentMethodApi' => array(
			'className' => 'ShopPaymentMethodApi',
			'foreignKey' => 'shop_currency_id',
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
