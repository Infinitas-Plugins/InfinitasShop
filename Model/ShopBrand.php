<?php
/**
 * ShopBrand model
 *
 * @brief Add some documentation for ShopBrand model.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.Model
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

class ShopBrand extends ShopAppModel {
/**
 * @brief Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * @brief behaviors that are attached
 * 
 * @var array
 */
	public $actsAs = array(
		'Filemanager.Upload' => array(
			'image' => array(
				'thumbnailSizes' => array(
					'large' => '1000l',
					'medium' => '600l',
					'small' => '300l',
					'thumb' => '75l'
				)
			)
		)
	);

/**
 * How the default ordering on this model is done
 *
 * @access public
 * @var array
 */
	public $order = array(
	);

/**
 * hasOne relations for this model
 *
 * @access public
 * @var array
 */
	public $hasOne = array(
	);

/**
 * belongsTo relations for this model
 *
 * @access public
 * @var array
 */
	public $belongsTo = array(
	);

/**
 * hasMany relations for this model
 *
 * @access public
 * @var array
 */
	public $hasMany = array(
		'ShopProduct' => array(
			'className' => 'ShopProduct',
			'foreignKey' => 'shop_brand_id',
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

/**
 * hasAndBelongsToMany relations for this model
 *
 * @access public
 * @var array
 */
	public $hasAndBelongsToMany = array(
	);

/**
 * overload the construct method so that you can use translated validation
 * messages.
 *
 * @access public
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

/**
 * General method for the view pages. Gets the required data and relations
 * and can be used for the admin preview also.
 *
 * @param array $conditions conditions for the find
 * @return array the data that was found
 */
	public function getViewData($conditions = array()) {
		if(!$conditions) {
			return false;
		}

		$data = $this->find(
			'first',
			array(
				'fields' => array(
				),
				'conditions' => $conditions,
				'contain' => array(
				)
			)
		);

		return $data;
	}
}
