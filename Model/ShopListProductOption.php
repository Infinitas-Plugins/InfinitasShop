<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopListProductOption Model
 *
 * @property ShopListProduct $ShopListProduct
 * @property ShopOption $ShopOption
 * @property ShopOptionValue $ShopOptionValue
 */
class ShopListProductOption extends ShopAppModel {

/**
 * custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'options' => true
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopListProduct' => array(
			'className' => 'Shop.ShopListProduct',
			'foreignKey' => 'shop_list_product_id',
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
 * overload construct for translated validation
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'shop_list_product_id' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'No product specified'),
					'required' => true
				),
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'Invalid product')
				),
				'validateProductRequiredOptions' => array(
					'rule' => 'validateProductRequiredOptions',
					'message' => __d('shop', 'Product has required options')
				),
				'validateUniqueproduct' => array(
					'rule' => 'validateUniqueproduct',
					'message' => __d('shop', 'Product already added')
				),
			),
			'shop_option_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'Invalid option'),
					'allowEmpty' => true
				)
			),
			'shop_option_value_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'Invalid option value'),
					'allowEmpty' => true
				)
			)
		);
	}

/**
 * Validate that products with required options have the options set
 *
 * @param array $field the field being validated
 *
 * @return boolean
 */
	public function validateProductRequiredOptions($field) {
		if (empty($this->data[$this->alias]['shop_product_id'])) {
			return true;
		}

		$productOptions = $this->ShopProduct->find('productOptions', array(
			'shop_product_id' => $this->data[$this->alias]['shop_product_id']
		));
		return false;
	}

/**
 * Validate the product being added is not already in the cart
 *
 * @param array $field the field being validated
 *
 * @return boolean
 */
	public function validateUniqueproduct($field) {
		if (empty($this->data[$this->alias]['shop_list_product_id'])) {
			return false;
		}

		$product = $this->ShopListProduct->find('first', array(
			'fields' => array(
				$this->ShopListProduct->alias . '.id',
				$this->ShopListProduct->ShopListProductOption->alias . '.shop_option_id',
				$this->ShopListProduct->ShopListProductOption->alias . '.shop_option_value_id',
			),
			'conditions' => array(
				$this->ShopListProduct->alias . '.' . $this->ShopListProduct->primaryKey => $this->data[$this->alias]['shop_list_product_id']
			),
			'joins' => array(
				$this->ShopListProduct->autoJoinModel(array(
					'model' => $this->ShopListProduct->ShopListProductOption->fullModelName(),
					'type' => 'right'
				))
			)
		));
		if (empty($product)) {
			return true;
		}

		$diff = array_diff(
			array_values(Hash::flatten($product)),
			array_values($this->data[$this->alias])
		);
		return !empty($diff);
	}

/**
 * Get the options attached to list products
 *
 * These are the options that a user selected before adding a product to their list.
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
			if (empty($query['shop_list_product_id'])) {
				throw new InvalidArgumentException(__d('shop', 'No products given'));
			}

			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.shop_list_product_id',

				$this->ShopOption->alias . '.' . $this->ShopOption->primaryKey,
				$this->ShopOption->alias . '.' . $this->ShopOption->displayField,
				$this->ShopOption->alias . '.description',

				$this->ShopOptionValue->alias . '.' . $this->ShopOptionValue->primaryKey,
				$this->ShopOptionValue->alias . '.' . $this->ShopOptionValue->displayField,
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.shop_list_product_id' => $query['shop_list_product_id']
			));

			$query['joins'][] = $this->autoJoinModel($this->ShopOption->fullModelName());
			$query['joins'][] = $this->autoJoinModel($this->ShopOptionValue->fullModelName());
			return $query;
		}

		if (empty($results)) {
			return array();
		}

		foreach ($results as &$result) {
			$result = array(
				'shop_list_product_id' => $result[$this->alias]['shop_list_product_id'],
				$this->ShopOption->alias => $result[$this->ShopOption->alias],
				$this->ShopOptionValue->alias => $result[$this->ShopOptionValue->alias]
			);
		}

		return $results;
	}

/**
 * Save a list of product options
 *
 * @param string $listProductId the list product id being saved
 * @param array $options
 *
 * @return array
 */
	public function saveProductOptions($listProductId, array $options) {
		foreach ($options as $optionId => &$option) {
			$option = array(
				'shop_list_product_id' => $listProductId,
				'shop_option_id' => $optionId,
				'shop_option_value_id' => $option
			);
		}

		return (bool)$this->saveAll(array_values($options));
	}
}
