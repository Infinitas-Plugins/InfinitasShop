<?php
class ShopHelper extends AppHelper {
	public $helpers = array(
		'Text',
		'Html',
		'Form',
		'Libs.Infinitas',
		'Libs.Design'
	);

/**
 * @brief link email addresses with optional icon
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
			'target' => '_blank'
		), $options);

		if(!$icon) {
			return $this->Text->autoLinkEmails($email, $options);
		}

		return $this->Html->link(
			$this->Html->image('Emails.icon.png', array(
				'width' => 24,
				'alt' => __d('shop', 'Email')
			)),
			'mailto:' . $email,
			$options
		);
	}

/**
 * @brief convert hours to meaningful time
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
		if($hours <= 24) {
			return __dn('shop', '%d hour', '%d hours', $hours, $hours);
		}

		$days = round($hours / 24);
		if($days <= 7) {
			return __dn('shop', '%d day', '%d days', $days, $days);
		}

		$weeks = round($days / 7);
		if($weeks <= 6) {
			return __dn('shop', '%d week', '%d weeks', $weeks, $weeks);
		}

		$months = round($weeks / 4.2);
		return __dn('shop', '%d month', '%d months', $months, $months);
	}

/**
 * @brief convert an amount to currency
 *
 * @param float $amount the amount to show
 *
 * @return string
 */
	public function adminCurrency($amount) {
		return self::_currencyDisplay($amount, 'GBP');
	}

/**
 * @brief get the value in the selected currency
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
 * @brief display the stock quantity / value
 *
 * returns html markup for swtiching between stock count and value
 *
 * @param float $quantity the number of items in stock
 * @param float $price the value of a single item
 *
 * @return string
 */
	public function stockValue($quantity, $price) {
		return $this->Html->tag('div',
			implode('', array(
				$this->Html->tag('span', $quantity, array('class' => 'quantity')),
				$this->Html->tag('span', self::adminCurrency(
					($quantity < 0) ? 0 : $quantity * $price
				), array('class' => 'value'))
			)),
			array('class' => 'stock-value')
		);
	}

/**
 * @brief show the status of a product
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
		if(!array_key_exists('active', $product['ShopProduct'])) {
			return sprintf($problem, __d('shop', 'product status'));
		}
		if(!array_key_exists('available', $product['ShopProduct'])) {
			return sprintf($problem, __d('shop', 'product available date'));
		}
		if(!array_key_exists('active', $product['ShopBrand'])) {
			return sprintf($problem, __d('shop', 'brand'));
		}
		if(!array_key_exists('active', $product['ShopProductType'])) {
			return sprintf($problem, __d('shop', 'product type'));
		}
		if(!array_key_exists('active', $product['ShopSupplier'])) {
			return sprintf($problem, __d('shop', 'supplier'));
		}
		if(!array_key_exists('category_active', $product['ShopProduct'])) {
			return sprintf($problem, __d('shop', 'cateogry status'));
		}

		$statuses = array(
			'product' => array(
				'status' => $product['ShopProduct']['active'],
				1 => __d('shop', 'Product is active'),
				0 => __d('shop', 'Product is disabled')
			),
			'available' => array(
				'status' => $product['ShopProduct']['available'] <= date('Y-m-d H:i:s'),
				1 => __d('shop', 'Product is currently available'),
				0 => __d('shop', 'Product will be available after %s', CakeTime::niceShort($product['ShopProduct']['available']))
			),
			'brand' => array(
				'status' => $product['ShopBrand']['active'],
				1 => __d('shop', 'Brand is active'),
				0 => __d('shop', 'Brand has been disabled')
			),
			'type' => array(
				'status' => $product['ShopProductType']['active'],
				1 => __d('shop', 'Product type is active'),
				0 => __d('shop', 'Product type has been disabled')
			),
			'supplier' => array(
				'status' => $product['ShopSupplier']['active'],
				1 => __d('shop', 'Supplier is active'),
				0 => __d('shop', 'Supplier has been disabled')
			),
			'category' => array(
				'status' => $product['ShopProduct']['category_active'],
				1 => __d('shop', 'Category is active'),
				0 => __d('shop', 'Category has been disabled')
			)
		);

		if(empty($product['ShopCategory'])) {
			$statuses['category'] = array(
				'status' => false,
				0 => __d('shop', 'Not linked to any categories')
			);
		}

		$overallStatus = true;
		$out = array();
		foreach($statuses as $status) {
			if($status['status'] === true) {
				continue;
			}
			$overallStatus = $overallStatus && $status['status'];
			$out[] = $status[(int)$status['status']];
		}

		return $this->Infinitas->status($overallStatus, array(
			'title_yes' => __d('shop', 'Available :: This product is available to customers for purchase'),
			'title_no' => __d('shop', 'Disabled :: This product will not be available to customers.<br/>%s', $this->Design->arrayToList($out))
		));
	}

/**
 * @brief display the cost details for a price
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
 * @brief build markup info switch html
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
 * @brief calculate the markup of a price
 *
 * @param  array $shopPrice the pricing information
 * @param  boolean $percent calculate as a percentacge or value
 *
 * @return string
 */
	protected function _markup(array $shopPrice, $percent = false) {
		$markup = $shopPrice['selling'] - $shopPrice['cost'];
		if(!$percent) {
			return $markup;
		}
		if($shopPrice['cost'] == 0) {
			$shopPrice['cost'] = .01;
		}

		return ($markup / $shopPrice['cost']) * 100;
	}

/**
 * @brief build a nested category nav
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
		foreach($shopCategories as &$category) {
			$name = $category['ShopCategory']['name'];
			if(Configure::read('Shop.display_category_count') && array_key_exists('shop_product_count', $category['ShopCategory'])) {
				$name = sprintf('%s (%d)', $category['ShopCategory']['name'], $category['ShopCategory']['shop_product_count']);
			}

			$children = null;
			$liOptions = array();
			$linkOptions = array('escape' => false);
			if(!empty($category['children'])) {
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
				if(!$isChild) {
					$name = sprintf('%s%s', $name, $this->Html->tag('b', '', array('class' => 'caret')));
				} else if($isChild) {
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
 * @brief generate information links
 *
 * @param string $title the heading of the box being generated
 * @param array $links key value array of title => url
 *
 * @return type
 */
	public function infoLinks($title, array $links) {
		foreach($links as $title => &$link) {
			$link = $this->Html->link($title, $link);
		}

		return $this->Html->tag('div', implode('', array(
			$this->Html->tag('h4', $title),
			$this->Design->arrayToList($links, array('ul' => 'unstyled'))
		)), array('class' => 'span3'));
	}

/**
 * @brief generate the breadcrumbs for the category path
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
		if(empty($categories)) {
			return;
		}

		$divider = $this->Html->tag('span', '/', array('class' => 'divider'));

		$count = count($categories);
		if(!empty($product)) {
			$count++;
		}

		foreach($categories as $k => &$category) {
			if($k + 1 == $count) {
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

		if(!empty($product)) {
			$categories[] = $product;
		}

		return $this->Design->arrayToList($categories, array('ul' => 'breadcrumb'));
	}

	public function addToCart(array $product, array $options = array()) {
		return implode('', array(
			$this->Form->create('ShopList', array('url' => array(
				'plugin' => 'shop',
				'controller' => 'shop_lists',
				'action' => 'add'
			))),
				$this->Form->hidden('ShopList.product_id', array(
					'value' => $product['id']
				)),
				$this->Form->submit(__d('shop', 'Add to Cart'), $options),
			$this->Form->end()
		));
	}

/**
 * @brief generate the pricing information
 *
 * @param array $product
 * @return type
 */
	public function price(array $product) {
		if(empty($product['ShopPrice']['selling'])) {
			return __d('shop', 'Call for price');
		}

		return $this->Html->tag('span', $this->currency($product['ShopPrice']['selling']), array(
			'class' => 'price price-now'
		));
	}

}