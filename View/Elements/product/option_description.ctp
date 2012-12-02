<?php
foreach ($shopProduct['ShopOption'] as $option) {
	foreach ($option['ShopOptionValue'] as $k => &$value) {
		$value = $this->Html->tag('tr', implode('', array(
			$this->Html->tag('td', $this->Html->link($value['name'], $this->here . '#', array(
				'class' => 'option-value',
				'data-option-id' => $option['id'],
				'data-value-id' => $value['id']
			))),
			$this->Html->tag('td', trim(strip_tags($value['description']))),
			$this->Html->tag('td', $value['product_code']),
			$this->Html->tag('td', $this->Shop->optionPrice($value['ShopPrice']['selling'])),
			$this->Html->tag('td', $this->Shop->calculatedSize($shopProduct['ShopSize'], $value['ShopSize'])),
			$this->Html->tag('td', $this->Shop->calculatedSize($shopProduct['ShopSize'], $value['ShopSize'], true)),
		)), array('class' => array(
			$value['id'],
			!$option['required'] && $k == 0 ? 'info' : null
		)));
	}

	echo $this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', implode(' ', array(
			$option['name'],
			$option['required'] ? $this->Html->tag('span', __d('shop', 'Required'), array('class' => 'label label-important')) : null
		))),
		$option['description'],
	)), array('class' => 'alert alert-info'));
	echo $this->Html->tag('table', implode('', array(
		$this->Html->tag('caption', __d('shop', '%s information', $option['name'])),
		$this->Html->tag('thead', implode('', array(
			$this->Html->tag('tr', implode('', array(
				$this->Html->tag('th', __d('shop', 'Value'), array(
					'width' => '150px',
					'class' => 'size'
				)),
				$this->Html->tag('th', __d('shop', 'Description')),
				$this->Html->tag('th', __d('shop', 'Code'), array(
					'width' => '150px',
					'class' => 'size'
				)),
				$this->Html->tag('th', __d('shop', 'Cost'), array(
					'width' => '150px',
					'class' => 'size'
				)),
				$this->Html->tag('th', __d('shop', 'Product Size'), array(
					'width' => '150px',
					'class' => 'size'
				)),
				$this->Html->tag('th', __d('shop', 'Shipping Size'), array(
					'width' => '150px',
					'class' => 'size'
				))
			)))
		))),
		$this->Html->tag('tbody', implode('', $option['ShopOptionValue']))
	)), array('class' => 'table table-striped table-hover table-condensed options'));
}