<?php
	class Payment extends OrderAppModel {
		public $belongsTo = array(
			'Order' => array(
				'className' => 'Order.Order',
				'foreignKey' => 'order_id',
				'fields' => array(
				),
				'conditions' => array(),
				'order' => array(
					'Order.status_id',
					'Order.created' => 'DESC'
				)
			),
			'User' => array(
				'className' => 'Users.User',
				'foreignKey' => 'user_id',
				'fields' => array(
				),
				'conditions' => array(),
				'order' => array(
				)
			)
		);
	}