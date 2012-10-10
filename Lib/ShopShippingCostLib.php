<?php
/**
 * @brief ShopShippingCostLib class
 */
class ShopShippingCostLib {
/**
 * @brief list of size fields
 * @var array
 */
	protected static $_sizeFields = array(
		'width',
		'height',
		'length',
		'weight'
	);

/**
 * @brief get the currently used shipping method
 *
 * @return string
 */
	public function getShipping($method = null) {
		$method = ClassRegistry::init('Shop.ShopShippingMethod')->find('shipping', $method);

		if(empty($method)) {
			throw new CakeException(__d('shop', 'Unable to get the selected shipping method'));
		}

		return $method;
	}

/**
 * @brief calculate the shipping for a single product
 * 
 * @param string|array $product the id of a product or the product details
 * @param mixed $method empty to use the carts current option or pass id for specific type
 *
 * @exception CakeException
 * 
 * @return float
 */
	public static function product($product, $method = null) {
		$method = self::getShipping($method);

		$sizes = ClassRegistry::init('Shop.ShopProduct')->find('productShipping', $product);

		$shipping = self::_calculateShipping($sizes['weight'], $method['ShopShippingMethod']['rates']);
		$insurance = self::_calculateShipping($sizes['cost'], $method['ShopShippingMethod']['rates']);
		return array(
			'total' => round($shipping + $insurance['rate'], 4),
			'shipping' => round($shipping, 4),
			'insurance_rate' => round($insurance['rate'], 4),
			'insurance_cover' => round($insurance['cover'], 4)
		);
	}

/**
 * @brief calculate the shipping cost based on the product weight
 *
 * @param  float $weight the weight of the item being checked
 * @param  array $shipping the shipping prices
 *
 * @throws CakeException when no option is available
 * 
 * @return float
 */
	protected function _calculateShipping($weight, array &$shipping) {
		foreach($shipping as $cost) {
			if($weight < $cost['limit']) {
				return $cost['rate'];
			}
		}

		throw new CakeException(__d('shop', 'Product is to heavy to be shipped by this method'));
	}
/**
 * @brief calculate the insurance provided by selected shipping method
 *
 * This will return the best insurance cover base on the price of the passed
 * in value. If the item is more expensive than the highest available insurance 
 * option the highest option is returned.
 *
 * The rate + limit is returned to be displayed on the front end so users will 
 * see how much cover they have (or if there is short fall)
 * 
 * @param  float $price the cost of goods being insured
 * @param  array $insurance the insurance options
 * 
 * @return array
 */
	protected function _calculateInsurance($price, array &$insurance) {
		foreach($insurance as $cost) {
			if($weight < $cost['limit']) {
				return $cost;
			}
		}

		return $cost;
	}

	public static function cart() {

	}
}