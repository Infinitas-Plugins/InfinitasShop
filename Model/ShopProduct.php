<?php
/**
 * ShopProduct Model
 *
 * @property ShopImage $ShopImage
 * @property ShopSupplier $ShopSupplier
 * @property ShopBranchStock $ShopBranchStock
 * @property ShopCategoriesProduct $ShopCategoriesProduct
 * @property ShopImagesProduct $ShopImagesProduct
 * @property ShopList $ShopList
 * @property ShopProductSize $ShopProductSize
 * @property ShopSpecial $ShopSpecial
 * @property ShopSpotlight $ShopSpotlight
 * @property ShopPrice $ShopPrice
 * @property ShopProductsOption $ShopProductsOption
 * @property ShopProductSize $ShopProductSize
 */
class ShopProduct extends ShopAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * @brief custom find types
 *
 * @var array
 */
	public $findMethods = array(
		'product' => true,
		'paginated' => true,
		'new' => true,
		'updated' => true
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopImage' => array(
			'className' => 'Shop.ShopImage',
			'foreignKey' => 'shop_image_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopSupplier' => array(
			'className' => 'Shop.ShopSupplier',
			'foreignKey' => 'shop_supplier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasOne = array(
		'ShopPrice' => array(
			'className' => 'Shop.ShopPrice',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopPrice.model' => 'Shop.ShopProduct'
			),
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
		'ShopBranchStock' => array(
			'className' => 'Shop.ShopBranchStock',
			'foreignKey' => 'shop_product_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopCategoriesProduct' => array(
			'className' => 'Shop.ShopCategoriesProduct',
			'foreignKey' => 'shop_product_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopImagesProduct' => array(
			'className' => 'Shop.ShopImagesProduct',
			'foreignKey' => 'shop_product_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopList' => array(
			'className' => 'Shop.ShopList',
			'foreignKey' => 'shop_product_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopProductSize' => array(
			'className' => 'Shop.ShopProductSize',
			'foreignKey' => 'shop_product_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopSpecial' => array(
			'className' => 'Shop.ShopSpecial',
			'foreignKey' => 'shop_product_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopSpotlight' => array(
			'className' => 'Shop.ShopSpotlight',
			'foreignKey' => 'shop_product_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopProductsOption' => array(
			'className' => 'Shop.ShopProductsOption',
			'foreignKey' => 'shop_product_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopProductSize' => array(
			'className' => 'Shop.ShopProductSize',
			'foreignKey' => 'shop_product_id',
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
			'name' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'slug' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'description' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'specifications' => array(
				'notempty' => array(
					'rule' => array('notempty'),
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
			'rating_count' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'views' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'sales' => array(
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
 * @brief find new products
 *
 * Wrapper for ShopProduct::_findPaginated() that sets the order on created date
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findNew($state, array $query, array $results = array()) {
		if($state == 'before') {
			$query = self::_findPaginated($state, $query);

			$query['order'] = array(
				$this->alias . '.created' => 'desc'
			);

			return $query;
		}

		return self::_findPaginated($state, $query, $results);
	}

/**
 * @brief find recently updated products
 *
 * Wrapper for ShopProduct::_findPaginated() that sets the order on modified date
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findUpdated($state, array $query, array $results = array()) {
		if($state == 'before') {
			$query = self::_findPaginated($state, $query);

			$query['order'] = array(
				$this->alias . '.modified' => 'desc'
			);

			return $query;
		}

		return self::_findPaginated($state, $query, $results);
	}

/**
 * @brief find paginated list of products
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findPaginated($state, array $query, array $results = array()) {
		if($state == 'before') {
			$this->virtualFields['total_stock'] = sprintf('SUM(%s.stock)', $this->ShopBranchStock->alias);

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					'DISTINCT(ActiveCategory.id)',
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.slug',
					$this->alias . '.total_stock',
					$this->alias . '.' . $this->displayField,

					$this->ShopPrice->alias . '.' . $this->ShopPrice->primaryKey,
					$this->ShopPrice->alias . '.selling',
					$this->ShopPrice->alias . '.retail',
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.active' => 1,
					'ActiveCategory.active' => 1,
				)
			);

			$query['joins'] = array_filter($query['joins']);

			$query['joins'][] = $this->autoJoinModel($this->ShopPrice->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopBranchStock->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopCategoriesProduct->fullModelName());
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopCategoriesProduct->fullModelName(),
				'model' => $this->ShopCategoriesProduct->ShopCategory->fullModelName(),
				'alias' => 'ActiveCategory'
			));

			$query['group'] = array_merge(
				(array)$query['group'],
				array(
					$this->alias . '.' . $this->primaryKey
				)
			);

			return $query;
		}

		if(empty($results)) {
			return array();
		}

		$options = array(
			'shop_product_id' => Hash::extract($results, sprintf('{n}.%s.%s', $this->alias, $this->primaryKey)),
			'extract' => true
		);

		$shopCategories = $this->ShopCategoriesProduct->ShopCategory->find('related', $options);
		$shopOptions = $this->ShopProductsOption->ShopOption->find('options', $options);
		foreach($results as &$result) {
			unset($result['ActiveCategory']);
			$extractTemplate = sprintf('{n}[shop_product_id=%s]', $result[$this->alias][$this->primaryKey]);
			$result['ShopCategory'] = Hash::extract($shopCategories, $extractTemplate);
			$result['ShopOption'] = Hash::extract($shopOptions, $extractTemplate);
		}

		return $results;
	}

/**
 * @brief get a single product
 *
 * @param string $state the state of the find
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findProduct($state, array $query, array $results = array()) {
		if($state == 'before') {
			$this->virtualFields['total_stock'] = sprintf('SUM(%s.stock)', $this->ShopBranchStock->alias);
			if(empty($query[0])) {
				throw new InvalidArgumentException('No product selected');
			}

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					'DISTINCT(ActiveCategory.id)',
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.slug',
					$this->alias . '.total_stock',
					$this->alias . '.' . $this->displayField,

					$this->ShopPrice->alias . '.' . $this->ShopPrice->primaryKey,
					$this->ShopPrice->alias . '.selling',
					$this->ShopPrice->alias . '.retail',
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					'or' => array(
						$this->alias . '.' . $this->primaryKey => $query[0],
						$this->alias . '.slug' => $query[0]
					),
					$this->alias . '.active' => 1,
					'ActiveCategory.active' => 1,
				)
			);

			$query['joins'] = array_filter($query['joins']);

			$query['joins'][] = $this->autoJoinModel($this->ShopPrice->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopBranchStock->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopCategoriesProduct->fullModelName());
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopCategoriesProduct->fullModelName(),
				'model' => $this->ShopCategoriesProduct->ShopCategory->fullModelName(),
				'alias' => 'ActiveCategory'
			));

			$query['limit'] = 1;

			return $query;
		}

		if(empty($results)) {
			throw new CakeException('Product not found');
		}
		$results = current($results);
		unset($results['ActiveCategory']);

		$options = array(
			'shop_product_id' => $results[$this->alias][$this->primaryKey],
			'extract' => true
		);

		$results['ShopCategory'] = $this->ShopCategoriesProduct->ShopCategory->find('related', $options);
		$results['ShopOption'] = $this->ShopProductsOption->ShopOption->find('options', $options);
		$results['ShopBranchStock'] = $this->ShopBranchStock->find('productStock', $options);
		$results['ShopProductSize'] = $this->ShopProductSize->find('sizes', $options);

		return $results;
	}

}
