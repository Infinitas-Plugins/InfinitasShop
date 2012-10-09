<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopListProduct Model
 *
 * @property ShopList $ShopList
 * @property ShopProduct $ShopProduct
 */
class ShopListProduct extends ShopAppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	public $findMethods = array(
		'products' => true
	);

/**
 * belongsTo associations
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
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'shop_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * @brief overload construct for translated validation messages
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'shop_product_id' => array(
				'uuid' => array(
					'rule' => array('uuid'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
	}

/**
 * @brief get the list of products attached to a cart
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findProducts($state, array $query, array $results = array()) {
		if($state == 'before') {
			if(empty($query['shop_list_id'])) {
				throw new InvalidArgumentException('No list selected');
			}
			if(!isset($query['extract'])) {
				$query['extract'] = true;
			}

			$this->virtualFields['base_price'] = sprintf('%s.selling', $this->ShopProduct->ShopPrice->alias);

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.*',
					'base_price',

					$this->ShopProduct->alias . '.' . $this->ShopProduct->primaryKey,
					$this->ShopProduct->alias . '.' . $this->ShopProduct->displayField,
					$this->ShopProduct->alias . '.slug',

					$this->ShopProduct->ShopProductType->alias . '.' . $this->ShopProduct->ShopProductType->primaryKey,
					$this->ShopProduct->ShopProductType->alias . '.' . $this->ShopProduct->ShopProductType->displayField,

					$this->ShopProduct->ShopImage->alias . '.' . $this->ShopProduct->ShopImage->primaryKey,
					$this->ShopProduct->ShopImage->alias . '.image'
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.shop_list_id' => $query['shop_list_id']
				)
			);

			$query['joins'][] = $this->autoJoinModel($this->ShopProduct->fullModelName());
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopProduct->fullModelName(),
				'model' => $this->ShopProduct->ShopProductType->fullModelName()
			));
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopProduct->fullModelName(),
				'model' => $this->ShopProduct->ShopImage->fullModelName()
			));
			$query['joins'][] = $this->autoJoinModel(array(
				'from' => $this->ShopProduct->fullModelName(),
				'model' => $this->ShopProduct->ShopPrice->fullModelName()
			));

			return $query;
		}

		if(empty($results)) {
			return array();
		}

		foreach($results as &$result) {
			$result[$this->alias][$this->ShopProduct->alias] = array_merge(
				$result[$this->ShopProduct->alias],
				array($this->ShopProduct->ShopProductType->alias => $result[$this->ShopProduct->ShopProductType->alias]),
				array($this->ShopProduct->ShopImage->alias => $result[$this->ShopProduct->ShopImage->alias])
			);
		}

		if($query['extract']) {
			return Hash::extract($results, '{n}.' . $this->alias);
		}

		return $results;
	}
}
