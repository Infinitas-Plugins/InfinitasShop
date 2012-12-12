<?php
/**
 * ShopOptionValue Model
 *
 * @property ShopOption $ShopOption
 * @property ShopPrice $ShopPrice
 * @property ShopSize $ShopSize
 */

class ShopOptionValue extends ShopAppModel {

/**
 * custom find methods
 *
 * @var array
 */
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
			'order' => '',
			'counterCache' => true
		)
	);

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'ShopPrice' => array(
			'className' => 'Shop.ShopPrice',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopPrice.model' => 'Shop.ShopOptionValue'
			),
			'fields' => '',
			'order' => ''
		),
		'ShopSize' => array(
			'className' => 'Shop.ShopSize',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopSize.model' => 'Shop.ShopOptionValue'
			),
			'fields' => '',
			'order' => ''
		)
	);

/**
 * get option values for multiple options
 *
 * requires shop_option_id passed in
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
		if ($state == 'before') {
			if (empty($query['shop_option_id'])) {
				throw new InvalidArgumentException('No option has been specified');
			}

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.' . $this->displayField,
					$this->alias . '.description',
					$this->alias . '.shop_option_id',
					$this->alias . '.product_code',
					$this->ShopPrice->alias . '.' . $this->ShopPrice->primaryKey,
					$this->ShopPrice->alias . '.selling',
					$this->ShopPrice->alias . '.retail',
					$this->ShopSize->alias . '.*'
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.shop_option_id' => $query['shop_option_id']
				)
			);

			$query['joins'][] = $this->autoJoinModel($this->ShopPrice->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopSize->fullModelName());

			return $query;
		}

		if (empty($results)) {
			return array();
		}

		foreach ($results as &$result) {
			$result[$this->alias][$this->ShopPrice->alias] = $result[$this->ShopPrice->alias];
			$result[$this->alias][$this->ShopSize->alias] = $result[$this->ShopSize->alias];
		}

		return Hash::extract($results, '{n}.' . $this->alias);
	}
}
