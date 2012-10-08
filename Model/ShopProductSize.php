<?php
/**
 * ShopProductSize Model
 *
 * @property ShopProduct $ShopProduct
 * @property ShopUnit $ShopUnit
 */
class ShopProductSize extends ShopAppModel {
	public $findMethods = array(
		'sizes' => true
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'shop_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopUnit' => array(
			'className' => 'Shop.ShopUnit',
			'foreignKey' => 'shop_unit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * @brief find sizes attached to a product
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findSizes($state, array $query, array $results = array()) {
		if($state == 'before') {
			if(empty($query['shop_product_id'])) {
				throw new InvalidArgumentException('No product selected');
			}

			$this->virtualFields['symbol'] = $this->ShopUnit->ShopUnitType->alias . '.symbol';
			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.value',
					'symbol',
					$this->ShopUnit->alias . '.' .$this->ShopUnit->primaryKey,
					$this->ShopUnit->alias . '.' .$this->ShopUnit->displayField,
					$this->ShopUnit->alias . '.slug',
					$this->ShopUnit->alias . '.shop_unit_type_id'
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.shop_product_id' => $query['shop_product_id'],
					$this->ShopUnit->alias . '.active' => 1
				)
			);

			$query['joins'] = array(
				$this->autoJoinModel($this->ShopUnit->fullModelName()),
				$this->autoJoinModel(array(
					'from' => $this->ShopUnit->fullModelName(),
					'model' => $this->ShopUnit->ShopUnitType->fullModelName()
				)),
			);
			return $query;
		}

		if(empty($results)) {
			return array();
		}

		foreach($results as &$result) {
			$result[$this->alias][$this->ShopUnit->alias] = $result[$this->ShopUnit->alias];
			unset($result[$this->ShopUnit->alias]);
		}

		if(isset($query['extract']) && $query['extract']) {
			return Hash::extract($results, '{n}.' . $this->alias);
		}

		return $results;
	}
}
