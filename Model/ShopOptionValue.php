<?php
/**
 * ShopOptionValue Model
 *
 * @property ShopOption $ShopOption
 * @property ShopPrice $ShopPrice
 */
class ShopOptionValue extends ShopAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $findMethods = array(
		'values' => true
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopOption' => array(
			'className' => 'Shop.ShopOption',
			'foreignKey' => 'shop_option_id',
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
				'ShopPrice.model = "Shop.ShopOptionValue"'
			),
			'fields' => '',
			'order' => ''
		)
	);

/**
 * @brief get option values for multiple options
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findValues($state, array $query, array $results = array()) {
		if($state == 'before') {
			if(empty($query['shop_option_id'])) {
				throw new InvalidArgumentException('No option has been specified');
			}

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.' . $this->displayField,
					$this->alias . '.shop_option_id'
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.shop_option_id' => $query['shop_option_id']
				)
			);

			$query['joins'][] = $this->autoJoinModel($this->ShopPrice->fullModelName());

			return $query;
		}

		return Hash::extract($results, '{n}.' . $this->alias);
	}
}
