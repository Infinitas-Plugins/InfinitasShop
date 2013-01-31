<?php
/**
 * ShopProduct Model
 *
 * @package Shop.Model
 */

/**
 * ShopProduct Model
 *
 * @package Shop.Model
 *
 * @property ShopImage $ShopImage
 * @property ShopSupplier $ShopSupplier
 * @property ShopBrand $ShopBrand
 * @property ShopCategoriesProduct $ShopCategoriesProduct
 * @property ShopImagesProduct $ShopImagesProduct
 * @property ShopProductsSpecial $ShopProductsSpecial
 * @property ShopSpotlight $ShopSpotlight
 * @property ShopProductType $ShopProductType
 * @property ShopSize $ShopSize
 * @property ShopProductVariant $ShopProductVariant
 * @property ShopProductVariant $ShopProductVariantMaster
 */

class ShopProduct extends ShopAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * custom find types
 *
 * @var array
 */
	public $findMethods = array(
		'product' => true,
		'productOptions' => true,
		'productShipping' => true,
		'paginated' => true,
		'adminPaginated' => true,
		'productsForList' => true,
		'productsForOrder' => true,
		'costForList' => true,
		'prodcutListShipping' => true,
		'new' => true,
		'updated' => true,
		'specials' => true,
		'spotlights' => true,
		'mostViewed' => true,
		'mostPurchased' => true,
		'recentlyViewed' => true,
		'search' => true,
		'possibleOptions' => true,
		'orderQuantity' => true
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
		),
		'ShopBrand' => array(
			'className' => 'Shop.ShopBrand',
			'foreignKey' => 'shop_brand_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => 'shop_product_count'
		)
	);

/**
 * HasOne relations
 *
 * @var array
 */
	public $hasOne = array(
		'ShopSize' => array(
			'className' => 'Shop.ShopSize',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopSize.model' => 'Shop.ShopProduct'
			),
			'fields' => '',
			'order' => ''
		),
		'ShopCurrentSpecial' => array(
			'className' => 'Shop.ShopSpecial',
			'foreignKey' => 'shop_product_id',
			'conditions' => array(
				'ShopCurrentSpecial.active' => 1
			),
			'fields' => '',
			'order' => ''
		),
		'ShopCurrentSpotlight' => array(
			'className' => 'Shop.ShopSpotlight',
			'foreignKey' => 'shop_product_id',
			'conditions' => array(
				'ShopCurrentSpotlight.active' => 1
			),
			'fields' => '',
			'order' => ''
		),
		'ShopProductVariantMaster' => array(
			'className' => 'Shop.ShopProductVariant',
			'foreignKey' => 'shop_product_id',
			'dependent' => true,
			'conditions' => array(
				'ShopProductVariantMaster.master' => 1
			),
			'fields' => '',
			'order' => '',
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
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
		'ShopProductsSpecial' => array(
			'className' => 'Shop.ShopProductsSpecial',
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
		),
		'ShopProductVariant' => array(
			'className' => 'Shop.ShopProductVariant',
			'foreignKey' => 'shop_product_id',
			'dependent' => true,
			'conditions' => array(
				'ShopProductVariant.master' => 0
			),
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
 * overload the construct for translated validation messages
 *
 * A number of virtual fields are made available to the product model that contains
 * usefull information such as markups and margin.
 * 	- markup_amount: the value amount of the markup (negative means product is selling at a loss)
 *  - markup_percentage: the % amount of markup (negative means product is selling at a loss)
 *  - margin: the % of margin for the product
 *  - conversion_rate: the rate of views to purchases made.
 *
 * @param boolean $id    [description]
 * @param [type]  $table [description]
 * @param [type]  $ds    [description]
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->order = array(
			$this->fullFieldName($this->displayField) => 'asc'
		);

		$this->virtualFields['markup_amount'] = String::insert(':ShopPrice.selling - :ShopPrice.cost', array(
			'ShopPrice' => $this->ShopProductVariantMaster->ShopProductVariantPrice->alias
		));

		$this->virtualFields['markup_percentage'] = String::insert('ROUND(((:ShopPrice.selling - :ShopPrice.cost) / :ShopPrice.cost) * 100, 3)', array(
			'ShopPrice' => $this->ShopProductVariantMaster->ShopProductVariantPrice->alias
		));

		$this->virtualFields['margin'] = String::insert('ROUND(((:ShopPrice.selling - :ShopPrice.cost) / :ShopPrice.selling) * 100, 3)', array(
			'ShopPrice' => $this->ShopProductVariantMaster->ShopProductVariantPrice->alias
		));

		$this->virtualFields['conversion_rate'] = String::insert('ROUND((:ShopProduct.sales / :ShopProduct.views) * 100, 3)', array(
			'ShopProduct' => $this->alias
		));

		$this->validate = array(
			'name' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'Please enter the name of this product'),
					'allowEmpty' => false,
					'required' => true
				),
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => __d('shop', 'A product with that name already exists'),
				)
			),
			'description' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'Please enter the description for this product'),
					'allowEmpty' => false,
					'required' => true
				),
			),
			'active' => array(
				'boolean' => array(
					'rule' => 'boolean',
					'message' => __d('shop', 'Active should be boolean')
				),
			),
			'shop_image_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'The selected image does not exist'),
					'allowEmpty' => true
				)
			),
			'shop_product_type_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'The selected product type does not exist'),
					'allowEmpty' => true
				)
			),
			'shop_supplier_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'The selected supplier does not exist'),
					'allowEmpty' => true
				)
			),
			'shop_brand_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'The selected brand does not exist'),
					'allowEmpty' => true
				)
			),
			'available' => array(
				'datetime' => array(
					'rule' => array('datetime', 'ymd'),
					'message' => __d('shop', 'Please enter a valid date'),
					'allowEmpty' => false
				)
			)
		);
	}

/**
 * Get the order quantity details for the product
 *
 * This info is used in validating that the correct amount of product has been added to the cart such
 * as the minimum, maximum and quantity units.
 *
 * @param type $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findOrderQuantity($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query = array_merge(array(
				'shop_product_id' => null,
				'shop_product_variant_id' => null
			), $query);

			if (empty($query['shop_product_id'])) {
				if (empty($query['shop_product_variant_id'])) {
					throw new InvalidArgumentException(__d('shop', 'No product selected for order quantity'));
				}
			}

			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.quantity_unit',
				$this->alias . '.quantity_min',
				$this->alias . '.quantity_max'
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				'or' => array(
					$this->alias . '.' . $this->primaryKey => $query['shop_product_id'],
					$this->ShopProductVariantMaster->alias . '.' . $this->ShopProductVariantMaster->primaryKey => $query['shop_product_variant_id'],
					$this->ShopProductVariant->alias . '.' . $this->ShopProductVariant->primaryKey => $query['shop_product_variant_id']
				)
			));

			$query['joins'][] = $this->autoJoinModel($this->ShopProductVariantMaster->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopProductVariant->fullModelName());

			$query['limit'] = 1;

			return $query;
		}

		if (empty($results[0][$this->alias])) {
			return array();
		}

		return $results[0][$this->alias];
	}

/**
 * find new products
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
		if ($state == 'before') {
			$query = self::_findPaginated($state, $query);

			$query['order'] = array(
				$this->alias . '.created' => 'desc'
			);

			return $query;
		}

		return self::_findPaginated($state, $query, $results);
	}

/**
 * find recently updated products
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
		if ($state == 'before') {
			$query = self::_findPaginated($state, $query);

			$query['order'] = array(
				$this->alias . '.modified' => 'desc'
			);

			return $query;
		}

		return self::_findPaginated($state, $query, $results);
	}

/**
 * find most viewed
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
		if ($state == 'before') {
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
 * find most purchased
 *
 * Wrapper for ShopProduct::_findPaginated() that sets the order on sales field
 * and then by newest to give new products a chance to catch up
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findMostPurchased($state, array $query, array $results = array()) {
		if ($state == 'before') {
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
 * get a list of recently viewed products
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findRecentlyViewed($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query = self::_findPaginated($state, $query);

			$this->virtualFields['view_date'] = 'MAX(ViewCounterView.created)';

			$query['joins'][] = $this->autoJoinModel(array(
				'model' => ClassRegistry::init('ViewCounter.ViewCounterView'),
				'conditions' => array(
					'ViewCounterView.foreign_key = ' . $this->alias . '.' . $this->primaryKey,
					'ViewCounterView.model' => $this->fullModelName(),
					'ViewCounterView.user_id' => $this->currentUserId()
				),
				'type' => 'right'
			));

			$query['order'] = array(
				'view_date' => 'desc'
			);
			return $query;
		}

		return self::_findPaginated($state, $query, $results);
	}

/**
 * find recently updated products
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
		if ($state == 'before') {
			$query = self::_findPaginated($state, $query);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				$this->ShopProductsSpecial->ShopSpecial->conditions()
			);
			$query['joins'][] = $this->autoJoinModel($this->ShopProductsSpecial->fullModelName());
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopProductsSpecial->fullModelName(),
				'model' => $this->ShopProductsSpecial->ShopSpecial->fullModelName()
			));

			return $query;
		}

		return self::_findPaginated($state, $query, $results);
	}

/**
 * find recently updated products
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
		if ($state == 'before') {
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
 * find products for a list
 *
 * This gets the product details for the selected (or default) shopping list. Generally used for
 * a chechout page and completing orders
 *
 * @param type $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findProductsForList($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query['shop_list_id'])) {
				$query['shop_list_id'] = $this->ShopProductVariant->ShopListProduct->ShopList->currentListId(true);
			}
			$query['variants'] = false;
			$query = $this->_findBasics($state, $query);

			array_shift($query['fields']);

			$stock = array_search($this->alias . '.total_stock', $query['fields']);
			if ($stock !== false) {
				unset($query['fields'][$stock]);
			}

			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->ShopProductVariant->alias . '.*',

				$this->ShopProductVariant->ShopListProduct->alias . '.' . $this->ShopProductVariant->ShopListProduct->primaryKey,
				$this->ShopProductVariant->ShopListProduct->alias . '.shop_list_id',
				$this->ShopProductVariant->ShopListProduct->alias . '.shop_product_variant_id',
				$this->ShopProductVariant->ShopListProduct->alias . '.quantity',
				$this->ShopProductVariant->ShopListProduct->alias . '.created',
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->ShopProductVariant->ShopListProduct->alias . '.shop_list_id' => $query['shop_list_id']
			));

			$query['joins'][] = $this->autoJoinModel($this->ShopSize->fullModelName());
			$query['joins'][] = $this->ShopProductVariant->autoJoinModel(array(
				'model' => $this->ShopProductVariant->ShopListProduct->fullModelName(),
				'type' => 'right'
			));

			$query['group'] = array_merge((array)$query['group'], array(
				$this->ShopProductVariant->ShopListProduct->alias . '.' . $this->ShopProductVariant->ShopListProduct->primaryKey
			));

			return $query;
		}

		$results = $this->_findBasics($state, $query, $results);

		$options = array(
			'shop_product_id' => Hash::extract($results, sprintf('{n}.%s.%s', $this->alias, $this->primaryKey)),
			'extract' => true
		);

		if (empty($results[0][$this->alias][$this->primaryKey]) && !array_filter($options['shop_product_id'])) {
			return array();
		}

		$variantOptions = $this->ShopProductVariant->ShopOptionVariant->find('variants', array(
			'shop_product_variant_id' => Hash::extract($results, '{n}.ShopProductVariant.id')
		));
		$shopCategories = $this->ShopCategoriesProduct->ShopCategory->find('related', $options);
		foreach ($results as &$result) {
			unset($result['ActiveCategory']);
			$extractTemplate = sprintf('{n}[shop_product_id=%s]', $result[$this->alias][$this->primaryKey]);
			$result[$this->ShopCategoriesProduct->ShopCategory->alias] = Hash::extract($shopCategories, $extractTemplate);

			$extractTemplate = sprintf('{n}[shop_product_variant_id=%s]', $result[$this->ShopProductVariant->alias][$this->ShopProductVariant->primaryKey]);
			$result['ShopProductVariant']['ShopOptionVariant'] = Hash::extract($variantOptions, $extractTemplate);

			$result['ShopProductVariant']['ShopProductVariantPrice'] = &$result['ShopProductVariantMaster']['ShopProductVariantPrice'];
			$result['ShopProductVariant']['ShopProductVariantSize'] = &$result['ShopProductVariantMaster']['ShopProductVariantSize'];

			$this->_productOverride($result);

			$quantity = $result['ShopListProduct']['quantity'];
			foreach (array('cost', 'selling', 'retail') as $field) {
				$result['ShopProductVariant']['ShopProductListPrice'][$field] = $result['ShopProductVariant']['ShopProductVariantPrice'][$field] * $quantity;
				$result['ShopOrderProductPrice'][$field] = $result['ShopProductVariant']['ShopProductVariantPrice'][$field];
			}

			$fields = $result['ShopProductVariant']['ShopProductVariantSize'];
			unset($fields['id']);
			foreach (array_keys($fields) as $field) {
				$result['ShopProductVariant']['ShopProductListSize'][$field] = $result['ShopProductVariant']['ShopProductVariantSize'][$field] * $quantity;
				$result['ShopOrderProductSize'][$field] = $result['ShopProductVariant']['ShopProductVariantSize'][$field];
			}
		}

		return $results;
	}

/**
 * Get products related to the specified order
 *
 * If doing admin calls pass 'admin' => true to skip forcing the current user id. Normal users
 * will only be able to see their own orders.
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findProductsForOrder($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query['shop_order_id'])) {
				throw new InvalidArgumentException(__d('shop', 'No order specified'));
			}

			$query['variants'] = false;
			$query = $this->_findBasics($state, $query);

			array_shift($query['fields']);

			$stock = array_search($this->alias . '.total_stock', $query['fields']);
			if ($stock !== false) {
				unset($query['fields'][$stock]);
			}

			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->ShopProductVariant->alias . '.*',
				$this->ShopProductVariant->ShopOrderProduct->alias . '.*',
				$this->ShopProductVariant->ShopOrderProduct->ShopOrderProductSize->alias . '.*',
				$this->ShopProductVariant->ShopOrderProduct->ShopOrderProductPrice->alias . '.*',
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->ShopProductVariant->ShopOrderProduct->alias . '.shop_order_id' => $query['shop_order_id']
			));

			$admin = array_key_exists('admin', $query) && $query['admin'] === true;
			if (!$admin) {
				$query['conditions'][$this->ShopProductVariant->ShopOrderProduct->ShopOrder->alias . '.user_id'] = $this->currentUserId();
			}

			$query['joins'][] = $this->autoJoinModel($this->ShopSize->fullModelName());
			$query['joins'][] = $this->ShopProductVariant->autoJoinModel(array(
				'model' => $this->ShopProductVariant->ShopOrderProduct->fullModelName(),
				'type' => 'right'
			));
			$query['joins'][] = $this->ShopProductVariant->ShopOrderProduct->autoJoinModel(array(
				'model' => $this->ShopProductVariant->ShopOrderProduct->ShopOrder
			));
			$query['joins'][] = $this->ShopProductVariant->ShopOrderProduct->autoJoinModel(array(
				'model' => $this->ShopProductVariant->ShopOrderProduct->ShopOrderProductPrice,
				'conditions' => array(
					'ShopOrderProductPrice.foreign_key = ShopOrderProduct.id',
					'ShopOrderProductPrice.model = "Shop.ShopOrderProduct"'
				)
			));
			$query['joins'][] = $this->ShopProductVariant->ShopOrderProduct->autoJoinModel(array(
				'model' => $this->ShopProductVariant->ShopOrderProduct->ShopOrderProductSize,
				'conditions' => array(
					'ShopOrderProductSize.foreign_key = ShopOrderProduct.id',
					'ShopOrderProductSize.model = "Shop.ShopOrderProduct"'
				)
			));

			$query['group'] = array_merge((array)$query['group'], array(
				$this->ShopProductVariant->ShopOrderProduct->alias . '.' . $this->ShopProductVariant->ShopOrderProduct->primaryKey
			));

			$query['order'] = array(
				$this->ShopProductVariant->ShopOrderProduct->alias . '.' . $this->ShopProductVariant->ShopOrderProduct->displayField
			);

			return $query;
		}

		$results = $this->_findBasics($state, $query, $results);

		$options = array(
			'shop_product_id' => Hash::extract($results, sprintf('{n}.%s.%s', $this->alias, $this->primaryKey)),
			'extract' => true
		);

		if (empty($results[0][$this->alias][$this->primaryKey]) && !array_filter($options['shop_product_id'])) {
			return array();
		}

		$variantOptions = $this->ShopProductVariant->ShopOptionVariant->find('variants', array(
			'shop_product_variant_id' => Hash::extract($results, '{n}.ShopProductVariant.id')
		));
		$shopCategories = $this->ShopCategoriesProduct->ShopCategory->find('related', $options);
		foreach ($results as &$result) {
			unset($result['ActiveCategory']);
			$extractTemplate = sprintf('{n}[shop_product_id=%s]', $result[$this->alias][$this->primaryKey]);
			$result[$this->ShopCategoriesProduct->ShopCategory->alias] = Hash::extract($shopCategories, $extractTemplate);

			$extractTemplate = sprintf('{n}[shop_product_variant_id=%s]', $result[$this->ShopProductVariant->alias][$this->ShopProductVariant->primaryKey]);
			$result['ShopProductVariant']['ShopOptionVariant'] = Hash::extract($variantOptions, $extractTemplate);

			$result['ShopProductVariant']['ShopProductVariantPrice'] = &$result['ShopProductVariantMaster']['ShopProductVariantPrice'];
			$result['ShopProductVariant']['ShopProductVariantSize'] = &$result['ShopProductVariantMaster']['ShopProductVariantSize'];
			$this->_productOverride($result);
		}

		return $results;
	}

/**
 * Calculate the total value of all products in a list
 *
 * This calculates the total cost of goods in the cart that can be used for sub total and figuring out
 * what methods of shipping are available to the user (as shipping can be based on cart total)
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return float
 */
	protected function _findCostForList($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query = self::_findProductsForList($state, $query);
			return $query;
		}

		if (empty($results)) {
			return 0;
		}

		$results = self::_findProductsForList($state, $query, $results);
		return array_sum(Hash::extract($results, '{n}.ShopProductVariant.ShopProductListPrice.selling'));
	}

/**
 * Paginated list of products but includes products that are inactive.
 *
 * This method should only be used in the backend code or users will be able to view products that
 * are not yet active or available
 *
 * @param type $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findAdminPaginated($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query['admin'] = true;

			$this->virtualFields['category_active'] = 'ActiveCategory.active';
			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->fullFieldName('modified'),
				$this->fullFieldName('available'),
				//$this->ShopPrice->fullFieldName('cost'),
				$this->ShopSupplier->fullFieldName($this->ShopSupplier->primaryKey),
				$this->ShopSupplier->fullFieldName($this->ShopSupplier->displayField),
				$this->ShopSupplier->fullFieldName('active'),
				$this->ShopBrand->fullFieldName('active'),
				$this->ShopProductType->fullFieldName('active'),
				'category_active',
				'total_stock'
			));

			return self::_findPaginated($state, $query);
		}

		$results = self::_findPaginated($state, $query, $results);
		if (empty($results)) {
			return array();
		}

		$shopStockValues = $this->ShopProductVariant->ShopBranchStock->find('stockValue', array(
			'shop_product_id' => Hash::extract($results, '{n}.ShopProduct.id')
		));

		foreach ($results as &$result) {
			$extractTemplate = sprintf('{n}[shop_product_id=%s]', $result[$this->alias][$this->primaryKey]);
			$result['ShopStockValue'] = current(Hash::extract($shopStockValues, $extractTemplate));
		}

		return $results;
	}

/**
 * custom find method for product search
 *
 * There are a number of ways to do searches.
 * - Normal search: `query` the default will do a query with `field LIKE "%query%"`
 *		Search will be 'OR' based
 * - Specify the wild card: `%uery`, `quer%` or `qu%ry` will do a query with `field LIKE "quer%"`
 * - Specify not: If first char is ! the query will be `field NOT LIKE "query"`.
 *		wildcard can also be included, search will be 'AND' based
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findSearch($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query['search'])) {
				throw new InvalidArgumentException(__d('shop', 'No search string provided'));
			}

			$like = 'LIKE';
			$opperator = 'or';
			if (substr($query['search'], 0, 1) == '!') {
				$like = 'NOT LIKE';
				$opperator = 'and';
				$query['search'] = substr($query['search'], 1);
			}

			$match = '%:search%';
			if (strstr($query['search'], '%')) {
				$match = ':search';
			}

			$search = array(
				'%'
			);
			$replace = array(
				'---WILDCARD---'
			);
			$query['search'] = str_replace($search, $replace, $query['search']);
			$query['search'] = Sanitize::escape($query['search'], $this->useDbConfig);
			$query['search'] = str_replace($replace, $search, $query['search']);

			$like = sprintf(' %s "%s"', $like, String::insert($match, array('search' => $query['search'])));
			$conditions = array(
				$this->alias . '.' . $this->displayField,
				$this->alias . '.product_code',
				$this->ShopProductType->alias . '.' . $this->ShopProductType->displayField,
				$this->ShopBrand->alias . '.' . $this->ShopBrand->displayField,
				$this->ShopSupplier->alias . '.' . $this->ShopSupplier->displayField,
				'ActiveCategory.' . $this->ShopCategoriesProduct->ShopCategory->displayField,
			);
			foreach ($conditions as &$condition) {
				$condition .= $like;
			}
			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$opperator => $conditions
			));

			return self::_findPaginated($state, $query);
		}

		return self::_findPaginated($state, $query, $results);
	}

/**
 * find paginated list of products, general product lists that show basic information such as the index
 * or search pages.
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findPaginated($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query = $this->_findBasics($state, array_merge(array(
				'variants' => false
			), $query));

			$query['fields'][] = $this->fullFieldName('description');

			$query['group'] = array_merge(
				(array)$query['group'],
				array(
					$this->alias . '.' . $this->primaryKey
				)
			);

			return $query;
		}

		if (empty($results)) {
			return array();
		}

		$results = $this->_findBasics($state, $query, $results);

		$options = array(
			'shop_product_id' => Hash::extract($results, sprintf('{n}.%s.%s', $this->alias, $this->primaryKey)),
			'extract' => true
		);

		$shopCategories = $this->ShopCategoriesProduct->ShopCategory->find('related', $options);
		$shopSpecials = $this->ShopProductsSpecial->ShopSpecial->find('specials', $options);
		$shopSpotlights = $this->ShopSpotlight->find('spotlights', $options);
		//$shopOptions = $this->ShopProductType->ShopProductTypesOption->ShopOption->find('options', $options);
		foreach ($results as &$result) {
			unset($result['ActiveCategory']);
			$extractTemplate = sprintf('{n}[shop_product_id=%s]', $result[$this->alias][$this->primaryKey]);
			$result['ShopCategory'] = Hash::extract($shopCategories, $extractTemplate);
			$result['ShopSpecial'] = Hash::extract($shopSpecials, $extractTemplate);
			$result['ShopSpotlight'] = Hash::extract($shopSpotlights, $extractTemplate);
			//$result['ShopOption'] = Hash::extract($shopOptions, $extractTemplate);
		}

		return $results;
	}

/**
 * find the values for calculating shipping
 *
 * returns the max width, height, length and cost based on the
 * worst case senario
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findProductShipping($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (!empty($query['shop_product_id'])) {
				$query[0] = $query['shop_product_id'];
			}
			return self::_findProduct($state, $query);
		}
		$results = self::_findProduct($state, $query, $results);

		if (empty($results)) {
			return array();
		}

		return array(
			'cost' => 0,
			'wight' => 0
		);
		$size = array(
			'Master' => $results['ShopProductVariantMasterSize'],
			'Variant' => $results['ShopProductVariantSize'],
		);
		return array_merge(array(
			'cost' => ShopProductVariant::productPrice(array(
				'Master' => $results['ShopProductVariantMasterPrice'],
				'Variant' => $results['ShopProductVariantPrice']
			)),
			'weight' => ShopProductVariant::productWeight($size)
		), ShopProductVariant::productSize($size));
	}

/**
 * find the total values for shipping on an entire product list
 *
 * This calculates the actual price of shipping for a carts contents. This requires that the user has
 * already selected a shipping method for the total to be calculated.
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findProdcutListShipping($state, array $query, array $results = array()) {
		if ($state == 'before') {
			return self::_findProductsForList($state, $query);
		}

		if (empty($results)) {
			return array();
		}

		$results = self::_findProductsForList($state, $query, $results);

		foreach ($results as &$result) {
			$result = array(
				'cost' => $result['ShopProductVariant']['ShopProductListPrice']['selling'],
				'weight' => $result['ShopProductVariant']['ShopProductListSize']['shipping_weight'],
				'width' => $result['ShopProductVariant']['ShopProductListSize']['shipping_width'],
				'length' => $result['ShopProductVariant']['ShopProductListSize']['shipping_length'],
				'height' => $result['ShopProductVariant']['ShopProductListSize']['shipping_height'],
			);
		}

		return array(
			'cost' => array_sum(Hash::extract($results, '{n}.cost')),
			'weight' => array_sum(Hash::extract($results, '{n}.weight')),
			'width' => max(Hash::extract($results, '{n}.width')),
			'height' => max(Hash::extract($results, '{n}.height')),
			'length' => max(Hash::extract($results, '{n}.length'))
		);
	}

/**
 * get a single product for display, generaly the product view page
 *
 * @param string $state the state of the find
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findProduct($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query[0])) {
				throw new InvalidArgumentException('No product selected to find');
			}

			$query = $this->_findBasics($state, $query);

			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.product_code',
				$this->alias . '.description',
				$this->alias . '.specifications',
				$this->alias . '.available',
				$this->alias . '.quantity_unit',
				$this->alias . '.quantity_min',
				$this->alias . '.quantity_max',
			));

			$query['conditions']['or'] = array(
				$this->alias . '.' . $this->primaryKey => $query[0],
				$this->alias . '.slug' => $query[0]
			);

			$query['joins'][] = $this->autoJoinModel($this->ShopSize->fullModelName());

			$this->unBindModel(array('hasOne' => array('ShopCurrentSpecial')), false);

			$query['limit'] = 1;

			return $query;
		}

		$results = $this->_findBasics($state, $query, $results);

		if (empty($results[0][$this->alias][$this->primaryKey])) {
			return array();
		}

		$results = current($this->_findBasics($state, $query, $results));
		unset($results['ActiveCategory']);

		$options = array(
			'shop_product_id' => $results[$this->alias][$this->primaryKey],
			'extract' => true
		);

		$results['ShopCategory'] = $this->ShopCategoriesProduct->ShopCategory->find('related', $options);
		$results['ShopSpecial'] = $this->ShopProductsSpecial->ShopSpecial->find('specials', $options);
		$results['ShopSpotlight'] = $this->ShopSpotlight->find('spotlights', $options);
		$results['ShopImagesProduct'] = $this->ShopImagesProduct->find('images', $options);

		if (array_key_exists('admin', $query) && $query['admin']) {
			$variantStockValue = $this->ShopProductVariant->ShopBranchStock->find('stockValue', array(
				'shop_product_id' => $results[$this->alias][$this->primaryKey],
				'variant' => true
			));

			foreach ($results['ShopProductVariant'] as &$variant) {
				$extractTemplate = sprintf('{n}[shop_product_variant_id=%s]', $variant['id']);
				$variant['ShopStockValue'] = current(Hash::extract($variantStockValue, $extractTemplate));
			}
		}

		return $results;
	}

/**
 * Get all the products options
 *
 * @param string $state the state of the find
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findProductOptions($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query[0])) {
				throw new InvalidArgumentException('No product selected for options');
			}

			$query['fields'] = array(
				$this->alias . '.' . $this->primaryKey
			);

			$query['conditions']['or'] = array(
				$this->alias . '.' . $this->primaryKey => $query[0],
				$this->alias . '.slug' => $query[0]
			);

			$query['joins'] = array(

			);

			$query['limit'] = 1;

			return $query;
		}

		if (empty($results[0][$this->alias][$this->primaryKey])) {
			return array();
		}

		$results = current($results);
		unset($results['ActiveCategory']);

		$options = array(
			'shop_product_id' => $results[$this->alias][$this->primaryKey],
			'conditions' => array(
				'ShopOption.id' => 'asd'
			),
			'extract' => true
		);

		$results['ShopOption'] = $this->ShopProductType->ShopProductTypesOption->ShopOption->find('options', $options);

		return $results;
	}

/**
 * setup the basics for the product finds
 *
 * This creates the joins and fields that are used for most finds within the product model.
 *
 * @param string $state
 * @param array $query
 * @param array $results
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findBasics($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query = array_merge(array(
				'override' => true,
				'variants' => true
			), $query);
			$this->virtualFields['total_stock'] = sprintf('SUM(%s.stock)', $this->ShopProductVariant->ShopBranchStock->alias);
			$this->virtualFields['total_variants'] = sprintf('COUNT(%s.id) - 1', $this->ShopProductVariant->alias);

			$fields = array(
				'DISTINCT(ActiveCategory.id)',
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField,
				$this->alias . '.slug',
				$this->alias . '.rating',
				$this->alias . '.rating_count',
				$this->alias . '.views',
				$this->alias . '.sales',
				$this->alias . '.active',
				$this->alias . '.total_stock',
				$this->alias . '.total_variants',

				$this->ShopProductType->alias . '.' . $this->ShopProductType->primaryKey,
				$this->ShopProductType->alias . '.' . $this->ShopProductType->displayField,
				$this->ShopProductType->alias . '.slug',

				$this->ShopBrand->alias . '.' . $this->ShopBrand->primaryKey,
				$this->ShopBrand->alias . '.' . $this->ShopBrand->displayField,
				$this->ShopBrand->alias . '.slug',

				$this->ShopImage->alias . '.' . $this->ShopImage->primaryKey,
				$this->ShopImage->alias . '.image',
			);
			$query['fields'] = array_merge($fields, (array)$query['fields']);

			if (!isset($query['admin']) || $query['admin'] !== true) {
				$this->_activeOnlyConditions($query);
			}

			if (!empty($query['category'])) {
				$query['conditions'] = array_merge((array)$query['conditions'], array(
					'or' => array(
						'ActiveCategory.id' => $query['category'],
						'ActiveCategory.slug' => $query['category']
					)
				));
			}
			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.' . $this->primaryKey . ' IS NOT NULL'
			));

			$query['joins'] = array_filter($query['joins']);

			$query['joins'][] = $this->autoJoinModel($this->ShopProductType);
			$query['joins'][] = $this->autoJoinModel($this->ShopImage);
			$query['joins'][] = $this->autoJoinModel($this->ShopBrand);
			$query['joins'][] = $this->autoJoinModel($this->ShopSupplier);

			$query['joins'][] = $this->autoJoinModel($this->ShopProductVariant);
			$query['joins'][] = $this->ShopProductVariant->autoJoinModel($this->ShopProductVariant->ShopBranchStock);

			$query['joins'][] = $this->autoJoinModel($this->ShopCategoriesProduct);
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopCategoriesProduct,
				'model' => $this->ShopCategoriesProduct->ShopCategory,
				'alias' => 'ActiveCategory'
			));

			return $query;
		}

		if (empty($results)) {
			return array();
		}

		$productIds = Hash::extract($results, sprintf('{n}.%s.%s', $this->alias, $this->primaryKey));
		$masterVariants = $this->ShopProductVariant->find('variants', array(
			'master' => true,
			'override' => $query['override'],
			'shop_product_id' => $productIds
		));

		foreach ($results as $k => &$result) {
			if (empty($result[$this->alias][$this->primaryKey])) {
				unset($results[$k]);
				continue;
			}
			$extractTemplate = sprintf('{n}[shop_product_id=%s]', $result[$this->alias][$this->primaryKey]);
			$result[$this->ShopProductVariant->alias . 'Master'] = current(Hash::extract($masterVariants, $extractTemplate));

			if ($query['variants'] == false) {
				continue;
			}

			$result[$this->ShopProductVariant->alias] = $this->ShopProductVariant->find('variants', array(
				'master' => false,
				'override' => $query['override'],
				'shop_product_id' => $result[$this->alias][$this->primaryKey]
			));

			$productSelling = $result[$this->ShopProductVariant->alias . 'Master']['ShopProductVariantPrice']['selling'];
			foreach ($result[$this->ShopProductVariant->alias] as &$variant) {
				$variant['ShopProductVariantPrice']['difference'] = $variant['ShopProductVariantPrice']['selling'] - $productSelling;
			}
			$this->_productOverride($result);
			foreach ($result['ShopProductVariant'] as & $variant) {
				$variant['ShopOptionVariant'] = Hash::sort($variant['ShopOptionVariant'], '{n}.ShopOption.name', 'asc','string');
			}
			$result['ShopProductVariant'] = Hash::sort($result['ShopProductVariant'], '{n}.product_code', 'asc','string');
		}


		return $results;
	}

/**
 * Override the price and size for product variants
 *
 * Takes the master as the variant if there are none
 *
 * @param array $result a product record (by reference)
 *
 * @return void
 */
	protected function _productOverride(array &$result) {
		if (empty($result[$this->ShopProductVariant->alias])) {
			$result[$this->ShopProductVariant->alias] = array($result[$this->ShopProductVariant->alias . 'Master']);
		}

		$masterPrice = $result[$this->ShopProductVariant->alias . 'Master']['ShopProductVariantPrice'];
		$masterSize = $result[$this->ShopProductVariant->alias . 'Master']['ShopProductVariantSize'];
		unset(
			$masterPrice[$this->ShopProductVariant->ShopProductVariantPrice->primaryKey],
			$masterSize[$this->ShopProductVariant->ShopProductVariantSize->primaryKey]
		);
		$this->_productVariantOverride($masterPrice, $result);

		$prices = Hash::extract($result[$this->ShopProductVariant->alias], '{n}.ShopProductVariantPrice.selling');

		$result[$this->alias]['price_min'] = $result[$this->alias]['price_max'] = 0;
		if ($prices) {
			$result[$this->alias]['price_min'] = min($prices);
			$result[$this->alias]['price_max'] = max($prices);
		}
	}

	protected function _productVariantOverride($masterPrice, &$result) {
		$numeric = Hash::numeric(array_keys($result[$this->ShopProductVariant->alias]));
		if(!$numeric) {
			$result[$this->ShopProductVariant->alias] = array($result[$this->ShopProductVariant->alias]);
		}

		foreach ($result[$this->ShopProductVariant->alias] as $k => $productVariant) {
			if (empty($productVariant['ShopOptionVariant'])) {
				continue;
			}
			$optionPrice = array(
				'cost' => $masterPrice['cost'] + array_sum(Hash::extract($productVariant['ShopOptionVariant'], '{n}.ShopPrice.cost')),
				'selling' => $masterPrice['selling'] + array_sum(Hash::extract($productVariant['ShopOptionVariant'], '{n}.ShopPrice.selling')),
				'retail' => $masterPrice['retail'] + array_sum(Hash::extract($productVariant['ShopOptionVariant'], '{n}.ShopPrice.retail'))
			);

			$result[$this->ShopProductVariant->alias][$k]['ShopProductVariantPrice'] = array_merge(
				array($this->ShopProductVariant->primaryKey => null),
				$masterPrice,
				array_filter($optionPrice),
				array_filter($productVariant['ShopProductVariantPrice'])
			);
		}
		if(!$numeric) {
			$result[$this->ShopProductVariant->alias] = $result[$this->ShopProductVariant->alias][0];
		}
	}


/**
 * Find a list of possible options for a category
 *
 * @param type $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findPossibleOptions($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$this->_activeOnlyConditions($query);
			if (!empty($query['category'])) {
				$query['conditions'][]['or'] = array(
					'ActiveCategory.slug' => $query['category'],
					'ActiveCategory.id' => $query['category']
				);
			}

			$this->virtualFields['product_count'] = sprintf('SUM(%s.%s)',
				$this->alias,
				$this->primaryKey
			);

			$query['fields'] = array(
				$this->ShopProductType->ShopProductTypesOption->ShopOption->alias . '.' . $this->ShopProductType->ShopProductTypesOption->ShopOption->primaryKey,
				'product_count'
			);

			$query['joins'][] = $this->autoJoinModel($this->ShopProductType->fullModelName());
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopProductType->fullModelName(),
				'model' => $this->ShopProductType->ShopProductTypesOption->fullModelName()
			));
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopProductType->ShopProductTypesOption->fullModelName(),
				'model' => $this->ShopProductType->ShopProductTypesOption->ShopOption->fullModelName(),
				'type' => 'right'
			));

			$query['joins'][] = $this->autoJoinModel($this->ShopBrand->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopSupplier->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopCategoriesProduct->fullModelName());
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopCategoriesProduct->fullModelName(),
				'model' => $this->ShopCategoriesProduct->ShopCategory->fullModelName(),
				'alias' => 'ActiveCategory'
			));

			$query['group'] = array(
				$this->ShopProductType->ShopProductTypesOption->ShopOption->alias . '.' . $this->ShopProductType->ShopProductTypesOption->ShopOption->primaryKey
			);

			return $query;
		}

		$options = array(
			'extract' => true,
			'conditions' => array(
				$this->ShopProductType->ShopProductTypesOption->ShopOption->alias . '.' . $this->ShopProductType->ShopProductTypesOption->ShopOption->primaryKey => array_values(Hash::flatten($results))
			)
		);
		$options = $this->ShopProductType->ShopProductTypesOption->ShopOption->find('options', $options);
		$counts = Hash::combine($results, '{n}.ShopOption.id', '{n}.ShopProduct.product_count');
		foreach ($options as &$option) {
			$option['product_count'] = $counts[$option['id']];
		}

		return array(
			'ShopOption' => $options
		);
	}

/**
 * build the conditions to find only active products
 *
 * @param array $query the query being run (passed by reference)
 *
 * @return void
 */
	protected function _activeOnlyConditions(array &$query) {
		$query['conditions'] = array_merge((array)$query['conditions'], array(
			$this->alias . '.active' => 1,
			$this->alias . '.available <=' => date('Y-m-d H:i:00'),
			'ActiveCategory.active' => 1,
			array('or' => array(
				$this->ShopBrand->alias . '.' . $this->ShopBrand->primaryKey => null,
				$this->ShopBrand->alias . '.active' => 1,
			)),
			array('or' => array(
				$this->ShopProductType->alias . '.' . $this->ShopProductType->primaryKey => null,
				$this->ShopProductType->alias . '.active' => 1,
			)),
			array('or' => array(
				$this->ShopSupplier->alias . '.' . $this->ShopSupplier->primaryKey => null,
				$this->ShopSupplier->alias . '.active' => 1,
			))
		));
	}

/**
 * save product details
 *
 * Saves a product and (when required) creates the stock listing.
 *
 * @param array $product the details of the product to be saved
 *
 * @return boolean
 */
	public function saveProduct($product) {
		$this->transaction();
		$create = false;
		if (empty($product[$this->alias][$this->primaryKey])) {
			$create = true;
			$this->create();
		}

		if (!empty($product['ShopCategoriesProduct'])) {
			$shopCategories = $product['ShopCategoriesProduct'];
			unset($product['ShopCategoriesProduct']);
		}

		if (!empty($product['ShopProductImage'])) {
			$shopImages = $product['ShopProductImage'];
			unset($product['ShopProductImage']);
		}

		if (!empty($product['ShopProductVariant'])) {
			$shopProductVariants = $product['ShopProductVariant'];
			unset($product['ShopProductVariant']);
		}

		$saved = (bool)$this->saveAll($product);
		$productId = $this->id;

		if (!empty($shopCategories)) {
			$this->ShopCategoriesProduct->deleteAll(array(
				'shop_product_id' => $productId
			));

			foreach ($shopCategories as $k => $category) {
				$shopCategories[$k] = array(
					'shop_category_id' => $category,
					'shop_product_id' => $productId
				);
			}

			$this->ShopCategoriesProduct->create();
			$saved = $saved && $this->ShopCategoriesProduct->saveAll($shopCategories);
		}

		if (!empty($shopImages)) {
			$this->ShopImagesProduct->deleteAll(array(
				'shop_product_id' => $productId
			));

			foreach ($shopImages as $k => $image) {
				$shopImages[$k] = array(
					'shop_image_id' => $image,
					'shop_product_id' => $productId
				);
			}

			$this->ShopImagesProduct->create();
			$saved = $saved && $this->ShopImagesProduct->saveAll($shopImages);
		}

		if (!empty($shopProductVariants)) {
			foreach ($shopProductVariants as $variant) {
				$variant = array_merge(array(
					'ShopProductVariant' => array(),
					'ShopBranchStock' => array()
				), $variant);
				$variantStock = (array)$variant['ShopBranchStock'];
				unset($variant['ShopBranchStock']);

				$variant['ShopProductVariant']['shop_product_id'] = $productId;
				$this->ShopProductVariant->create();
				if (!$this->ShopProductVariant->saveAssociated($variant, array('deep' => true))) {
					var_dump($this->ShopProductVariant->validationErrors);
					$saved = false;
					break;
				}

				if ($variantStock) {
					foreach ($variantStock as $stock) {
						$stock['shop_product_variant_id'] = $this->ShopProductVariant->id;
						$this->ShopProductVariant->ShopBranchStock->addStock($stock);
					}
				}
			}
		}

		if ($saved) {
			$this->transaction(true);
			return true;
		}

		$this->transaction(false);
		return false;
	}

}
