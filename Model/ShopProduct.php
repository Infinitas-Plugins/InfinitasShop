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
 * @property ShopProductType $ShopProductType
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
		'updated' => true,
		'specials' => true,
		'spotlights' => true,
		'mostViewed' => true,
		'mostPurchased' => true
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
		),
		'ShopProductType' => array(
			'className' => 'Shop.ShopProductType',
			'foreignKey' => 'shop_product_type_id',
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
		'ShopCategoriesProduct' => array(
			'className' => 'Shop.ShopCategoriesProduct',
			'foreignKey' => 'shop_product_id',
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
		'ShopImagesProduct' => array(
			'className' => 'Shop.ShopImagesProduct',
			'foreignKey' => 'shop_product_id',
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
		'ShopList' => array(
			'className' => 'Shop.ShopList',
			'foreignKey' => 'shop_product_id',
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
		'ShopProductSize' => array(
			'className' => 'Shop.ShopProductSize',
			'foreignKey' => 'shop_product_id',
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
		'ShopSpecial' => array(
			'className' => 'Shop.ShopSpecial',
			'foreignKey' => 'shop_product_id',
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
		'ShopSpotlight' => array(
			'className' => 'Shop.ShopSpotlight',
			'foreignKey' => 'shop_product_id',
			'dependent' => true,
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
 * @brief find most viewed
 *
 * Wrapper for ShopProduct::_findPaginated() that sets the order on viewed field
 * and then by newest to give new products a chance to catch up
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findMostViewed($state, array $query, array $results = array()) {
		if($state == 'before') {
			$query = self::_findPaginated($state, $query);

			$query['order'] = array(
				$this->alias . '.views' => 'desc',
				$this->alias . '.created' => 'desc',
			);

			return $query;
		}

		return self::_findPaginated($state, $query, $results);
	}

/**
 * @brief find most viewed
 *
 * Wrapper for ShopProduct::_findPaginated() that sets the order on viewed field
 * and then by newest to give new products a chance to catch up
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findMostPurchased($state, array $query, array $results = array()) {
		if($state == 'before') {
			$query = self::_findPaginated($state, $query);

			$query['order'] = array(
				$this->alias . '.sales' => 'desc',
				$this->alias . '.created' => 'desc',
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
	protected function _findSpecials($state, array $query, array $results = array()) {
		if($state == 'before') {
			$query = self::_findPaginated($state, $query);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				$this->ShopSpecial->conditions()
			);
			$query['joins'][] = $this->autoJoinModel($this->ShopSpecial->fullModelName());

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
	protected function _findSpotlights($state, array $query, array $results = array()) {
		if($state == 'before') {
			$query = self::_findPaginated($state, $query);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				$this->ShopSpotlight->conditions()
			);
			$query['joins'][] = $this->autoJoinModel($this->ShopSpotlight->fullModelName());

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
			$query = $this->_findBasics($state, $query);

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
		$shopSpecials = $this->ShopSpecial->find('specials', $options);
		$shopSpotlights = $this->ShopSpotlight->find('spotlights', $options);
		$shopOptions = $this->ShopProductType->ShopProductTypesOption->ShopOption->find('options', $options);
		foreach($results as &$result) {
			unset($result['ActiveCategory']);
			$extractTemplate = sprintf('{n}[shop_product_id=%s]', $result[$this->alias][$this->primaryKey]);
			$result['ShopCategory'] = Hash::extract($shopCategories, $extractTemplate);
			$result['ShopSpecial'] = Hash::extract($shopSpecials, $extractTemplate);
			$result['ShopSpotlight'] = Hash::extract($shopSpotlights, $extractTemplate);
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
			if(empty($query[0])) {
				throw new InvalidArgumentException('No product selected');
			}

			$query = $this->_findBasics($state, $query);

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.product_code'
				)
			);

			$query['conditions']['or'] = array(
				$this->alias . '.' . $this->primaryKey => $query[0],
				$this->alias . '.slug' => $query[0]
			);

			$query['limit'] = 1;

			return $query;
		}

		if(empty($results[0][$this->alias][$this->primaryKey])) {
			return array();
		}

		$results = current($results);
		unset($results['ActiveCategory']);

		$options = array(
			'shop_product_id' => $results[$this->alias][$this->primaryKey],
			'extract' => true
		);

		$results['ShopOption'] = $this->ShopProductType->ShopProductTypesOption->ShopOption->find('options', $options);
		$results['ShopCategory'] = $this->ShopCategoriesProduct->ShopCategory->find('related', $options);
		$results['ShopBranchStock'] = $this->ShopBranchStock->find('productStock', $options);
		$results['ShopProductSize'] = $this->ShopProductSize->find('sizes', $options);
		$results['ShopSpecial'] = $this->ShopSpecial->find('specials', $options);
		$results['ShopSpotlight'] = $this->ShopSpotlight->find('spotlights', $options);
		$results['ShopImagesProduct'] = $this->ShopImagesProduct->find('images', $options);
		$results['ShopProductCode'] = $this->productCodes($results[$this->alias], $results['ShopOption']);

		return $results;
	}

/**
 * @brief get the product code built up based on options
 *
 * $product can be either id of a product or array with id / product code
 * if only the id is passed the rest will be figured out.
 *
 * $options can be passed in which are used to build the product code, if not
 * available this will be fetched fron the db.
 *
 * @param string|array $product
 * @param array $options
 *
 * @return string
 */
	public function productCodes($product, array $options = array()) {
		if(!is_array($product)) {
			$product = array(
				$this->primaryKey => $product,
				'product_code' => null
			);
		}

		if(empty($options)) {
			$options = $this->ShopProductType->ShopProductTypesOption->ShopOption->find('options', array(
				'shop_product_id' => $product[$this->primaryKey],
				'extract' => true
			));
		}

		if(empty($product['product_code'])) {
			$product['product_code'] = $this->field('product_code', array(
				$this->alias . '.' . $this->primaryKey => $product[$this->primaryKey]
			));
		}

		$shopOptions = Hash::combine($options,
			'{n}.' . $this->ShopProductType->ShopProductTypesOption->ShopOption->primaryKey,
			'{n}.slug'
		);
		$shopOptionValues = Hash::extract($options, '{n}.' . $this->ShopProductType->ShopProductTypesOption->ShopOption->ShopOptionValue->alias);

		$productCodes = array();
		foreach($shopOptionValues as $shopOptionValueSet) {
			foreach($shopOptionValueSet as $shopOptionValue) {
				$replacements = $productCode = array();
				$shopOptionId = null;
				foreach($shopOptions as $shopOptionId => $shopOptionSlug) {
					if($shopOptionValue['shop_option_id'] != $shopOptionId) {
						continue;
					}
					$productCode = array(
						'shop_option_id' => $shopOptionId,
						'shop_option_value_id' => $shopOptionValue[$this->ShopProductType->ShopProductTypesOption->ShopOption->ShopOptionValue->primaryKey]
					);
					$replacements[$shopOptionSlug] = $shopOptionValue['product_code'];
				}

				if($productCode) {
					$productCodes[] = array_merge(
						array('product_code' =>  String::insert($product['product_code'], $replacements)),
						$productCode
					);
				}
			}
		}

		return $productCodes;
	}

/**
 * @brief setup the basics for the product finds
 *
 * @param string $state
 * @param array $query
 * @param array $results
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findBasics($state, array $query, array $results = array()) {
		if($state == 'before') {
			$this->virtualFields['total_stock'] = sprintf('SUM(%s.stock)', $this->ShopBranchStock->alias);

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					'DISTINCT(ActiveCategory.id)',
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.' . $this->displayField,
					$this->alias . '.slug',
					$this->alias . '.total_stock',

					$this->ShopProductType->alias . '.' . $this->ShopProductType->primaryKey,
					$this->ShopProductType->alias . '.' . $this->ShopProductType->displayField,
					$this->ShopProductType->alias . '.slug',

					$this->ShopImage->alias . '.' . $this->ShopImage->primaryKey,
					$this->ShopImage->alias . '.image',

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

			$query['joins'][] = $this->autoJoinModel($this->ShopProductType->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopImage->fullModelName());
			//$query['joins'][] = $this->autoJoinModel($this->ShopSupplier->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopPrice->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopBranchStock->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopCategoriesProduct->fullModelName());
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopCategoriesProduct->fullModelName(),
				'model' => $this->ShopCategoriesProduct->ShopCategory->fullModelName(),
				'alias' => 'ActiveCategory'
			));

			return $query;
		}

		return $results;
	}

}
