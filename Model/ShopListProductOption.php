<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopListProductOption Model
 *
 * @property ShopList $ShopList
 * @property ShopOption $ShopOption
 * @property ShopOptionValue $ShopOptionValue
 */
class ShopListProductOption extends ShopAppModel {
/**
 * @brief validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * @brief custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'options' => true
	);

/**
 * @brief belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopList' => array(
			'className' => 'Shop.ShopList',
			'foreignKey' => 'shop_list_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopOption' => array(
			'className' => 'Shop.ShopOption',
			'foreignKey' => 'shop_option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopOptionValue' => array(
			'className' => 'Shop.ShopOptionValue',
			'foreignKey' => 'shop_option_value_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * @brief overload construct for translated validation
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(

		);
	}

/**
 * @brief find options related to a product in a cart list
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
			if(empty($query['shop_list_product_id'])) {
				throw new InvalidArgumentException('No product selected');
			}

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.shop_list_product_id',
					$this->alias . '.shop_option_id',
					$this->alias . '.shop_option_value_id',

					$this->ShopOption->alias . '.' . $this->ShopOption->primaryKey,
					$this->ShopOption->alias . '.' . $this->ShopOption->displayField,
					$this->ShopOption->alias . '.slug',
					$this->ShopOption->alias . '.required',

					$this->ShopOptionValue->alias . '.' . $this->ShopOptionValue->primaryKey,
					$this->ShopOptionValue->alias . '.' . $this->ShopOptionValue->displayField,
					$this->ShopOptionValue->alias . '.product_code',

					'ShopOverridePrice.selling',
					'ShopOverridePrice.retail',

					$this->ShopOptionValue->ShopPrice->alias . '.selling',
					$this->ShopOptionValue->ShopPrice->alias . '.retail'
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.shop_list_product_id' => $query['shop_list_product_id']
				)
			);

			$query['joins'][] = $this->autoJoinModel($this->ShopOption->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopOptionValue->fullModelName());
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopOptionValue->fullModelName(),
				'model' => $this->ShopOptionValue->ShopProductsOptionValueOverride->fullModelName()
			));
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopOptionValue->fullModelName(),
				'model' => $this->ShopOptionValue->ShopPrice->fullModelName()
			));

			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopOptionValue->ShopProductsOptionValueOverride->fullModelName(),
				'model' => $this->ShopOptionValue->ShopProductsOptionValueOverride->ShopPrice->fullModelName(),
				'alias' => 'ShopOverridePrice'
			));

			return $query;
		}

		if(empty($results)) {
			return array();
		}

		foreach($results as &$result) {
			$result[$this->alias][$this->ShopOption->alias] = $result[$this->ShopOption->alias];
			$result[$this->alias][$this->ShopOptionValue->alias] = $result[$this->ShopOptionValue->alias];
			$result[$this->alias][$this->ShopOptionValue->alias]['ShopOverridePrice'] = $result['ShopOverridePrice'];
			$result[$this->alias][$this->ShopOptionValue->alias][$this->ShopOptionValue->ShopPrice->alias] = $result[$this->ShopOptionValue->ShopPrice->alias];
		}

		return Hash::extract($results, '{n}.' . $this->alias);
	}
}
