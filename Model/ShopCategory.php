<?php
/**
 * ShopCategory Model
 *
 * @property ShopImage $ShopImage
 * @property ShopCategory $ParentShopCategory
 * @property ShopCategory $ChildShopCategory
 * @property ShopCategoriesProduct $ShopCategoriesProduct
 * @property ShopProductType $ShopProductType
 */
class ShopCategory extends ShopAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $findMethods = array(
		'related' => true
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * @brief model default ordering
 */
	public $order = array();

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
		'ParentShopCategory' => array(
			'className' => 'Shop.ShopCategory',
			'foreignKey' => 'parent_id',
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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildShopCategory' => array(
			'className' => 'Shop.ShopCategory',
			'foreignKey' => 'parent_id',
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
			'foreignKey' => 'shop_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * @brief overload construct for translated validation messages
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
					'rule' => array('notEmpty'),
					'message' => __d('shop', 'Please enter a name for this category'),
				),
			),
			'active' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('shop', 'The value for active is not valid'),
				),
			),
		);

		$this->order = array(
			$this->alias . '.lft'
		);
	}

/**
 * @brief after saving figure out the path depth
 * 
 * @param  boolean $created was the record created (true) or modified (false)
 * 
 * @return ShopAppModel::afterSave()
 */
	public function afterSave($created) {
		$this->saveField(
			'path_depth', 
			count($this->getPath($this->id)) - 1,
			array(
				'callbacks' => false
			)
		);
		
		return parent::afterSave($created);
	}

/**
 * @brief find related categories
 *
 *  - shop_product_id: The product id to find related categories for
 *  - extract: will return without the alias like related finds in CakePHP
 *
 * If active is not set it will be set to true so only active categories are returned
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findRelated($state, array $query, array $results = array()) {
		if($state == 'before') {
			if(!empty($query['shop_product_id'])) {
				$query['conditions'][$this->ShopCategoriesProduct->alias . '.shop_product_id'] = $query['shop_product_id'];
			}

			if(empty($query['conditions'])) {
				throw new InvalidArgumentException('No conditions specified for related categories');
			}

			if(!isset($query['conditions'][$this->alias . '.active'])) {
				$query['conditions'][$this->alias . '.active'] = 1;
			}

			$this->virtualFields['shop_product_id'] = $this->ShopCategoriesProduct->alias . '.shop_product_id';
			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.' . $this->displayField,
					$this->alias . '.slug',
					'shop_product_id'
				)
			);

			$query['joins'][] = array(
				'table' => 'shop_categories_products',
				'alias' => 'ShopCategoriesProduct',
				'type' => 'left',
				'conditions' => array(
					'ShopCategoriesProduct.shop_category_id = ShopCategory.id'
				)
			);

			return $query;
		}

		if(isset($query['extract']) && $query['extract'] === true) {
			return Hash::extract($results, '{n}.' . $this->alias);
		}

		return $results;
	}

}
