<?php
/**
 * @brief build the currency select markup
 */
if(empty($shopCurrencies)) {
	return;
}

foreach($shopCurrencies as &$currency) {
	$code = $currency['ShopCurrency']['code'];
	$currency = $this->Html->link(
		$currency['ShopCurrency']['code'],
		array(
			'plugin' => 'shop',
			'controller' => 'shop_currencies',
			'action' => 'change',
			'code' => $currency['ShopCurrency']['code']
		),
		array(
			'title' => $currency['ShopCurrency']['name']
		)
	);
	$currency = $this->Html->tag('li', $currency, array(
		'class' => ShopCurrencyLib::getCurrency() == $code ? 'active' : null
	));
}
echo $this->Html->tag('ul', implode('', $shopCurrencies), array('class' => 'nav'));
