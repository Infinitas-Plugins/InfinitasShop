<?php
/**
 * ShopSpecial Model
 *
 * @property ShopProductsSpecial $ShopProductsSpecial
 */
class ShopSpecial extends ShopAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'specials' => true
	);

/**
 * has many relations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopProductsSpecial' => array(
			'className' => 'Shop.ShopProductsSpecial',
			'foreignKey' => 'shop_special_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

/**
 * overload construct for translated validation errors
 *
 * @param boolean $id    [description]
 * @param [type]  $table [description]
 * @param [type]  $ds    [description]
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'name' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'Please enter a name for this special'),
					'allowEmpty' => false,
					'required' => true
				),
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => __d('shop', 'The entered name has already been used')
				)
			),
			'start_date' => array(
				'datetime' => array(
					'rule' => array('datetime', 'ymd'),
					'message' => __d('shop', 'Start date is not valid'),
					'allowEmpty' => true
				),
				'validateInTheFuture' => array(
					'rule' => 'validateInTheFuture',
					'message' => __d('shop', 'The start date should be in the future'),
					'on' => 'create'
				)
			),
			'end_date' => array(
				'datetime' => array(
					'rule' => array('datetime', 'ymd'),
					'message' => __d('shop', 'End date is not valid'),
					'allowEmpty' => true
				),
				'validateAfterStart' => array(
					'rule' => 'validateAfterStart',
					'message' => __d('shop', 'The end date should be after the start date')
				)
			),
			'active' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('shop', 'Active should be boolean')
				),
			),
		);
	}

/**
 * validate the start date is before the end date
 *
 * @param array $field the start date
 *
 * @return boolean
 */
	public function validateInTheFuture(array $field) {
		$startDate = current($field);

		return empty($this->data[$this->alias]['start_date']) || $this->data[$this->alias]['start_date'] > date('Y-m-d H:i:s');
	}

/**
 * validate the end date is after the start date
 *
 * @param array $field the start date
 *
 * @return boolean
 */
	public function validateAfterStart(array $field) {
		$endDate = current($field);

		return empty($this->data[$this->alias]['start_date']) || $endDate >= $this->data[$this->alias]['start_date'];
	}

/**
 * find a list of specials
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findSpecials($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query['shop_product_id'])) {
				throw new InvalidArgumentException('No product selected for specials');
			}

			$this->virtualFields['shop_product_id'] = $this->ShopProductsSpecial->fullFieldName('shop_product_id');

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.discount',
					$this->alias . '.amount',
					$this->alias . '.free_shipping',
					$this->alias . '.start_date',
					$this->alias . '.end_date',
					'shop_product_id'
				)
			);

			$query['conditions'] = array_merge((array)$query['conditions'], $this->conditions());

			$query['joins'] = array_merge(
				(array)$query['joins'],
				array(
					$this->autoJoinModel(array(
						'model' => $this->ShopProductsSpecial->fullModelName(),
						'type' => 'right',
						'conditions' => array(
							$this->ShopProductsSpecial->alias . '.shop_special_id = ShopSpecial.id',
							$this->ShopProductsSpecial->alias . '.shop_product_id' => $query['shop_product_id']
						)
					))
				)
			);

			return $query;
		}

		if (empty($results)) {
			return array();
		}

		if (!empty($query['extract']) && $query['extract']) {
			return Hash::extract($results, '{n}.' . $this->alias);
		}

		return $results;
	}

/**
 * reusable conditions for finding specials that are current and usable to shoppers
 *
 * @return array
 */
	public function conditions() {
		return array(
			'and' => array(
				$this->alias . '.active' => 1,
				array('or' => array(
					$this->alias . '.start_date <= ' => date('Y-m-d H:i:s'),
					$this->alias . '.start_date' => '0000-00-00 00:00:00',
				)),
				array('or' => array(
					$this->alias . '.end_date >= ' => date('Y-m-d H:i:s'),
					$this->alias . '.end_date' => '0000-00-00 00:00:00',
				))
			)
		);
	}
}
