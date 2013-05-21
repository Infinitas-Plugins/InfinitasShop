<?php
/**
 * ShopAttributeGroup
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

/**
 * ShopAttributeGroup
 * 
 * @package	Shop.Model
 *
 * @property ShopAttribute $ShopAttribute
 */

class ShopAttributeGroup extends ShopAppModel {

	public $findMethods = array(
		'forManage' => true
	);

/**
 * hasMany relations for this model
 *
 * @var array
 */
	public $hasMany = array(
		'ShopAttribute' => array(
			'className' => 'Shop.ShopAttribute',
			'foreignKey' => 'shop_attribute_group_id',
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

		$this->validate = array(
		);
	}

	protected function _findForManage($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query['shop_product_id'])) {
				throw new InvalidArgumentException(__d('shop', 'No product specified'));
			}

			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.*',
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
			));

			$query['joins'] = (array)$query['joins'];
			$query['joins'][] = $this->autoJoinModel($this->ShopAttribute);

			$query['group'] = array(
				$this->alias . '.' . $this->primaryKey
			);
			return $query;
		}

		if (empty($results)) {
			return array();
		}

		$join = $this->ShopAttribute->autoJoinModel($this->ShopAttribute->ShopProductAttribute);
		$join['conditions'] = array_merge($join['conditions'], array(
			$this->ShopAttribute->ShopProductAttribute->alias . '.shop_product_id' => $query['shop_product_id']
		));
		$shopAttributes = $this->ShopAttribute->find('all', array(
			'fields' => array(
				$this->ShopAttribute->alias . '.*',
				$this->ShopAttribute->ShopProductAttribute->alias . '.*'
			),
			'joins' => array(
				$join
			)
		));

		foreach ($shopAttributes as &$attribute) {
			$attribute['ShopAttribute']['ShopProductAttribute'] = $attribute['ShopProductAttribute'];
			$attribute = $attribute['ShopAttribute'];
		}

		foreach ($results as &$result) {
			$extractTemplate = sprintf('{n}[shop_attribute_group_id=%s]', $result[$this->alias][$this->primaryKey]);
			$result['ShopAttribute'] = Hash::extract($shopAttributes, $extractTemplate);
		}

		return $results;
	}

	public function saveAttributes($attributes) {
		$attributes = Hash::extract($attributes['ShopAttribute'], '{n}[selected=1]');
		$this->transaction();
		$deleted = $this->ShopAttribute->ShopProductAttribute->deleteAll(array(
			'ShopProductAttribute.shop_product_id' => current(Hash::extract($attributes, '{n}.shop_product_id'))
		));

		if ($deleted) {
			$saved = $this->ShopAttribute->ShopProductAttribute->saveAll($attributes);
			if ($saved) {
				$this->transaction(true);
				return true;
			}
		}

		$this->transaction(false);
		return false;
	}
}