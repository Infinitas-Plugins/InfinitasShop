<?php
/**
 * ShopSpotlight Model
 *
 * @property ShopProduct $ShopProduct
 * @property ShopImage $ShopImage
 */
class ShopSpotlight extends ShopAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'spotlights' => true
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
				'datetime' => array(
					'rule' => array('datetime'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'end_date' => array(
				'datetime' => array(
					'rule' => array('datetime'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'active' => array(
				'numeric' => array(
					'rule' => array('numeric'),
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
	protected function _findSpotlights($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query['shop_product_id'])) {
				throw new InvalidArgumentException('No product selected');
			}

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.shop_product_id',
					$this->alias . '.start_date',
					$this->alias . '.end_date',
					$this->ShopImage->alias . '.' . $this->ShopImage->primaryKey,
					$this->ShopImage->alias . '.image',
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				$this->conditions(),
				array(
					$this->alias . '.shop_product_id' => $query['shop_product_id'],
				)
			);

			$query['joins'] = array_merge(
				(array)$query['joins'],
				array(
					$this->autoJoinModel($this->ShopImage->fullModelName())
				)
			);

			return $query;
		}

		if (empty($results)) {
			return array();
		}

		foreach ($results as &$result) {
			$result[$this->alias][$this->ShopImage->alias] = $result[$this->ShopImage->alias];
			unset($result[$this->ShopImage->alias]);
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
				$this->alias . '.start_date <= ' => date('Y-m-d H:i:s'),
				$this->alias . '.end_date >= ' => date('Y-m-d H:i:s')
			)
		);
	}
}
