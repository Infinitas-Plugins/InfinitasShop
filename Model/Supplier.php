<?php
	class Supplier extends ShopAppModel {
		public $hasMany = array(
			'Product' => array(
				'className' => 'Shop.Product'
			)
		);

		public $belongsTo = array(
			'Address' => array(
				'className' => 'Management.Address'
			)
		);

		public function __construct($id = false, $table = null, $ds = null) {
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'name' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => __d('shop', 'Please enter the suppliers name')
					),
					'isUnique' => array(
						'rule' => 'isUnique',
						'message' => __d('shop', 'That supplier already exsits')
					)
				),
				'email' => array(
					'email' => array(
						'rule' => array('email', true),
						'message' => __d('shop', 'Please enter a valid email address')
					)
				)
			);
		}
	}