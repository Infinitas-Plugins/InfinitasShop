<?php
$specs = array(
	__d('shop', 'Available Stock') => $shopProduct['ShopProduct']['total_stock'],
	__d('shop', 'Views') => $shopProduct['ShopProduct']['views'],
	__d('shop', 'Product Type') => $shopProduct['ShopProductType']['name'],
	__d('shop', 'Brand') => $shopProduct['ShopBrand']['name']
);

foreach($specs as $label => &$spec) {
	$spec = $this->Html->tag('dt', $label) . $this->Html->tag('dd', $spec);
}
echo $this->Html->tag('dl', implode('', $specs), array('class' => 'dl-horizontal'));
echo $this->Html->tag('hr');
