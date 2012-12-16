<?php
/**
 * ShopProductVariant
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/
 * @package Shop.Model
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

/**
 * @package Shop.Model
 *
 * @property ShopProductVariantPrice $ShopProductVariantPrice
 * @property ShopProductVariantSize $ShopProductVariantSize
 * @property ShopProduct $ShopProduct
 * @property ShopListProduct $ShopListProduct
 * @property ShopOptionVariant $ShopOptionVariant
 * @property ShopOrderProduct $ShopOrderProduct
 * @property ShopBranchStock $ShopBranchStock
 */
class ShopProductVariant extends ShopAppModel {

	public $findMethods = array(
		'variants' => true
	);

/**
 * HasOne relations
 *
 * @var array
 */
	public $hasOne = array(
		'ShopProductVariantPrice' => array(
			'className' => 'Shop.ShopPrice',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopProductVariantPrice.model' => 'Shop.ShopProductVariant'
			),
			'fields' => '',
			'order' => ''
		),
		'ShopProductVariantSize' => array(
			'className' => 'Shop.ShopSize',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopProductVariantSize.model' => 'Shop.ShopProductVariant'
			),
			'fields' => '',
			'order' => ''
		)
	);

/**
 * belongsTo relations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'shop_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
			'counterScope' => array(
				'ShopProductVariant.active' => 1
			),
		),
		'ShopImage' => array(
			'className' => 'Shop.ShopImage',
			'foreignKey' => 'shop_image_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		)
	);

/**
 * hasMany relations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopListProduct' => array(
			'className' => 'Shop.ShopListProduct',
			'foreignKey' => 'shop_product_variant_id',
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
		'ShopOptionVariant' => array(
			'className' => 'Shop.ShopOptionVariant',
			'foreignKey' => 'shop_product_variant_id',
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
		'ShopOrderProduct' => array(
			'className' => 'Shop.ShopOrderProduct',
			'foreignKey' => 'shop_product_variant_id',
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
		'ShopBranchStock' => array(
			'className' => 'Shop.ShopBranchStock',
			'foreignKey' => 'shop_product_variant_id',
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
 * Find variants of a product
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findVariants($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query['shop_product_id'])) {
				throw new InvalidArgumentException(__d('shop', 'No product selected'));
			}
			$query = array_merge(array(
				'extract' => true,
				'master' => false,
				'override' => true
			), $query);

			$fields = array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.shop_product_id',
				$this->alias . '.shop_image_id',
				$this->ShopProduct->alias . '.product_code',
				$this->ShopImage->alias . '.' . $this->ShopImage->primaryKey,
				$this->ShopImage->alias . '.image',
			);
			$query['fields'] = array_merge(
				(array)$query['fields'],
				$fields,
				$this->ShopProductVariantPrice->findFields(),
				$this->ShopProductVariantSize->findFields()
			);

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.shop_product_id' => $query['shop_product_id'],
			));

			if($query['master'] !== null) {
				$query['conditions'][$this->alias . '.master'] = (bool)$query['master'];
			}

			$query['joins'][] = $this->autoJoinModel($this->ShopProduct->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopImage->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopProductVariantPrice->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopProductVariantSize->fullModelName());



			return $query;
		}

		if (empty($results)) {
			return array();
		}

		$shopProductVariantIds = Hash::extract($results, sprintf('{n}.%s.%s', $this->alias, $this->primaryKey));
		$shopOptionVariants = $this->ShopOptionVariant->find('variants', array(
			'shop_product_variant_id' => $shopProductVariantIds,
			'override' => $query['override']
		));
		$shopBranchStocks = $this->ShopBranchStock->find('productStock', array(
			'shop_product_variant_id' => $shopProductVariantIds,
			'extract' => true
		));

		foreach ($results as &$result) {
			$result[$this->alias]['product_code'] = $result[$this->ShopProduct->alias]['product_code'];
			$tmp = $result[$this->alias];
			unset($result[$this->alias], $result[$this->ShopProduct->alias]);
			$result = array_merge($tmp, $result);

			$extractTemplate = sprintf('{n}[shop_product_variant_id=/%s/]', $result[$this->primaryKey]);
			$result[$this->ShopOptionVariant->alias] = Hash::extract($shopOptionVariants, $extractTemplate);
			$result[$this->ShopBranchStock->alias] = Hash::extract($shopBranchStocks, $extractTemplate);

			$result['product_code'] = $this->_productCode($result);
		}

		return $results;
	}

/**
 * Generate the product code based on the options in the variant
 *
 * @param array $result the variant record with options
 *
 * @return string
 */
	protected function _productCode(array &$result) {
		$options = Hash::extract($result, 'ShopOptionVariant.{n}.ShopOption.slug');
		$codes = Hash::extract($result, 'ShopOptionVariant.{n}.ShopOptionValue.product_code');

		$allOptions = array();
		if (!empty($options) && !empty($codes)) {
			$allOptions = array_combine($options, $codes);
		}

		if (empty($result['product_code'])) {
			if (array_filter($allOptions)) {
				return implode('', $allOptions);
			}
			return null;
		}

		if (strstr($result['product_code'], ':') !== false) {
			return String::insert($result['product_code'], $allOptions);
		}

		return $result['product_code'] . '-' . implode('', $allOptions);
	}
}