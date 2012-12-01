<?php
/**
 * @brief Add some documentation for this index form.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.View.index
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

if (empty($shopListProducts)) {
	echo $this->Design->alert(__d('shop', 'You dont have anything in your cart yet'));
	return;
}

if(empty($shopShipping)) {
	echo $this->Design->alert(__d('shop', 'No shipping method selected'));
}

echo $this->Form->create(null, array('action' => 'mass'));
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			__d('shop', 'Image') => array(
				'style' => 'width: 100px;'
			),
			__d('shop', 'Product'),
			__d('shop', 'Quantity') => array(
				'style' => 'width: 100px;'
			),
			__d('shop', 'Each') => array(
				'style' => 'width: 100px;'
			),
			__d('shop', 'Sub Total') => array(
				'style' => 'width: 100px;'
			),
			__d('shop', 'Actions') => array(
				'width' => '50px'
			)
		), false);
		echo '<tbody>';
		foreach ($shopListProducts as $k => $shopListProduct) { ?>
			<tr>
				<td rowspan="<?php echo $shopListProduct['ShopOption'] ? 2 : 1; ?>"><?php echo $this->Html->image($shopListProduct['ShopImage']['image_small']); ?></td>
				<td>
					<?php
						echo $this->Html->link($shopListProduct['ShopProduct']['name'], array(
							'controller' => 'shop_products',
							'action' => 'view',
							'slug' => $shopListProduct['ShopProduct']['slug'],
							'category' => $shopListProduct['ShopCategory'][0]['slug']
					));
					?>&nbsp;
				</td>
				<td>
					<?php
						$formField = 'ShopListProduct.' . $k;
						echo $this->Form->input($formField . '.id', array(
							'value' => $shopListProduct['ShopListProduct']['id']
						));
						echo $this->Form->input($formField . '.quantity', array(
							'value' => $shopListProduct['ShopListProduct']['quantity'],
							'type' => 'text',
							'div' => false,
							'label' => false
						));
					?>
				</td>
				<td><?php echo $this->Shop->price($shopListProduct, false); ?></td>
				<td><?php echo $this->Shop->subtotalPrice($shopListProduct); ?></td>
				<td>
					<?php
						echo $this->Html->link($this->Design->icon('trash'), array(
							'action' => 'delete',
							$shopListProduct['ShopListProduct']['id']
						), array('class' => 'btn btn-danger btn-small', 'escape' => false));
					?>&nbsp;
				</td>
			</tr><?php
			if ($shopListProduct['ShopOption']) {
				$options = array();
				foreach ($shopListProduct['ShopOption'] as $productOption) {
					$options[] = $this->Html->tag('dt', $productOption['name']);
					$options[] = $this->Html->tag('dd', $productOption['ShopOptionValue'][0]['name']);
				}

				echo $this->Html->tag('tr', implode('', array(
					$this->Html->tag('td',
						$this->Html->tag('dl', implode('', $options), array('class' => 'dl-horizontal')),
						array('colspan' => 2)
					),
					$this->Html->tag('td', $this->Shop->size($shopListProduct['ShopSize'], true) . sprintf('(%s)', $this->Shop->sizeLabel()), array(
						'colspan' => 100
					))
				)));
			}
		}
		echo $this->Html->tag('tr', implode('', array(
			$this->Html->tag('td', '', array('colspan' => 3)),
			$this->Html->tag('td', __d('shop', 'Sub Total'), array('class' => 'pull-right')),
			$this->Html->tag('td', $this->Shop->cartPrice($shopListProducts), array('colspan' => 2))
		)));
		echo $this->Html->tag('tr', implode('', array(
			$this->Html->tag('td', '', array('colspan' => 3)),
			$this->Html->tag('td', __d('shop', 'Shipping'), array('class' => 'pull-right')),
			$this->Html->tag('td', $this->Shop->cartPrice($shopListProducts), array('colspan' => 2))
		)));
		echo $this->Html->tag('tr', implode('', array(
			$this->Html->tag('td', '', array('colspan' => 3)),
			$this->Html->tag('td', __d('shop', 'Total'), array('class' => 'pull-right')),
			$this->Html->tag('td', ' ' . $this->Shop->cartPrice($shopListProducts), array('colspan' => 2))
		)));
	?></tbody>
</table>
<?php
	foreach ($shopShippingMethods as $k => &$shopShippingMethod) {
		$shopShippingMethod = $this->Html->link($shopShippingMethod, array(
			'plugin' => 'shop',
			'controller' => 'shop_lists',
			'action' => 'set_shipping_method',
			$k
		));
	}

	echo $this->Html->tag('div', implode('', array(
		$this->Html->link(__d('shop', 'Shipping method') . $this->Html->tag('span', '', array('class' => 'caret')), $this->here . '#', array(
			'class' => 'btn dropdown-toggle',
			'data-toggle' => 'dropdown',
			'escape' => false
		)),
		$this->Design->arrayToList($shopShippingMethods, array(
			'ul' => 'dropdown-menu'
		))
	)), array('class' => 'btn-group pull-left'));

	echo $this->Html->tag('div', implode('', array(
		$this->Form->button(__d('shop', 'Update'), array(
			'class' => 'btn'
		)),
		$this->Form->button(__d('shop', 'Checkout'), array(
			'class' => 'btn btn-info'
		))
	)), array('class' => 'btn-group pull-right'));
	echo $this->Form->end();