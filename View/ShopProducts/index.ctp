<?php
echo $this->element('Shop.current_category', array('currentCategory' => $currentCategory));
echo $this->Shop->categoryBreadcrumbs($categoryPath);
echo $this->element('Shop.category_list', array('shopCategories' => $shopCategories));

foreach ($shopProducts as &$shopProduct) {
	$url = array(
		'plugin' => 'shop',
		'controller' => 'shop_products',
		'action' => 'view',
		'category' => !empty($this->request->category) ? $this->request->category : null,
		'slug' => $shopProduct['ShopProduct']['slug']
	);

	$shopProduct = $this->Html->tag('div', implode('', array(
		$this->Html->link(
			$this->Html->image($shopProduct['ShopImage']['image_medium']),
			$url,
			array(
				'escape' => false,
				'class' => 'image'
			)
		),
		$this->Html->tag('div', implode('', array(
			$this->Html->tag('h5', $this->Html->link($shopProduct['ShopProduct']['name'], $url)),
			$this->Html->tag('p', $this->Text->truncate(strip_tags($shopProduct['ShopProduct']['description'])), array('class' => 'description')),
			$this->Html->tag('p', __d('shop', 'From %s', $this->Shop->price($shopProduct['ShopProductVariantMaster']['ShopProductVariantPrice'], false)), array(
				'class' => 'price',
				'style' => 'color: #333'
			)),
			$this->Shop->addToCart($shopProduct, array(
				'class' => 'pull-right'
			))
		))),
	)), array('class' => 'product thumbnail'));
}
echo $this->Design->arrayToList($shopProducts, array('ul' => 'thumbnails', 'li' => 'span3 product'));

echo $this->element('Shop.pagination/navigation');
