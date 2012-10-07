<?php
/**
 * ShopOption Model
 *
 * @property ShopOptionValue $ShopOptionValue
 * @property ShopProductsOptionIgnore $ShopProductsOptionIgnore
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
		'ShopProductsOptionIgnore' => array(
			'className' => 'Shop.ShopProductsOptionIgnore',
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
		),
	);

/**
 * @brief find options for a product
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
		if($state == 'before') {
			if(empty($query['shop_product_id'])) {
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
				'shop_product_id',
				'ProductOptionIgnore.*'
			));
			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.' . $this->primaryKey . ' IS NOT NULL',
					$productIdField => $query['shop_product_id'],
				)
			);

			$query['joins'] = array_merge(
				(array)$query['joins'],
				array(
					$this->autoJoinModel(array(
						'model' => $this->ShopProductTypesOption->fullModelName(),
						'type' => 'right'
					)),
					$this->autoJoinModel(array(
						'from' => $this->ShopProductTypesOption->fullModelName(),
						'model' => $this->ShopProductTypesOption->ShopProductType->fullModelName(),
						'type' => 'right'
					)),
					$this->autoJoinModel(array(
						'from' => $this->ShopProductTypesOption->ShopProductType->fullModelName(),
						'model' => $this->ShopProductTypesOption->ShopProductType->ShopProduct->fullModelName(),
						'type' => 'right'
					)),
					$this->autoJoinModel(array(
						'model' => $this->ShopProductsOptionIgnore->fullModelName(),
						'alias' => 'ProductOptionIgnore',
						'conditions' => array(
							'ProductOptionIgnore.shop_option_id = ' . $this->alias . '.' . $this->primaryKey,
							'ProductOptionIgnore.model' => 'Shop.ShopProduct',
							'ProductOptionIgnore.foreign_key = ShopProduct.id',
						)
					)),
				)
			);

			$query['order'] = array(
				$this->ShopProductTypesOption->alias . '.ordering' => 'asc'
			);

			return $query;
		}

		if(empty($results)) {
			return array();
		}

		$this->_linkOptionValues($results);

		if(isset($query['extract']) && $query['extract']) {
			return Hash::extract($results, '{n}.' . $this->alias);
		}

		return $results;
	}

	protected function _linkOptionValues(&$results) {
		$optionIds = Hash::extract($results, '{n}.' . $this->alias . '.' . $this->primaryKey);
		$options = $this->ShopOptionValue->find('values', array('shop_option_id' => $optionIds));

		foreach($results as $k => &$result) {
			if($result[$this->alias]['shop_product_id'] == $result['ProductOptionIgnore']['foreign_key']) {
				unset($results[$k]);
				continue;
			}
			unset($result['ProductOptionIgnore']);

			$result[$this->alias][$this->ShopOptionValue->alias] = Hash::extract(
				$options,
				sprintf('{n}[id=/%s/]', $result[$this->alias][$this->primaryKey])
			);
			foreach($result[$this->alias][$this->ShopOptionValue->alias] as $k => &$optionValue) {
				foreach($optionValue['ProductOptionValueIgnore'] as $kk => $ignore) {
					if($ignore['foreign_key'] == $result[$this->alias]['shop_product_id']) {
						unset($result[$this->alias][$this->ShopOptionValue->alias][$k]);
						break;
					}
				}
				unset($optionValue['ProductOptionValueIgnore']);
			}
			$result[$this->alias][$this->ShopOptionValue->alias] = array_values($result[$this->alias][$this->ShopOptionValue->alias]);

		}

		return true;
	}

}
