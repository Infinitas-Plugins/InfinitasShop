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
		'isInStock' => true,
		'totalProductStock' => true
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
			'className' => 'Shop.ShopBranch',
			'foreignKey' => 'shop_branch_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
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
			'className' => 'Shop.ShopBranchStockLog',
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

/**
 * @brief override the construct to add translated validation
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'shop_branch_id' => array(
				'validateRecordExists' => array(
					'rule' => array('validateRecordExists'),
					'message' => __d('shop', 'Specified branch does not exist'),
					'allowEmpty' => false,
					'required' => true
				),
			),
			'shop_product_id' => array(
				'validateRecordExists' => array(
					'rule' => array('validateRecordExists'),
					'message' => __d('shop', 'Specified branch does not exist'),
					'allowEmpty' => false,
					'required' => true
				),
			),
			'stock' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('shop', 'The specified amount should be numeric'),
					'allowEmpty' => false,
					'required' => true
				),
			),
		);
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

			$this->virtualFields['total_stock'] = sprintf('SUM(%s.stock)', $this->alias);

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

/**
 * @brief add stock to a specific branch
 *
 * Required data:
 *  - shop_branch_id: the branch stock is being added to
 *  - shop_product_id: the product that is getting new stock
 *  - change: number of items being added
 *  - notes: reason for the change, PO, return etc.
 *
 * @see ShopBranchStock::_normaliseStock()
 *
 * @param array $stock the data being added
 */
	public function addStock(array $stock) {
		$stock = $this->_normaliseStock($stock);
		if(!$this->ShopBranchStockLog->saveAll($stock)) {
			return false;
		}
		return $this->updateStock($stock);
	}

/**
 * @brief remove stock from a specific branch
 *
 * Required data:
 *  - shop_branch_id: the branch stock is being removed from
 *  - shop_product_id: the product that is having stock reduced
 *  - change: number of items being removed
 *  - notes: reason for the change, sale, damage, returned to supplier etc
 *
 * @see ShopBranchStock::_normaliseStock()
 *
 * @param array $stock the data being added
 */
	public function removeStock(array $stock) {
		$stock = $this->_normaliseStock($stock, false);
		if(!$this->ShopBranchStockLog->saveAll($stock)) {
			return false;
		}
		return $this->updateStock($stock);
	}

/**
 * @brief normalise the stock array for easy handeling
 *
 * @param array $stock the stock data
 * @param boolean $add adding or removing stock
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _normaliseStock(array $stock, $add = true) {
		if(!is_int(current(array_keys($stock)))) {
			$stock = array($stock);
		}

		foreach($stock as $k => $v) {
			if(empty($v['shop_branch_stock_id'])) {
				if(empty($v['shop_product_id']) || empty($v['shop_branch_id'])) {
					unset($stock[$k]);
					continue;
				}

				$stock[$k]['shop_branch_stock_id'] = $this->field('id', array(
					'shop_product_id' => $v['shop_product_id'],
					'shop_branch_id' => $v['shop_branch_id']
				));

				if(($add && $stock[$k]['change'] < 0) || (!$add && $stock[$k]['change'] > 0)) {
					$stock[$k]['change'] = intval($stock[$k]['change']) * -1;
				}
			}

			if(empty($v['notes'])) {
				if($add) {
					$stock[$k]['notes'] = 'Adding stock';
				} else {
					$stock[$k]['notes'] = 'Removing stock';
				}
			}
		}

		if(empty($stock)) {
			throw new InvalidArgumentException('No stock to update');
		}

		return $stock;
	}

/**
 * @brief update the total stock available for the product / branch combo
 *
 * @param array $stock the stock data
 *
 * @return boolean
 */
	public function updateStock(array $stock) {
		$saved = true;
		foreach($stock as $k => $v) {
			$saved = $saved && $this->updateAll(
				array($this->alias . '.stock' => $this->find('totalProductStock', $v) + $v['change']),
				array(
					$this->alias . '.shop_branch_id' => $v['shop_branch_id'],
					$this->alias . '.shop_product_id' => $v['shop_product_id'],
				)
			);
		}
		return $saved;
	}

/**
 * @brief find a products total stock count
 *
 * @param array $state
 * @param array $query
 * @param array $results
 *
 * @return int
 */
	protected function _findTotalProductStock($state, array $query, array $results = array()) {
		$this->virtualFields['total_stock'] = sprintf('SUM(%s.stock)', $this->alias);

		if($state == 'before') {
			if(!empty($query['shop_branch_id'])) {
				$query['conditions'][$this->alias . '.shop_branch_id'] = $query['shop_branch_id'];
			}

			if(!empty($query['shop_product_id'])) {
				$query['conditions'][$this->alias . '.shop_product_id'] = $query['shop_product_id'];
			}

			$query['fields'] = array(
				'total_stock'
			);

			return $query;
		}

		if(!empty($results[0][$this->alias]['total_stock'])) {
			return $results[0][$this->alias]['total_stock'];
		}

		return 0;
	}

}