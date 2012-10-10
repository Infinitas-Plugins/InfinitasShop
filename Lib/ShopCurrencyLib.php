<?php
/**
 * @brief libs for currency handeling
 *
 * Class for handeling currency conversions thoughout the shop plugin
 */
App::uses('CakeSession', 'Model/Datasource');

class ShopCurrencyLib {
/**
 * @brief session key used for storing the path to the current currency
 * 
 * @param array
 */
	protected static $_sessionKey = 'Shop.currency';

/**
 * @brief get the currently used session
 *
 * @return string
 */
	public function getCurrency() {
		return self::_getSession();
	}

/**
 * @brief configure the currency being used
 *
 * @param type $currency
 *
 * @return type
 */
	public static function setCurrency($currency = null) {
		if(!$currency) {
			$currency = self::_getSession();
		}
		$currency = ClassRegistry::init('Shop.ShopCurrency')->find('currency', array(
			'currency' => $currency
		));
		$currency = current($currency);
		$changeFields = array(
			'whole_symbol',
			'whole_position',
			'fraction_symbol',
			'fraction_position'
		);
		array_walk($changeFields, function($field) use(&$currency) {
			$currency[Inflector::variable($field)] = $currency[$field];
			unset($currency['field']);
		});

		self::_setSession($currency['code']);

		return CakeNumber::addFormat($currency['code'], $currency);
	}

/**
 * @brief convert from one currency to another
 *
 * The shop default is always used as the base currency
 *
 * @param float $amount the amount being converted
 * @param string $to the currency code being converted to
 *
 * @return float
 */
	public static function convert($amount, $to = null) {
		if(!$to) {
			$to = self::_getSession();
		}
		$factors = ClassRegistry::init('Shop.ShopCurrency')->find('conversions');

		if($factors[$to] == 1) {
			return $amount;
		}

		return round($amount * $factors[$to], 4);
	}

/**
 * @brief get the currently used currency code
 *
 * @return CakeSession::read()
 */
	protected function _getSession() {
		$value = CakeSession::read(self::$_sessionKey);
		if(!$value) {
			return strtolower(Configure::read('Shop.currency'));
		}
		return $value;
	}

/**
 * @brief set the currently used session code
 *
 * @param string $code the code to be used
 *
 * @return CakeSession::write()
 */
	protected function _setSession($code) {
		return CakeSession::write(self::$_sessionKey, strtolower($code));
	}
}
