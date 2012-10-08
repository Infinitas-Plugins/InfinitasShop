<?php
/**
 * ShopBranch Model
 *
 * @property ContactBranch $ContactBranch
 * @property Manager $Manager
 * @property ShopBranchStock $ShopBranchStock
 */
class ShopBranch extends ShopAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * @brief custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'defaultBranchId' => true
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ContactBranch' => array(
			'className' => 'Contact.Branch',
			'foreignKey' => 'contact_branch_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Manager' => array(
			'className' => 'Users.User',
			'foreignKey' => 'manager_id',
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
		'ShopBranchStock' => array(
			'className' => 'Shop.ShopBranchStock',
			'foreignKey' => 'shop_branch_id',
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
			'contact_branch_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'manager_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'ordering' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'active' => array(
				'boolean' => array(
					'rule' => array('boolean'),
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
 * @brief get the default branch in use
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return string
 *
 * @throws ShopBranchNotConfiguredException
 * @throws ShopBranchMultipleConfiguredException
 */
	protected function _findDefaultBranchId($state, array $query, array $results = array()) {
		if($state == 'before') {
			$query['fields'] = array(
				$this->alias . '.' . $this->primaryKey
			);

			return $query;
		}

		if(count($results) === 1) {
			return $results[0][$this->alias][$this->primaryKey];
		}

		if(count($results) === 0) {
			throw new ShopBranchNotConfiguredException();
		}

		throw new ShopBranchMultipleConfiguredException();
	}

}
