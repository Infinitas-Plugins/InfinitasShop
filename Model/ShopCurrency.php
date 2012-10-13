<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopCurrency Model
 *
 * @property ShopPaymentMethodApi $ShopPaymentMethodApi
 */
class ShopCurrency extends ShopAppModel {
	public $findMethods = array(
		'currency' => true,
		'conversions' => true
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopPaymentMethodApi' => array(
			'className' => 'ShopPaymentMethodApi',
			'foreignKey' => 'shop_currency_id',
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
 * @brief get a currency
 *
 * @code
 *	// Pass currency for specific currency, else default is used.
 *	$this->ShopCurrency->find('currency', array('currency' => 'usd'));
 *  return array(
 *		... // usd currency
 *  );
 *
 *	// get the stores default (the one with a factor of 1
 *	// If two currencies are the same, non defaults should be set to .99999 or 1.00001
 *	$this->ShopCurrency->find('currency');
 *  return array(
 *		... // default currency
 *  );
 * @endcode
 *
 * @param string $state
 * @param array $query
 * @param array $results
 */
	public function _findCurrency($state, array $query, array $results = array()) {
		exit;
		if($state == 'before') {
			if(!empty($query['currency'])) {
				$query['conditions'] = array(
					$this->alias . '.code' => $query['currency']
				);
			} else {
				$query['conditions'] = array(
					$this->alias . '.factor' => 1,
				);
			}

			$fields = $this->schema();
			unset($fields[$this->primaryKey], $fields['created'], $fields['modified']);
			$query['fields'] = array_keys($fields);

			$query['limit'] = 1;

			return $query;
		}

		if(empty($results)) {
			throw new CakeException(__d('shop', 'Selected currency was not found'));
		}

		return current($results);
	}

/**
 * @brief get a list of the factors for conversions
 *
 * return a key value array of currency code - factor.
 *
 * @param array $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	public function _findConversions($state, array $query, array $results = array()) {
		if($state == 'before') {
			if(empty($query['fields'])) {
				$query['fields'] = array(
					$this->alias . '.code',
					$this->alias . '.factor'
				);
			}

			return $query;
		}

		return Hash::combine($results,
			sprintf('{n}.%s.code', $this->alias),
			sprintf('{n}.%s.factor', $this->alias)
		);
	}

}
