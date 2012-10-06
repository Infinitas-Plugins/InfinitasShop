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

	public $findMethods = array(
		'images' => true
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopImage' => array(
			'className' => 'Shop.ShopImage',
			'foreignKey' => 'shop_image_id',
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

/**
 * @brief find related images
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findImages($state, array $query, array $results = array()) {
		if($state == 'before') {
			if(empty($query['shop_product_id'])) {
				throw new InvalidArgumentException('No product selected');
			}

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.shop_product_id',
					$this->ShopImage->alias . '.' . $this->ShopImage->primaryKey,
					$this->ShopImage->alias . '.image'
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.shop_product_id' => $query['shop_product_id'],
				)
			);

			$query['joins'] = array_merge(
				(array)$query['joins'],
				array(
					$this->autoJoinModel($this->ShopImage->fullModelName())
				)
			);
			return $query;
		}

		if(empty($results)) {
			return array();
		}

		foreach($results as &$result) {
			$result[$this->ShopImage->alias]['shop_product_id'] = $result[$this->alias]['shop_product_id'];
			$result = array(
				$this->ShopImage->alias => $result[$this->ShopImage->alias]
			);
		}

		if(isset($query['extract']) && $query['extract']) {
			return Hash::extract($results, '{n}.' . $this->ShopImage->alias);
		}

		return $results;
	}
}
