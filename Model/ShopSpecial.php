<?php
/**
 * ShopSpecial Model
 *
 * @property ShopProduct $ShopProduct
 * @property ShopImage $ShopImage
 */
class ShopSpecial extends ShopAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	public $findMethods = array(
		'specials' => true
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'shop_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopImage' => array(
			'className' => 'Shop.ShopImage',
			'foreignKey' => 'shop_image_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'shop_product_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'start_date' => array(
				'date' => array(
					'rule' => array('date'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'end_date' => array(
				'date' => array(
					'rule' => array('date'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'active' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
	}

/**
 * @brief find a list of specials
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
		if($state == 'before') {
			if(empty($query['shop_product_id'])) {
				throw new InvalidArgumentException('No product selected');
			}

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.shop_product_id',
					$this->alias . '.discount',
					$this->alias . '.amount',
					$this->alias . '.start_date',
					$this->alias . '.end_date',
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				$this->conditions(),
				array(
					$this->alias . '.shop_product_id' => $query['shop_product_id'],
				)
			);

			return $query;
		}

		if(!empty($query['extract']) && $query['extract']) {
			return Hash::extract($results, '{n}.' . $this->alias);
		}

		return $results;
	}

/**
 * @brief reusable conditions for finding specials that are current and usable to shoppers
 *
 * @return array
 */
	public function conditions() {
		return array(
			'and' => array(
				$this->alias . '.active' => 1,
				$this->alias . '.start_date <= ' => date('Y-m-d H:i:s'),
				$this->alias . '.end_date >= ' => date('Y-m-d H:i:s')
			)
		);
	}
}
