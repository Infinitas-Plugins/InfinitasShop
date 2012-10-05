<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopCategory Model
 *
 * @property ShopImage $ShopImage
 * @property ShopCategory $ParentShopCategory
 * @property ShopCategory $ChildShopCategory
 * @property ShopCategoriesProduct $ShopCategoriesProduct
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

	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
		'ShopCategoriesProduct' => array(
			'className' => 'Shop.ShopCategoriesProduct',
			'foreignKey' => 'shop_category_id',
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
			'lft' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'rght' => array(
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

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.' . $this->displayField,
					$this->alias . '.slug'
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
