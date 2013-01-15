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

echo $this->element('Shop.profile/header');
echo $this->Form->create(null, array('action' => 'mass'));
echo $this->Infinitas->massActionButtons(array(
	'add',
	'edit',
	'delete'
));
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			$this->Form->checkbox('all') => array(
				'class' => 'first',
			),
			$this->Paginator->sort('name'),
			$this->Paginator->sort('ShopShippingMethod.name', __d('shop', 'Shipping')),
			$this->Paginator->sort('ShopPaymentMethod.name', __d('shop', 'Payment')),
			$this->Paginator->sort('shop_list_product_count', __d('shop', 'Products')) => array(
				'style' => 'width:50px;'
			),
			$this->Paginator->sort('modified', __d('shop', 'Updated')),
			__d('shop', 'Actions')
		));

		foreach ($shopLists as $shopList) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopList); ?>&nbsp;</td>
				<td><?php echo $this->Html->adminQuickLink($shopList['ShopList']); ?>&nbsp;</td>
				<td><?php echo $shopList['ShopShippingMethod']['name'] ?: '-'; ?>&nbsp;</td>
				<td><?php echo $shopList['ShopPaymentMethod']['name'] ?: '-'; ?>&nbsp;</td>
				<td><?php echo $this->Design->count($shopList['ShopList']['shop_list_product_count']); ?>&nbsp;</td>
				<td><?php echo CakeTime::niceShort($shopList['ShopList']['modified']); ?></td>
				<td>
					<?php
					?>&nbsp;
				</td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/navigation');