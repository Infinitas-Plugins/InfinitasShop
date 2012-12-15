<?php
/**
 * ShopOptionVariant
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/Shop
 * @package Shop.Model
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

/**
 * ShopOptionVariant
 * 
 * @package Shop.Model
 *
 * @property ShopPrice $ShopPrice
 * @property ShopSize $ShopSize
 * @property ShopProductVariant $ShopProductVariant
 * @property ShopOptionValue $ShopOptionValue
 */
class ShopOptionVariant extends ShopAppModel {

	public $findMethods = array(
		'variants' => true
	);

/**
 * HasOne relations
 *
 * @var array
 */
	public $hasOne = array(
		'ShopPrice' => array(
			'className' => 'Shop.ShopPrice',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopPrice.model' => 'Shop.ShopOptionVariant'
			),
			'fields' => '',
			'order' => ''
		),
		'ShopSize' => array(
			'className' => 'Shop.ShopSize',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopSize.model' => 'Shop.ShopOptionVariant'
			),
			'fields' => '',
			'order' => ''
		),
	);

/**
 * belongsTo relations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopProductVariant' => array(
			'className' => 'Shop.ShopProductVariant',
			'foreignKey' => 'shop_product_variant_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
		'ShopOptionValue' => array(
			'className' => 'Shop.ShopOptionValue',
			'foreignKey' => 'shop_option_value_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		)
	);

/**
 * Constructor
 *
 * @param mixed $id string uuid or id
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

/**
 * Find option variants for product variants
 *
 * Default will overload the values with what has been set in the option values.
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findVariants($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query = array_merge(array(
				'shop_product_variant_id' => null,
				'override' => true
			), $query);

			$fields = array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.shop_product_variant_id',

				$this->ShopOptionValue->ShopOption->alias . '.' . $this->ShopOptionValue->ShopOption->primaryKey,
				$this->ShopOptionValue->ShopOption->alias . '.' . $this->ShopOptionValue->ShopOption->displayField,
				$this->ShopOptionValue->ShopOption->alias . '.slug',
				$this->ShopOptionValue->ShopOption->alias . '.description',
				$this->ShopOptionValue->ShopOption->alias . '.required',

				$this->ShopOptionValue->alias . '.' . $this->ShopOptionValue->primaryKey,
				$this->ShopOptionValue->alias . '.' . $this->ShopOptionValue->displayField,
				$this->ShopOptionValue->alias . '.description',
				$this->ShopOptionValue->alias . '.product_code',
			);
			$query['fields'] = array_merge(
				(array)$query['fields'],
				$fields,
				$this->ShopPrice->findFields(),
				$this->ShopSize->findFields(),
				$this->ShopPrice->findFields('ShopOptionPrice'),
				$this->ShopSize->findFields('ShopOptionSize')
			);

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.shop_product_variant_id' => $query['shop_product_variant_id']
			));

			$query['joins'][] = $this->autoJoinModel($this->ShopPrice->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopSize->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopOptionValue->fullModelName());
			$query['joins'][] = $this->ShopOptionValue->autoJoinModel($this->ShopOptionValue->ShopOption->fullModelName());
			$query['joins'][] = $this->ShopOptionValue->autoJoinModel(array(
				'model' => $this->ShopOptionValue->ShopPrice->fullModelName(),
				'alias' => 'ShopOptionPrice'
			));
			$query['joins'][] = $this->ShopOptionValue->autoJoinModel(array(
				'model' => $this->ShopOptionValue->ShopSize->fullModelName(),
				'alias' => 'ShopOptionSize'
			));
			return $query;
		}

		if (empty($results)) {
			return array();
		}

		foreach ($results as &$result) {
			$tmp = $result[$this->alias];
			unset($result[$this->alias]);
			$result = array_merge($tmp, $result);

			$result[$this->ShopOptionValue->alias][$this->ShopPrice->alias] = $result['ShopOptionPrice'];
			$result[$this->ShopOptionValue->alias][$this->ShopSize->alias] = $result['ShopOptionSize'];

			if ($query['override']) {
				$this->_override($result);
			}

			unset($tmp, $result['ShopOptionPrice'], $result['ShopOptionSize']);
		}

		return $results;
	}

/**
 * Override the price and sizes for the variant based using the option value as a base
 *
 * @param array $result the variant data (by reference)
 *
 * @return void
 */
	protected function _override(array &$result) {
		unset($result['ShopOptionSize']['id'], $result['ShopOptionPrice']['id']);
		$result[$this->ShopSize->alias] = array_merge($result['ShopOptionSize'], array_filter($result[$this->ShopSize->alias]));
		$result[$this->ShopPrice->alias] = array_merge($result['ShopOptionPrice'], array_filter($result[$this->ShopPrice->alias]));

		$result[$this->ShopSize->alias] = array_merge(array($this->ShopSize->primaryKey => null), $result[$this->ShopSize->alias]);
		$result[$this->ShopPrice->alias] = array_merge(array($this->ShopPrice->primaryKey => null), $result[$this->ShopPrice->alias]);
	}
}
