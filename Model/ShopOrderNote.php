<?php
/**
 * ShopOrderNote model
 *
 * Add some documentation for ShopOrderNote model.
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

class ShopOrderNote extends ShopAppModel {

/**
 * custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'notes' => true
	);

/**
 * belongsTo relations for this model
 *
 * @access public
 * @var array
 */
	public $belongsTo = array(
		'ShopOrder' => array(
			'className' => 'Shop.ShopOrder',
			'foreignKey' => 'shop_order_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
		'ShopOrderStatus' => array(
			'className' => 'Shop.ShopOrderStatus',
			'foreignKey' => 'shop_order_status_id',
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
			'shop_order_id' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'No order specified'),
					'required' => true
				),
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'Invalid order specified'),
				)
			),
			'shop_order_status_id' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'No order status specified'),
					'required' => true
				),
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'Invalid order status specified'),
				)
			),
			'notes' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'No order status specified'),
				)
			)
		);
	}

/**
 * Find notes related to the order specified
 * 
 * Notes displayed to the user will only include those set with `user_notified` as true
 * and `internal` as false.
 *
 * Setting a note to internal allows site admins to create notes on orders that are only 
 * visable to administrators of the site. Users will not see these notes.
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return boolean
 *
 * @throws InvalidArgumentException
 */
	protected function _findNotes($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query[0])) {
				throw new InvalidArgumentException(__d('shop', 'No order specified'));
			}

			$query = array_merge(array(
				'admin' => false
			), $query);
			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.shop_order_id' => $query[0]
			));

			if (!$query['admin']) {
				$query['conditions'][$this->alias . '.user_notified'] = true;
			}

			return $query;
		}

		return Hash::extract($results, '{n}.' . $this->alias);
	}

/**
 * Add notes to an order
 *
 * If a note is marked as user_notified it can not be internal so the internal flag will be set to false
 *
 * @param arra $note the details to be saved
 *
 * @return boolean
 */
	public function saveNote(array $note) {
		$note = array_merge(array(
			'shop_order_id' => null,
			'shop_order_status_id' => null,
			'notes' => null,
			'user_notified' => false,
			'internal' => true,
		), $note);

		if ($note['user_notified']) {
			$note['internal'] = false;
		}

		$this->create();
		return (bool)$this->save($note);
	}
}
