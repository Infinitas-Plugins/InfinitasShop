<?php
/**
 * ShopOption Model
 *
 * @property ShopOptionValue $ShopOptionValue
 * @property ShopProductsOption $ShopProductsOption
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
			'foreignKey' => 'shop_option_id',
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
			if(empty($query[0])) {
				throw new InvalidArgumentException('No product specified');
			}

			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField
			));

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->ShopProductsOption->alias . '.shop_product_id' => $query[0]
				)
			);

			$query['joins'][] = $this->autoJoinModel($this->ShopProductsOption->fullModelName());

			$query['order'] = array(
				$this->alias . '.ordering' => 'asc'
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
		$options = $this->ShopOptionValue->find('values', $optionIds);

		foreach($results as &$result) {
			$result[$this->alias][$this->ShopOptionValue->alias] = Hash::extract($options, sprintf('{n}[id=/%s/]', $result[$this->alias][$this->primaryKey]));
		}

		return true;
	}

}
