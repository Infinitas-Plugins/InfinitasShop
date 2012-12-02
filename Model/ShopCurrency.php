<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopCurrency Model
 *
 * @property ShopPaymentMethodApi $ShopPaymentMethodApi
 */

class ShopCurrency extends ShopAppModel {

/**
 * Custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'currency' => true,
		'conversions' => true,
		'switch' => true
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
 * get a currency
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
 *
 * @throws CakeException
 */
	protected function _findCurrency($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (!empty($query['currency'])) {
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
		$results = current($results);

		if (empty($results)) {
			throw new CakeException(__d('shop', 'Selected currency was not found'));
		}

		$results[$this->alias]['code'] = strtoupper($results[$this->alias]['code']);

		return $results;
	}

/**
 * get a list of the factors for conversions
 *
 * return a key value array of currency code - factor.
 *
 * @param array $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findConversions($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query['fields'])) {
				$query['fields'] = array(
					$this->alias . '.code',
					$this->alias . '.factor'
				);
			}

			return $query;
		}

		$return = array();
		foreach ($results as $result) {
			$return[strtoupper($result[$this->alias]['code'])] = $result[$this->alias]['factor'];
		}
		return $return;
	}

	protected function _findSwitch($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->fullFieldName($this->primaryKey),
				$this->fullFieldName($this->displayField),
				$this->fullFieldName('code'),
				$this->fullFieldName('whole_symbol'),
			));
			return $query;
		}

		return $results;
	}

/**
 * update the currecy conversion factors
 *
 * @return boolean
 */
	public function updateCurrencies($force = false) {
		App::uses('ShopCurrencyLib', 'Shop.Lib');
		$conditions = array();
		if (!$force) {
			$conditions = array(
				'conditions' => array(
					$this->alias . '.modified < ' => date('Y-m-d H:i:s', (time() - (6 * 60 * 60)))
				)
			);
		}
		$currencies = $this->find('conversions', $conditions);
		$saved = true;
		$defaultCurrency = ShopCurrencyLib::defaultCurrency();
		foreach ($currencies as $currency => $factor) {
			if (!$saved) {
				break;
			}

			if ((float)$factor == 1.0) {
				continue;
			}

			$newFactor = ShopCurrencyLib::fetchUpdate($defaultCurrency, $currency);
			if ($newFactor && $factor == $newFactor) {
				continue;
			}

			$saved = $this->updateAll(
				array($this->alias . '.factor' => $newFactor, $this->alias . '.modified' => sprintf('"%s"', date('Y-m-d H:i:s'))),
				array($this->alias . '.code' => $currency)
			);
		}
		return $saved;
	}
}