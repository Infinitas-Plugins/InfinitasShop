<?php
echo $this->Form->input('name', array(
	'placeholder' => __d('shop', 'eg: Home or Work'),
	'label' => false
));
echo $this->element('GeoLocation.region_select', array(
	'model' => 'ShopAddress',
	'label' => false
));

echo $this->Form->input('address_1', array(
	'placeholder' => __d('shop', 'Address line 1'),
	'label' => false
));

echo $this->Form->input('address_2', array(
	'placeholder' => __d('shop', 'Address line 2'),
	'label' => false
));

echo $this->Form->input('post_code', array(
	'placeholder' => __d('shop', 'Post / Zip code'),
	'label' => false
));

echo $this->Form->input('billing', array(
	'label' => __d('shop', 'This is for billing only'),
	'type' => 'checkbox',
	'div' => true
));