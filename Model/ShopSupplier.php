<?php
/**
 * ShopSupplier Model
 *
 * @property ContactAddress $ContactAddress
 * @property ShopBranchStockLog $ShopBranchStockLog
 * @property ShopProduct $ShopProduct
 */
class ShopSupplier extends ShopAppModel {
/**
 * @brief Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * @brief behaviors that are attached
 * 
 * @var array
 */
	public $actsAs = array(
		'Filemanager.Upload' => array(
			'logo' => array(
				'thumbnailSizes' => array(
					'large' => '1000l',
					'medium' => '600l',
					'small' => '300l',
					'thumb' => '75l'
				)
			)
		)
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ContactAddress' => array(
			'className' => 'Contact.ContactAddress',
			'foreignKey' => 'contact_address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopBranchStockLog' => array(
			'className' => 'Shop.ShopBranchStockLog',
			'foreignKey' => 'shop_supplier_id',
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
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'shop_supplier_id',
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

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'name' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('shop', 'Please enter a name for the supplier'),
					'allowEmpty' => false
				),
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => __d('shop', 'A supplier with that name already exists')
				)
			),
			'contact_address_id' => array(
				'validateRecordExists' => array(
					'rule' => array('validateRecordExists'),
					'message' => __d('shop', 'The selected address does not exist'),
					'allowEmpty' => true,
					'required' => false
				),
			),
			'email' => array(
				'email' => array(
					'rule' => array('email'),
					'message' => __d('shop', 'Please enter a valid email address'),
					'allowEmpty' => true,
					'required' => false
				)
			),
			'active' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('shop', 'The value for active is not valid'),
				),
			),
		);
	}

}
