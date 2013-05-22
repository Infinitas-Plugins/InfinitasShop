<?php
/**
 * @brief Add some documentation for this admin_index form.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.View.admin_index
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

echo $this->Form->create(null, array('action' => 'mass'));
echo $this->Infinitas->adminIndexHead($filterOptions, array(
	'add',
	'edit',
	'toggle',
	'copy',
	'delete'
));
echo $this->Filter->alphabetFilter();
?>
<table class="listing">
	<?php
			echo $this->Infinitas->adminTableHeader(
				array(
					$this->Form->checkbox('all') => array(
						'class' => 'first',
					),
					$this->Paginator->sort('name'),
					$this->Paginator->sort('token'),
					$this->Paginator->sort('User.username', 'User'),
					$this->Paginator->sort('ShopShippingMethod.name', 'ShopShippingMethod'),
					$this->Paginator->sort('ShopPaymentMethod.name', 'ShopPaymentMethod'),
					$this->Paginator->sort('shop_list_product_count', 'Shop List Products') => array(
						'style' => 'width:50px;'
					),
					$this->Paginator->sort('created') => array(
						'style' => 'width:75px;'
					),
					$this->Paginator->sort('modified') => array(
						'style' => 'width:75px;'
					),
				)
			);

			foreach ($shopLists as $shopList) { ?>
				<tr>
					<td><?php echo $this->Infinitas->massActionCheckBox($shopList); ?>&nbsp;</td>
					<td><?php echo $this->Html->adminQuickLink($shopList['ShopList']); ?>&nbsp;</td>
					<td><?php echo $shopList['ShopList']['token']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($shopList['User']['username'], array('controller' => 'users', 'action' => 'view', $shopList['User']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($shopList['ShopShippingMethod']['name'], array('controller' => 'shop_shipping_methods', 'action' => 'view', $shopList['ShopShippingMethod']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($shopList['ShopPaymentMethod']['name'], array('controller' => 'shop_payment_methods', 'action' => 'view', $shopList['ShopPaymentMethod']['id'])); ?>
					</td>
					<td><?php echo $shopList['ShopList']['shop_list_product_count']; ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopList['ShopList']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopList['ShopList']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');