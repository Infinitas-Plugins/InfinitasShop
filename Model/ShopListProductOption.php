<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopListProductOption Model
 *
 * @property ShopList $ShopList
 * @property ShopOption $ShopOption
 * @property ShopOptionValue $ShopOptionValue
 */
class ShopListProductOption extends ShopAppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopList' => array(
			'className' => 'ShopList',
			'foreignKey' => 'shop_list_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopOption' => array(
			'className' => 'ShopOption',
			'foreignKey' => 'shop_option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopOptionValue' => array(
			'className' => 'ShopOptionValue',
			'foreignKey' => 'shop_option_value_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
