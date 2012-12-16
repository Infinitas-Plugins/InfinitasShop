<?php
/**
 * ShopHelper
 *
 * @package Shop.Helper
 */

/**
 * ShopHelper
 *
 * @package Shop.Helper
 */

class ShopHelper extends AppHelper {

/**
 * Helpers to load
 *
 * @var array
 */
	public $helpers = array(
		'Text',
		'Html',
		'Form',
		'Libs.Infinitas',
		'Libs.Design'
	);

/**
 * link email addresses with optional icon
 *
 * Can link as plain text or as an icon
 *
 * @code
 * 	// using an icon
 * 	$this->Shop->emailLink('foo@bar.com'); // <a ...><img ... /></a>
 *
 * 	// using text
 * 	$this->Shop->emailLink('foo@bar.com', false); // <a ...>foo@bar.com</a>
 * @endcode
 *
 * @param string $email the email address being linked
 * @param boolean $icon use an icon or not
 * @param array $options options for the icon link
 *
 * @return sting
 */
	public function emailLink($email, $icon = true, $options = array()) {
		$options = array_merge(array(
			'escape' => false,
			'title' => $email,
			'target' => '_blank',
			'class' => 'icon'
		), $options);

		if (!$icon) {
			return $this->Text->autoLinkEmails($email, $options);
		}

		return $this->Html->link(
			$this->Design->icon('envelope'),
			'mailto:' . $email,
			$options
		);
	}

/**
 * convert hours to meaningful time
 *
 * @code
 * 	$this->Shop->timeEstimate(12); // 12 hours
 * 	$this->Shop->timeEstimate(25); // 1 day
 * 	$this->Shop->timeEstimate(360); // 2 weeks
 * @endcode
 *
 * @param integer $hours the number of hours being converted
 *
 * @return string
 */
	public function timeEstimate($hours) {
		$hours = round($hours);
		if ($hours <= 24) {
			return __dn('shop', '%d hour', '%d hours', $hours, $hours);
		}

		$days = round($hours / 24);
		if ($days <= 7) {
			return __dn('shop', '%d day', '%d days', $days, $days);
		}

		$weeks = round($days / 7);
		if ($weeks <= 6) {
			return __dn('shop', '%d week', '%d weeks', $weeks, $weeks);
		}

		$months = round($weeks / 4.2);
		return __dn('shop', '%d month', '%d months', $months, $months);
	}

/**
 * convert an amount to currency
 *
 * @param float $amount the amount to show
 *
 * @return string
 */
	public function adminCurrency($amount) {
		return self::_currencyDisplay($amount, 'GBP');
	}

/**
 * get the value in the selected currency
 *
 * Will use the currency from the session or store default.
 *
 * @see ShopCurrencyLib::convert()
 *
 * @param float $amount the amount being converted
 * @param string $to the currency being displayed in
 *
 * @return string
 */
	public function currency($amount, $to = null) {
		App::uses('ShopCurrencyLib', 'Shop.Lib');
		$to = ShopCurrencyLib::addFormat($to);
		return self::_currencyDisplay(ShopCurrencyLib::convert($amount, $to), $to);
	}

	protected function _currencyDisplay($amount, $currency) {
		return CakeNumber::currency($amount, $currency);
	}

/**
 * display the stock quantity / value
 *
 * returns html markup for swtiching between stock count and value
 *
 * @param array $variants the product variants
 *
 * @return string
 */
	public function stockValue(array $variants) {
		$stock = $value = 0;
		foreach ($variants as $variant) {
			$stock += $count = array_sum(Hash::extract($variant['ShopBranchStock'], '{n}.stock'));
			$value += ($variant['ShopProductVariantPrice']['selling'] * $count);
		}
		return $this->Html->tag('div',
			implode('', array(
				$this->Html->tag('span', $stock, array('class' => 'quantity')),
				$this->Html->tag('span', self::adminCurrency($value), array('class' => 'value'))
			)),
			array('class' => 'stock-value')
		);
	}

/**
 * show the status of a product
 *
 * products are only available to the customers when specific criteria is met, brand,
 * category, product type etc should all be acitve before the product is available.
 *
 * This method helps display any reason why the product is not displaying on the
 * front end.
 *
 * If any of the fields required for figuring out the status are not available 'disabled'
 * symbol is returned with details of the missing data
 *
 * @param  array $product the product from a find, must include all details to determin the status
 *
 * @return string
 */
	public function adminStatus(array &$product) {
		$problem = $this->Infinitas->status(0, array('title_no' => __d('shop', 'Missing data :: Unable to determin the status of the product (Missing %s)')));
		if (!array_key_exists('active', $product['ShopProduct'])) {
			return sprintf($problem, __d('shop', 'product status'));
		}
		if (!array_key_exists('available', $product['ShopProduct'])) {
			return sprintf($problem, __d('shop', 'product available date'));
		}
		if (!array_key_exists('active', $product['ShopBrand'])) {
			return sprintf($problem, __d('shop', 'brand'));
		}
		if (!array_key_exists('active', $product['ShopProductType'])) {
			return sprintf($problem, __d('shop', 'product type'));
		}
		if (!array_key_exists('active', $product['ShopSupplier'])) {
			return sprintf($problem, __d('shop', 'supplier'));
		}
		if (!array_key_exists('category_active', $product['ShopProduct'])) {
			return sprintf($problem, __d('shop', 'cateogry status'));
		}

		$statuses = array(
			'product' => array(
				'status' => $product['ShopProduct']['active'],
				0 => __d('shop', 'Product is disabled')
			),
			'available' => array(
				'status' => $product['ShopProduct']['available'] <= date('Y-m-d H:i:s'),
				0 => __d('shop', 'Product will be available after %s', CakeTime::niceShort($product['ShopProduct']['available']))
			),
			'brand' => array(
				'status' => $product['ShopBrand']['active'],
				0 => __d('shop', 'Brand has been disabled')
			),
			'type' => array(
				'status' => $product['ShopProductType']['active'],
				0 => __d('shop', 'Product type has been disabled')
			),
			'supplier' => array(
				'status' => $product['ShopSupplier']['active'],
				0 => __d('shop', 'Supplier has been disabled')
			),
			'category' => array(
				'status' => $product['ShopProduct']['category_active'],
				0 => __d('shop', 'Category has been disabled')
			)
		);

		if (empty($product['ShopCategory'])) {
			$statuses['category'] = array(
				'status' => false,
				0 => __d('shop', 'Not linked to any categories')
			);
		}

		$overallStatus = true;
		$out = array();
		foreach ($statuses as $status) {
			if ($status['status'] === true) {
				continue;
			}
			$overallStatus = $overallStatus && $status['status'];
			$out[] = $status[(int)$status['status']];
		}
		if ($overallStatus) {
			return;
		}

		return $this->Infinitas->status($overallStatus, array(
			'title_no' => __d('shop', 'Disabled :: This product will not be available to customers.<br/>%s', $this->Design->arrayToList($out))
		));
	}

/**
 * display the cost details for a price
 *
 * @param array $shopPrice the price details
 *
 * @return string
 */
	public function adminPrice(array &$shopPrice) {
		$options = array(
			__d('shop', 'Cost: %s', self::adminCurrency($shopPrice['cost'])),
			__d('shop', 'Selling: %s', self::adminCurrency($shopPrice['selling'])),
			__d('shop', 'Markup: %s (%s)', self::_markup($shopPrice), self::_markup($shopPrice, true)),
			__d('shop', 'Retail: %s', self::adminCurrency($shopPrice['retail']))
		);

		return $this->Html->tag('div', implode('', array(
			$this->Html->tag('span', self::adminCurrency($shopPrice['cost']), array(
				'class' => 'cost',
				'title' => __d('shop', 'Price :: %s', $this->Design->arrayToList($options))
			)),
			$this->Html->tag('span', self::adminCurrency($shopPrice['selling']), array('class' => 'selling')),
		)), array('class' => 'price'));
	}

/**
 * build markup info switch html
 *
 * @param  array $shopPrice the pricing information
 *
 * @return string
 */
	public function adminMarkup(array &$shopPrice) {
		return $this->Html->tag('div', implode('', array(
			$this->Html->tag('span', self::adminCurrency(self::_markup($shopPrice)), array('class' => 'amount')),
			$this->Html->tag('span', CakeNumber::toPercentage(self::_markup($shopPrice, true)), array('class' => 'percentage')),
		)), array('class' => 'markup'));
	}

/**
 * calculate the markup of a price
 *
 * @param  array $shopPrice the pricing information
 * @param  boolean $percent calculate as a percentacge or value
 *
 * @return string
 */
	protected function _markup(array $shopPrice, $percent = false) {
		$markup = $shopPrice['selling'] - $shopPrice['cost'];
		if (!$percent) {
			return $markup;
		}
		if ($shopPrice['cost'] == 0) {
			$shopPrice['cost'] = .01;
		}

		return ($markup / $shopPrice['cost']) * 100;
	}

/**
 * build a nested category nav
 *
 * Generally should not pass a third param as that is used internally to set the
 * correct classes on child elements.
 *
 * @code
 *	$this->Shop->categoryList($categories, array('class' => 'foobar'));
 * @endcode
 *
 * @param array $shopCategories nested list of categories
 * @param array $options options for the ul
 * @param boolean $isChild this is for internal use
 *
 * @return string
 */
	public function categoryList($shopCategories, array $options = array(), $isChild = false) {
		foreach ($shopCategories as &$category) {
			$name = $category['ShopCategory']['name'];
			if (Configure::read('Shop.display_category_count') && array_key_exists('shop_product_count', $category['ShopCategory'])) {
				$name = sprintf('%s (%d)', $category['ShopCategory']['name'], $category['ShopCategory']['shop_product_count']);
			}

			$children = null;
			$liOptions = array();
			$linkOptions = array('escape' => false);
			if (!empty($category['children'])) {
				$thisCategory = array('ShopCategory' => $category['ShopCategory'], 'children' => array());
				$thisCategory['ShopCategory']['name'] = __d('shop', 'View All');
				unset($thisCategory['ShopCategory']['shop_product_count']);
				array_unshift($category['children'], $thisCategory);

				$children = self::categoryList($category['children'], array('class' => 'dropdown-menu'), true);
				$liOptions['class'] = 'dropdown';
				$linkOptions = array_merge($linkOptions, array(
					'class' => 'dropdown-toggle',
					'data-toggle' => 'dropdown'
				));
				if (!$isChild) {
					$name = sprintf('%s%s', $name, $this->Html->tag('b', '', array('class' => 'caret')));
				} else if ($isChild) {
					$liOptions['class'] = 'dropdown-submenu';
				}
			}
			$item = $this->Html->link($name, array(
				'plugin' => 'shop',
				'controller' => 'shop_products',
				'action' => 'index',
				'category' => $category['ShopCategory']['slug']
			), $linkOptions);

			$category = $this->Html->tag('li', $item . $children, $liOptions);
		}

		return $this->Html->tag('ul', implode('', $shopCategories), $options);
	}

/**
 * generate information links
 *
 * @param string $title the heading of the box being generated
 * @param array $links key value array of title => url
 *
 * @return type
 */
	public function infoLinks($title, array $links) {
		foreach ($links as $title => &$link) {
			$link = $this->Html->link($title, $link);
		}

		return $this->Html->tag('div', implode('', array(
			$this->Html->tag('h4', $title),
			$this->Design->arrayToList($links, array('ul' => 'unstyled'))
		)), array('class' => 'span3'));
	}

/**
 * generate the breadcrumbs for the category path
 *
 * @code
 *	$this->Shop->categoryBreadcrumbs($categories);
 *	// [cat 1 / cat 2 / cat 3]
 *
 *	$this->Shop->categoryBreadcrumbs($categories, $prodcut);
 *	// [cat 1 / cat 2 / cat 3 / $product]
 * @endcode
 *
 * @param array $categories list of categories
 * @param string $product optional name of the product being viewd
 *
 * @return string
 */
	public function categoryBreadcrumbs(array $categories, $product = null) {
		if (empty($categories)) {
			return;
		}

		$divider = $this->Html->tag('span', '/', array('class' => 'divider'));

		$count = count($categories);
		if (!empty($product)) {
			$count++;
		}

		foreach ($categories as $k => &$category) {
			if ($k + 1 == $count) {
				$category = $category['ShopCategory']['name'];
				continue;
			}

			$url = array(
				'plugin' => 'shop',
				'controller' => 'shop_products',
				'action' => 'index',
				'category' => $category['ShopCategory']['slug']
			);
			$options = array('escape' => false);
			$category = $this->Html->link($category['ShopCategory']['name'], $url, $options) . $divider;
		}

		array_unshift($categories, $this->Html->link(__d('shop', 'Home'), '/') . $divider);

		if (!empty($product)) {
			$categories[] = $product;
		}

		return $this->Design->arrayToList($categories, array('ul' => 'breadcrumb'));
	}

	public function addToCart(array $product, array $options = array()) {
		$variantCount = count($product['ShopProductVariant']);
		if ($this->request->params['action'] != 'view' && $variantCount > 1) {
			return $this->Html->link(__d('shop', '%d variants', $variantCount), array(
				'plugin' => 'shop',
				'controller' => 'shop_products',
				'action' => 'view',
				'category' => $product['ShopCategory'][0]['slug'],
				'slug' => $product['ShopProduct']['slug']
			), array('class' => array(
				'btn',
				'btn-small',
				'btn-warning',
				'pull-right'
			)));
		}

		return implode('', array(
			$this->Form->create('ShopList', array('url' => array(
				'plugin' => 'shop',
				'controller' => 'shop_list_products',
				'action' => 'add'
			))),
				$this->Form->hidden('ShopList.product_id', array(
					'value' => $product['ShopProduct']['id']
				)),
				$this->Form->submit(__d('shop', 'Add to Cart'), $options),
			$this->Form->end()
		));
	}

/**
 * generate the pricing information
 *
 * @param array $price the price information
 *
 * @return string
 */
	public function price(array $price, $span = true) {
		if (empty($price['selling'])) {
			return __d('shop', 'Call for price');
		}

		if (!$span) {
			return $this->currency($price['selling']);
		}

		return $this->Html->tag('span', $this->currency($price['selling']), array(
			'class' => 'price price-now'
		));
	}

	public function subtotalPrice(array $product, $span = false) {
		$product['ShopPrice']['selling'] *= $product['ShopListProduct']['quantity'];

		return self::price($product, $span);
	}

	public function cartPrice(array $products, array $shipping = array(), $span = false) {
		foreach ($products as &$product) {
			$product['ShopPrice']['selling'] *= $product['ShopListProduct']['quantity'];
		}

		$products = array_sum(Hash::extract($products, '{n}.ShopPrice.selling'));
		if (empty($shipping['total'])) {
			$shipping['total'] = 0;
		}

		return self::currency($products + $shipping['total'], $span);
	}

	public function optionPrice($optionPrice) {
		if (!$optionPrice) {
			return $this->Html->tag('span', '-', array(
				'title' => __d('shop', 'No change')
			));
		}

		return $this->currency($optionPrice);
	}

	public function calculatedSize($productSize, $optionSize, $shipping = false) {
		$optionSize = array_filter($optionSize);
		if (empty($optionSize)) {
			return $this->Html->tag('span', '-', array(
				'title' => __d('shop', 'No change')
			));
		}

		foreach ($optionSize as $k => $v) {
			if ($shipping && strstr($k, 'shipping') === false) {
				continue;
			}

			if (!$shipping && strstr($k, 'product') === false) {
				continue;
			}

			$productSize[$k] += $v;
		}

		return sprintf('%s (% g)', $this->size($productSize, $shipping), round($info[$prefix . '_weight'], 2));
	}

	public function size($info, $shipping = false) {
		$prefix = 'product';
		if ($shipping) {
			$prefix = 'shipping';
		}
		return sprintf($this->_sizeTemplate(),
			round($info[$prefix . '_length'], 2),
			round($info[$prefix . '_width'], 2),
			round($info[$prefix . '_height'], 2)
		);
	}

	public function sizeLabel() {
		return sprintf($this->_sizeTemplate(),
			__d('shop', 'l'),
			__d('shop', 'w'),
			__d('shop', 'h')
		);
	}

	protected function _sizeTemplate() {
		$x = $this->Html->tag('strong', 'x');
		return sprintf('%%s %s %%s %s %%s', $x, $x);
	}

	public function sizeTable(array $product) {
		foreach ($product['ShopSize'] as $key => &$size) {
			$skip = strstr($key, 'shipping') === false && strstr($key, 'product') === false;
			if ($skip) {
				continue;
			}

			if (strstr($key, 'weight')) {
				$size = __d('shop', '%s g', round($size, 2));
				continue;
			}
			$size = __d('shop', '%s mm', round($size, 2));
		}

		return $this->Html->tag('table', implode('', array(
			$this->Html->tag('caption', __d('shop', '%s size information', $product['ShopProduct']['name'])),
			$this->Html->tag('thead', implode('', array(
				$this->Html->tag('tr', implode('', array(
					$this->Html->tag('th', ''),
					$this->Html->tag('th', __d('shop', 'Product'), array(
						'width' => '150px',
						'class' => 'size'
					)),
					$this->Html->tag('th', __d('shop', 'Shipping'), array(
						'width' => '150px',
						'class' => 'size'
					)),
				)))
			))),
			$this->Html->tag('tbody', implode('', array(
				$this->Html->tag('tr', implode('', array(
					$this->Html->tag('th', __d('shop', 'Width')),
					$this->Html->tag('td', $product['ShopSize']['product_width']),
					$this->Html->tag('td', $product['ShopSize']['shipping_width']),
				))),
				$this->Html->tag('tr', implode('', array(
					$this->Html->tag('th', __d('shop', 'Length')),
					$this->Html->tag('td', $product['ShopSize']['product_length']),
					$this->Html->tag('td', $product['ShopSize']['shipping_length']),
				))),
				$this->Html->tag('tr', implode('', array(
					$this->Html->tag('th', __d('shop', 'Height')),
					$this->Html->tag('td', $product['ShopSize']['product_height']),
					$this->Html->tag('td', $product['ShopSize']['shipping_height']),
				))),
				$this->Html->tag('tr', implode('', array(
					$this->Html->tag('th', __d('shop', 'Weight')),
					$this->Html->tag('td', $product['ShopSize']['product_weight']),
					$this->Html->tag('td', $product['ShopSize']['shipping_weight']),
				)))
			)))
		)), array('class' => 'table table-striped table-hover table-condensed sizes'));
	}

/**
 * Generate a shipping selection button or if only one is available and selected show that
 *
 * @param array $shippingMethod The currently selected shipping method
 * @param array $shopShippingMethods the available shipping methods
 *
 * @return string
 */
	public function shippingSelect(array $shippingMethod, array $shopShippingMethods) {
		if (count($shopShippingMethods) == 1 && !empty($shippingMethod['name'])) {
			return $this->Html->link($shippingMethod['name'], $this->here . '#', array(
				'class' => 'btn active'
			));
		}

		foreach ($shopShippingMethods as $k => &$shopShippingMethod) {
			$shopShippingMethod = $this->Html->link($shopShippingMethod, array(
				'plugin' => 'shop',
				'controller' => 'shop_lists',
				'action' => 'set_shipping_method',
				$k
			));
		}

		$shippingButton = __d('shop', 'Shipping method');
		if (!empty($shopShippingMethods[$shippingMethod['name']])) {
			$shippingButton = $shippingMethod['name'];
		}

		return implode('', array(
			$this->Html->link($shippingButton . $this->Html->tag('span', '', array('class' => 'caret')), $this->here . '#', array(
				'class' => 'btn dropdown-toggle',
				'data-toggle' => 'dropdown',
				'escape' => false
			)),
			$this->Design->arrayToList($shopShippingMethods, array(
				'ul' => 'dropdown-menu'
			))
		));
	}

	public function paymentSelect(array $paymentMethod, array $shopPaymentMethods) {
	}

	public function shipping(array $shipping) {
		$rows = array(
			__d('shop', 'Packaging') => $this->currency($shipping['surcharge']),
			__d('shop', 'Insurance') => __d('shop', '%s covers upto %s',
				$this->currency($shipping['insurance_rate']),
				$this->currency($shipping['insurance_cover'])
			),
			__d('shop', 'Shipping') => $this->currency($shipping['shipping']),
			__d('shop', 'Total') => $this->currency($shipping['total']),
		);
		foreach ($rows as $title => &$row) {
			$row = $this->Html->tag('tr', implode('', array(
				$this->Html->tag('th', $title),
				$this->Html->tag('td', $row),
			)));
		}

		return $this->Html->link($this->currency($shipping['total']), $this->here . '#', array(
			'class' => 'shipping-breakdown',
			'escape' => false,
			'data-title' => __d('shop', 'Shipping information'),
			'data-html' => 1,
			'data-content' => $this->Html->tag('table', $this->Html->tag('tbody', implode('', $rows))),
			'data-placement' => 'top'
		));
	}
}