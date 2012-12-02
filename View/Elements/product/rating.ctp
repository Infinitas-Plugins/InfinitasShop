<?php

$rating = __d('shop', 'Not rated yet');
$button = __d('shop', 'Be the first');
if ($shopProduct['ShopProduct']['rating_count']) {
	$button = __d('shop', 'Rate this product');
	$rating = __d('shop', '%s out of %d', $shopProduct['ShopProduct']['rating'], $shopProduct['ShopProduct']['rating_count']);
}
echo $rating;
echo $this->Html->link($button, array(
	'action' => 'rate',
	$shopProduct['ShopProduct']['id'],
	'?' => ''
), array(
	'class' => 'btn btn-info btn-small pull-right thickbox',
	'title' => __d('shop', 'Let other shoppers know about this product')
));
echo $this->Html->tag('hr');