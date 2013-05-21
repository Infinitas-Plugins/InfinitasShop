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
}