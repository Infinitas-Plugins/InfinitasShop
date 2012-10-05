<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopBranchStock Model
 *
 * @property ShopBranch $ShopBranch
 * @property ShopProduct $ShopProduct
 * @property ShopBranchStockLog $ShopBranchStockLog
 */
class ShopBranchStock extends ShopAppModel {
	public $findMethods = array(
		'productStock' => true,
		'isInStock' => true
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopBranch' => array(
			'className' => 'ShopBranch',
			'foreignKey' => 'shop_branch_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopProduct' => array(
			'className' => 'ShopProduct',
			'foreignKey' => 'shop_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopBranchStockLog' => array(
			'className' => 'ShopBranchStockLog',
			'foreignKey' => 'shop_branch_stock_id',
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

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'shop_branch_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
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
			'stock' => array(
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

		$this->virtualFields['total_stock'] = sprintf('SUM(%s.stock)', $this->alias);
	}

/**
 * @brief find stock for a product in various branches
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findProductStock($state, array $query, array $results = array()) {
		if($state == 'before') {
			if(empty($query['shop_product_id'])) {
				throw new InvalidArgumentException('No product selected');
			}

			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.shop_branch_id',
				$this->alias . '.stock'
			));

			$query['conditions'][$this->alias . '.shop_product_id'] = $query['shop_product_id'];


			return $query;
		}

		if(isset($query['extract']) && $query['extract']) {
			return Hash::extract($results, '{n}.' . $this->alias);
		}

		return $results;
	}

/**
 * @brief check if a product(s) is in stock
 *
 * @code
 *  // checking a single product
 *	var_dump($this->ShopBranchStock->find('isInStock', array('shop_product_id' => 'product-1')));
 *	array(
 *		'product-1' => true // or false
 *	);
 *
 *  // checking multiple products
 *	var_dump($this->ShopBranchStock->find('isInStock', array('shop_product_id' => array('product-1', 'product-2'))));
 *	array(
 *		'product-1' => true // or false
 *		'product-2' => false // or true
 *	);
 * @endcode
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findIsInStock($state, array $query, array $results = array()) {
		if($state == 'before') {
			if(empty($query['shop_product_id'])) {
				throw new InvalidArgumentException('No product selected');
			}

			$query['fields'] = array(
				$this->alias . '.shop_product_id',
				'total_stock'
			);

			$query['conditions'][$this->alias . '.shop_product_id'] = $query['shop_product_id'];

			return $query;
		}

		$results = array_filter(Hash::combine($results,
			'{n}.' . $this->alias . '.shop_product_id',
			'{n}.' . $this->alias . '.total_stock'
		));
		array_walk($results, function(&$record) {
			$record = (bool)$record;
		});

		return $results;
	}

}
