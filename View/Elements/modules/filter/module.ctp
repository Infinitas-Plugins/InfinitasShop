<?php
echo $this->Form->create('ShopProduct', array(
	'url' => array(
		'plugin' => 'shop',
		'controller' => 'shop_products',
		'action' => 'search',
	),
	'inputDefaults' => array(
		'label' => false,
		'div' => false
	)
));
	$i = 0;
	foreach ($shopConnectedAttributes as $group) {
		$list[] = $this->Html->tag('li', $this->Html->link($group['ShopAttributeGroup']['name'], $this->request->here . '#', array(
			'data-attribute-group' => $group['ShopAttributeGroup']['slug'],
			'class' => 'attribute-group'
		)), array('class' => 'nav-header'));

		foreach ($group['ShopAttribute'] as $attribute) {
			$optionValue = !empty($attribute['colour']) ? $attribute['colour'] : $attribute['slug'];
			$url = array_intersect_key($this->request->params, array_fill_keys(array('plugin', 'controller', 'action', 'category', 'slug'), null));
			$url = array_merge($url, $this->request->params['named']);
			if (empty($url[$group['ShopAttributeGroup']['slug']])) {
				$url[$group['ShopAttributeGroup']['slug']] = array();
			}
			$key = array_search($optionValue, $url[$group['ShopAttributeGroup']['slug']]);
			if ($key !== false) {
				unset($url[$group['ShopAttributeGroup']['slug']][$key]);
			} else {
				$url[$group['ShopAttributeGroup']['slug']][] = $optionValue;
			}

			$list[] = $this->Html->tag('li', implode('', array(
				$this->Html->link($attribute['name'], $url),
				$this->Design->count($attribute['shop_product_attribute_count'])
			)), array('class' => array(
				$group['ShopAttributeGroup']['slug'],
				$key !== false ? 'active' : null
			)));

		}
	}

	$list[] = $this->Html->tag('li', __d('shop', 'Options'), array(
		'class' => 'nav-header'
	));
	foreach ($shopFilterOptions['ShopOption'] as $option) {
		$list[] = $this->Html->tag('li', $this->Form->input($option['id'], array(
			'type' => 'checkbox',
			'label' => $option['name'],
			'div' => true
		)));
	}

	echo $this->Html->tag('ul', implode('', $list), array(
		'class' => 'filter'
	));
echo $this->Form->end();

return;

	echo $this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', __d('shop', 'Product filter')),
		$this->Html->tag('div', '', array('class' => 'range')),
		$this->Form->input('price_min', array(
			'style' => 'display:none;',
			'value' => 10
		)),
		$this->Form->input('price_max', array(
			'style' => 'display:none;',
			'value' => 150
		)),
		$this->Html->tag('h5', __d('shop', 'Price')),
		$this->Html->tag('div', '', array('class' => 'price-slider')),
		$this->Form->input('special', array(
			'type' => 'checkbox',
			'label' => __d('shop', 'On sale'),
			'div' => true
		)),
		$this->Html->tag('h4', __d('shop', 'Options')),
		implode('', $options)
	)), array('class' => 'well filter', 'style' => 'width: 100%'));