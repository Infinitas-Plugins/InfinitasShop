<?php
/**
 * ShopImagesProduct Model
 *
 * @property ShopImage $ShopImage
 * @property ShopProduct $ShopProduct
 */
class ShopImagesProduct extends ShopAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopImage' => array(
			'className' => 'ShopImage',
			'foreignKey' => 'shop_image_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopProduct' => array(
			'className' => 'ShopProduct',
			'foreignKey' => 'shop_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * @brief overload the constructor to provide translated validation
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'shop_image_id' => array(
				'validateRecordExists' => array(
					'rule' => array('validateRecordExists'),
					'mesage' => __d('shop', 'The selected image does not exist')
				),
			),
			'shop_product_id' => array(
				'validateRecordExists' => array(
					'rule' => array('validateRecordExists'),
					'message' => __d('shop', 'The selected product does not exist')
				),
			),
		);
	}
}
