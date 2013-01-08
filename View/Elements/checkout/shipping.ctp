<?php
echo $this->Form->input('ShopList.shop_shipping_method_id', array(
	'options' => $shopShippingMethods,
	'value' => $shopList['ShopShippingMethod']['id'],
	'type' => 'radio'
));
