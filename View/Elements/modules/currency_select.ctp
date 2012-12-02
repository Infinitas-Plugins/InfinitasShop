<?php
/**
 * build the currency select markup
 */
if (empty($shopCurrencies)) {
	return;
}
$field = Configure::read('Shop.currency_select');
foreach ($shopCurrencies as &$currency) {
	$code = $currency['ShopCurrency']['code'];
	$currency = $this->Html->link(
		$currency['ShopCurrency'][$field],
		array(
			'plugin' => 'shop',
			'controller' => 'shop_currencies',
			'action' => 'change',
			'code' => $code
		),
		array(
			'title' => $currency['ShopCurrency']['name'],
			'escape' => false
		)
	);
	$currency = $this->Html->tag('li', $currency, array(
		'class' => ShopCurrencyLib::getCurrency() == $code ? 'active' : null
	));
}
echo $this->Html->tag('ul', implode('', $shopCurrencies), array('class' => 'nav'));
