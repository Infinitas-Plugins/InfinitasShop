<?php
/**
 * ShopAddress
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/Shop
 * @package	Shop.Model
 * @license	http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 */

class ShopAddress extends ShopAppModel {
/**
 * Additional behaviours that are attached to this model
 *
 * @var array
 */
	public $actsAs = array(
		// 'Libs.Feedable',
		// 'Libs.Rateable'
	);

/**
 * How the default ordering on this model is done
 *
 * @var array
 */
	public $order = array(
	);

/**
 * hasOne relations for this model
 *
 * @var array
 */
	public $hasOne = array(
	);

/**
 * belongsTo relations for this model
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterScope' => array(
				'ShopAddress.active' => 1
			),
		)
	);

/**
 * hasMany relations for this model
 *
 * @var array
 */
	public $hasMany = array(
	);

/**
 * hasAndBelongsToMany relations for this model
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
	);

/**
 * Constructor
 *
 * @param string|integer $id string uuid or id
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
 * Get the view data
 *
 * General method for the view pages. Gets the required data and relations
 * and can be used for the admin preview also.
 *
 * @param array $conditions conditions for the find

 * @return array
 */
	public function getViewData($conditions = array()) {
		if (!$conditions) {
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
