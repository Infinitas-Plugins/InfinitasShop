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
 * @brief overload construct for translated validation
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

	public function validateProductRequiredOptions($field) {
		if(empty($this->data[$this->alias]['shop_product_id'])) {
			return true;
		}

		$productOptions = $this->ShopProduct->find('productOptions', array(
			'shop_product_id' => $this->data[$this->alias]['shop_product_id']
		));
		return false;
	}

	public function validateUniqueproduct($field) {
		if(empty($this->data[$this->alias]['shop_list_product_id'])) {
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
		if(empty($product)) {
			return true;
		}

		$diff = array_diff(
			array_values(Hash::flatten($product)),
			array_values($this->data[$this->alias])
		);
		return !empty($diff);
	}

	public function saveProductOptions($listProductId, array $options) {
		foreach ($options as $optionId => &$option) {
			$option = array(
				'shop_list_product_id' => $listProductId,
				'shop_option_id' => $optionId,
				'shop_option_value_id' => $option
			);
		}

		return (bool)$this->saveAll($options);
	}
}
