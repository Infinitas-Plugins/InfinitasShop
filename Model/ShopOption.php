<?php
/**
 * ShopOption Model
 *
 * @property ShopOptionValue $ShopOptionValue
 * @property ShopProductTypesOption $ShopProductTypesOption
 */
class ShopOption extends ShopAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $findMethods = array(
		'options' => true
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopOptionValue' => array(
			'className' => 'Shop.ShopOptionValue',
			'foreignKey' => 'shop_option_id',
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
		'ShopProductTypesOption' => array(
			'className' => 'Shop.ShopProductTypesOption',
			'foreignKey' => 'shop_option_id',
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
 * find options for a product
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findOptions($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query['shop_product_id']) && empty($query['conditions'])) {
				throw new InvalidArgumentException('No product specified');
			}

			$productIdField = sprintf(
				'%s.%s',
				$this->ShopProductTypesOption->ShopProductType->ShopProduct->alias,
				$this->ShopProductTypesOption->ShopProductType->ShopProduct->primaryKey
			);

			$this->virtualFields['shop_product_id'] = $productIdField;
			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField,
				$this->alias . '.slug',
				$this->alias . '.description',
				$this->alias . '.required',
				'shop_product_id',
			));
			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.' . $this->primaryKey . ' IS NOT NULL'
				)
			);

			if (!empty($query['shop_product_id'])) {
				$query['conditions'][$productIdField] = $query['shop_product_id'];
			}

			$query['joins'][] = $this->autoJoinModel(array(
				'model' => $this->ShopProductTypesOption->fullModelName(),
				'type' => 'right'
			));

			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopProductTypesOption->fullModelName(),
				'model' => $this->ShopProductTypesOption->ShopProductType->fullModelName(),
				'type' => 'right'
			));
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopProductTypesOption->ShopProductType->fullModelName(),
				'model' => $this->ShopProductTypesOption->ShopProductType->ShopProduct->fullModelName(),
				'type' => 'right'
			));

			$query['order'] = array(
				$this->ShopProductTypesOption->alias . '.ordering' => 'asc'
			);

			if (empty($query['shop_product_id'])) {
				$query['group'] = array(
					$this->alias . '.' . $this->primaryKey
				);
			}

			return $query;
		}

		if (empty($results)) {
			return array();
		}

		$this->_linkOptionValues($results, $query);

		if (isset($query['extract']) && $query['extract']) {
			return Hash::extract($results, '{n}.' . $this->alias);
		}

		return $results;
	}

	protected function _linkOptionValues(&$results, $query) {
		$optionIds = Hash::extract($results, '{n}.' . $this->alias . '.' . $this->primaryKey);
		$optionValueConditions = array('shop_option_id' => $optionIds);

		$options = $this->ShopOptionValue->find('values', $optionValueConditions);

		foreach ($results as $k => &$result) {
			$result[$this->alias][$this->ShopOptionValue->alias] = Hash::extract(
				$options,
				sprintf('{n}[shop_option_id=/%s/]', $result[$this->alias][$this->primaryKey])
			);
			$result[$this->alias][$this->ShopOptionValue->alias] = array_values($result[$this->alias][$this->ShopOptionValue->alias]);
		}

		return true;
	}

}
