<?php
$specs = array(
	__d('shop', 'Available Stock') => $shopProduct['ShopProduct']['total_stock'],
	__d('shop', 'Views') => $shopProduct['ShopProduct']['views'],
	__d('shop', 'Product Type') => $shopProduct['ShopProductType']['name'],
	__d('shop', 'Brand') => $shopProduct['ShopBrand']['name'],
	__d('shop', 'Variants') => $this->Html->tag('span', count($shopProduct['ShopProductVariant']), array(
		'title' => __d('shop', 'Number of variations available for this product'),
		'class' => 'badge'
	)),
	__d('shop', 'Size') => sprintf('%s (%s)', $this->Shop->size($shopProduct['ShopProductVariantMaster']['ShopProductVariantSize']), $this->Shop->sizeLabel()),
	__d('shop', 'Weight') => sprintf('%s g', round($shopProduct['ShopProductVariantMaster']['ShopProductVariantSize']['product_weight'], 2))
);

foreach ($specs as $label => &$spec) {
	$spec = $this->Html->tag('dt', $label) . $this->Html->tag('dd', $spec);
}
echo $this->Html->tag('dl', implode('', $specs), array('class' => 'dl-horizontal'));
echo $this->Html->tag('hr');
