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

echo $this->Form->create(null, array('action' => 'mass'));
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			__d('shop', 'Product'),
			__d('shop', 'Quantity') => array(
				'style' => 'width: 100px;'
			),
			__d('shop', 'Actions') => array(
				'width' => '50px'
			)
		), false);

		foreach ($shopListProducts as $k => $shopListProduct) { ?>
			<tr>
				<td>
					<?php
						echo $this->Html->link($shopListProduct['ShopProduct']['name'], array(
							'controller' => 'shop_products',
							'action' => 'view',
							'slug' => $shopListProduct['ShopProduct']['slug'],
							'category' => $shopListProduct['ShopCategory']['slug']
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
				<td>
					<?php
						echo $this->Html->link($this->Design->icon('trash'), array(
							'action' => 'delete',
							$shopListProduct['ShopListProduct']['id']
						), array('class' => 'btn btn-danger btn-small', 'escape' => false));
					?>&nbsp;
				</td>
			</tr><?php
			if ($shopListProduct['ShopListProductOption']) {
				$options = array();
				foreach ($shopListProduct['ShopListProductOption'] as $productOption) {
					$options[] = $this->Html->tag('dt', $productOption['ShopOption']['name']);
					$options[] = $this->Html->tag('dd', $productOption['ShopOptionValue']['name']);
				}

				echo $this->Html->tag('tr', $this->Html->tag('td',
					$this->Html->tag('dl', implode('', $options), array(
						'class' => 'dl-horizontal'
					)),
					array('colspan' => 110)
				));
			}
		}
	?>
</table>
<?php
	echo $this->Html->tag('div', implode('', array(
		$this->Form->button(__d('shop', 'Update'), array(
			'class' => 'btn'
		)),
		$this->Form->button(__d('shop', 'Checkout'), array(
			'class' => 'btn btn-info'
		))
	)), array('class' => 'btn-group pull-right'));
	echo $this->Form->end();