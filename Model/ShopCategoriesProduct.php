<?php
/**
 * ShopCategoriesProduct Model
 *
 * @property ShopCategory $ShopCategory
 * @property ShopProduct $ShopProduct
 */
class ShopCategoriesProduct extends ShopAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopCategory' => array(
			'className' => 'Shop.ShopCategory',
			'foreignKey' => 'shop_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'shop_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * @brief overload consturct for translated validation 
 * 
 * @param boolean $id    [description]
 * @param [type]  $table [description]
 * @param [type]  $ds    [description]
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'shop_category_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'The selected category does not exist'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'shop_product_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'The selected product does not exist'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
		);
	}
}
