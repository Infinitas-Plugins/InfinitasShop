<?php
/**
 * ShopSpecial Model
 *
 * @property ShopProductsSpecial $ShopProductsSpecial
 */
class ShopSpecial extends ShopAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	public $findMethods = array(
		'specials' => true
	);

	public $hasMany = array(
		'ShopProductsSpecial' => array(
			'className' => 'Shop.ShopProductsSpecial',
			'foreignKey' => 'shop_special_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

/**
 * @brief overload construct for translated validation errors
 * 
 * @param boolean $id    [description]
 * @param [type]  $table [description]
 * @param [type]  $ds    [description]
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'start_date' => array(
				'date' => array(
					'rule' => 'date',
					'message' => __d('shop', 'Start date is not valid')
				),
			),
			'end_date' => array(
				'date' => array(
					'rule' => 'date',
					'message' => __d('shop', 'End date is not valid')
				),
			),
			'active' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('shop', 'Active should be boolean')
				),
			),
		);
	}

/**
 * @brief find a list of specials
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findSpecials($state, array $query, array $results = array()) {
		if($state == 'before') {
			if(empty($query['shop_product_id'])) {
				throw new InvalidArgumentException('No product selected');
			}

			$this->virtualFields['shop_product_id'] = $this->ShopProductsSpecial->fullFieldName('shop_product_id');

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.discount',
					$this->alias . '.amount',
					$this->alias . '.free_shipping',
					$this->alias . '.start_date',
					$this->alias . '.end_date',
					'shop_product_id'
				)
			);

			$query['conditions'] = array_merge((array)$query['conditions'], $this->conditions());

			$query['joins'] = array_merge(
				(array)$query['joins'],
				array(
					$this->autoJoinModel(array(
						'model' => $this->ShopProductsSpecial->fullModelName(),
						'type' => 'right',
						'conditions' => array(
							$this->ShopProductsSpecial->alias . '.shop_special_id = ShopSpecial.id',
							$this->ShopProductsSpecial->alias . '.shop_product_id = ' . sprintf('"%s"', $query['shop_product_id'])
						)
					))
				)
			);

			return $query;
		}

		if(empty($results)) {
			return array();
		}

		if(!empty($query['extract']) && $query['extract']) {
			return Hash::extract($results, '{n}.' . $this->alias);
		}

		return $results;
	}

/**
 * @brief reusable conditions for finding specials that are current and usable to shoppers
 *
 * @return array
 */
	public function conditions() {
		return array(
			'and' => array(
				$this->alias . '.active' => 1,
				$this->alias . '.start_date <= ' => date('Y-m-d H:i:s'),
				$this->alias . '.end_date >= ' => date('Y-m-d H:i:s')
			)
		);
	}
}
