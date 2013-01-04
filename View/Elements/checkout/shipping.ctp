<?php
echo $this->Form->input('ShopList.shipping_method_id', array(
	'options' => $shopShippingMethods,
	'value' => $shopList['ShopShippingMethod']['id'],
	'type' => 'radio'
));
