<?php
/**
 * ShopAttribute
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/Shop
 * @package	Shop.Model
 * @license	http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 */

class ShopAttribute extends ShopAppModel {

	public $findMethods = array(
		'connected' => true,
		'productAttributes' => true
	);

/**
 * Additional behaviours that are attached to this model
 *
 * @var array
 */
	public $actsAs = array(
		'Filemanager.Upload' => array(
			'image' => array(
				'thumbnailSizes' => array(
					'large' => '750l',
					'medium' => '250l',
					'small' => '100l',
					'thumb' => '50l'
				)
			)
		),
		'Libs.Sequence' => array(
			'groupFields' => array(
				'shop_attribute_group_id'
			)
		)
	);

/**
 * belongsTo relations for this model
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopAttributeGroup' => array(
			'className' => 'Shop.ShopAttributeGroup',
			'foreignKey' => 'shop_attribute_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
		)
	);

/**
 * hasMany relations for this model
 *
 * @var array
 */
	public $hasMany = array(
		'ShopProductAttribute' => array(
			'className' => 'Shop.ShopProductAttribute',
			'foreignKey' => 'shop_attribute_id',
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
 * Constructor
 *
 * @param string|integer $id string uuid or id
 * @param string $table the table that the model is for
 * @param string $ds the datasource being used
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->order = array(
			$this->alias . '.ordering' => 'asc'
		);

		$this->validate = array(
		);
	}

	protected function _findProductAttributes($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query[0])) {
				throw new InvalidArgumentException(__d('shop', 'No product specified'));
			}
			$this->virtualFields['group_name'] = 'ShopAttributeGroup.name';
			$this->virtualFields['group_slug'] = 'ShopAttributeGroup.slug';
			$query['fields'] = array_merge((array)$query['fields'], array(
				'ShopAttribute.id',
				'ShopAttribute.name',
				'ShopAttribute.slug',
				'ShopAttribute.image_small',
				'ShopAttribute.image_large',
				'ShopAttribute.group_name',
				'ShopAttribute.group_slug'
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.' . $this->primaryKey . ' !=' => null
			));

			$query['joins'] = (array)$query['joins'];
			$query['joins'][] = $this->autoJoinModel($this->ShopAttributeGroup);

			$join = $this->autoJoinModel(array(
				'model' => $this->ShopProductAttribute,
				'type' => 'right',
			));
			$join['conditions'][] = sprintf('ShopProductAttribute.shop_product_id = "%s"', $query[0]);
			$query['joins'][] = $join;

			$query['order'] = array_merge((array)$query['order'], array(
				'ShopAttributeGroup.name',
				'ShopAttribute.name'
			));

			$query['group'] = array(
				$this->alias . '.' . $this->primaryKey
			);
			return $query;
		}

		return (array)Hash::extract($results, '{n}.' . $this->alias);
	}

	protected function _findConnected($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query = array_merge(array(
				'category' => null,
				'product' => null
			), $query);

			$query['joins'] = (array)$query['joins'];
			$query['joins'][] = $this->autoJoinModel(array(
				'model' => $this->ShopProductAttribute,
				'type' => 'right'
			));
			$productJoin = $this->ShopProductAttribute->autoJoinModel(array(
				'model' => $this->ShopProductAttribute->ShopProduct
			));
			if (!empty($query['product'])) {
				$productJoin['conditions']['or'] = array(
					$this->ShopProductAttribute->ShopProduct->alias . '.' . $this->ShopProductAttribute->ShopProduct->primaryKey => $query['product'],
					$this->ShopProductAttribute->ShopProduct->alias . '.slug' => $query['product'],
				);
			}
			$query['joins'][] = $productJoin;

			if (!empty($query['category'])) {
				$query['joins'][] = $this->ShopProductAttribute->ShopProduct->autoJoinModel(array(
					'model' => $this->ShopProductAttribute->ShopProduct->ShopCategoriesProduct,
					'type' => 'right',
				));
				$categoryJoin = $this->ShopProductAttribute->ShopProduct->ShopCategoriesProduct->autoJoinModel(array(
					'model' => $this->ShopProductAttribute->ShopProduct->ShopCategoriesProduct->ShopCategory,
					'conditions' => array(
						'ShopCategoriesProduct.shop_category_id = ShopCategory.id',
						'ShopCategory.active = 1'
					)
				));

				$query['joins'][] = $categoryJoin;
				$query['joins'][] = $this->autoJoinModel($this->ShopAttributeGroup);
			}

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				//'ShopCategory.slug' => $query['category']
			));

			$query['group'] = array(
				$this->alias . '.' . $this->primaryKey
			);
			return $query;
		}

		if (empty($results)) {
			return array();
		}

		$results = Hash::extract($results, '{n}.' . $this->alias);
		$attributeGroups = $this->ShopAttributeGroup->find('all', array(
			'conditions' => array(
				$this->ShopAttributeGroup->alias . '.' . $this->ShopAttributeGroup->primaryKey => Hash::extract($results, '{n}.shop_attribute_group_id')
			)
		));

		foreach ($attributeGroups as &$group) {
			$extractTemplate = sprintf('{n}[shop_attribute_group_id=%s]', $group[$this->ShopAttributeGroup->alias][$this->ShopAttributeGroup->primaryKey]);
			$group[$this->alias] = Hash::extract($results, $extractTemplate);
		}
		$colourAttributes = array(
			'ShopAttributeGroup' => array(
				'name' => __d('shop', 'Product Colour'),
				'slug' => 'product-colour',
				'_generated' => true
			),
		);

		$ShopImage = ClassRegistry::init('Shop.ShopImage');
		$ShopImage->virtualFields['name'] = 'ShopOptionValue.name';
		$ShopImage->virtualFields['id'] = 'ShopImage.colour_1';
		$ShopImage->virtualFields['slug'] = 'ShopImage.colour_1';
		$ShopImage->virtualFields['shop_product_attribute_count'] = 'SUM(ShopImage.id)';
		$colourAttributes['ShopAttribute'] = $ShopImage->find('all', array(
			'fields' => array(
				'ShopImage.id',
				'ShopImage.name',
				'ShopImage.slug',
				'ShopImage.shop_product_attribute_count'
			),
			'conditions' => array(
				'ShopImage.colour_1 !=' => null
			),
			'joins' => array(
				array(
					'alias' => 'ShopOptionValue',
					'table' => 'shop_option_values',
					'type' => 'right',
					'conditions' => array(
						'ShopOptionValue.colour = ShopImage.colour_1'
					)
				)
			),
			'group' => array(
				'ShopOptionValue.colour'
			),
			'order' => array(
				'ShopImage.colour_1'
			),
			'limit' => 20
		));
		$colourAttributes['ShopAttribute'] = Hash::extract($colourAttributes['ShopAttribute'], '{n}.ShopImage');
		$attributeGroups[] = $colourAttributes;
		return $attributeGroups;
	}
}