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
					$this->Paginator->sort('invoice_number'),
					$this->Paginator->sort('User.username', 'User'),
					$this->Paginator->sort('ShopBillingAddress.name', 'ShopBillingAddress'),
					$this->Paginator->sort('ShopShippingAddress.name', 'ShopShippingAddress'),
					$this->Paginator->sort('ShopPaymentMethod.name', 'ShopPaymentMethod'),
					$this->Paginator->sort('ShopShippingMethod.name', 'ShopShippingMethod'),
					$this->Paginator->sort('tracking_number'),
					$this->Paginator->sort('InfinitasPaymentLog.id', 'InfinitasPaymentLog'),
					$this->Paginator->sort('ShopOrderStatus.name', 'ShopOrderStatus'),
					$this->Paginator->sort('ip_address'),
					$this->Paginator->sort('created') => array(
						'style' => 'width:75px;'
					),
					$this->Paginator->sort('modified') => array(
						'style' => 'width:75px;'
					),
				)
			);

			foreach ($shopOrders as $shopOrder) { ?>
				<tr>
					<td><?php echo $this->Infinitas->massActionCheckBox($shopOrder); ?>&nbsp;</td>
					<td><?php echo $shopOrder['ShopOrder']['invoice_number']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($shopOrder['User']['username'], array('controller' => 'users', 'action' => 'view', $shopOrder['User']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($shopOrder['ShopBillingAddress']['name'], array('controller' => 'shop_addresses', 'action' => 'view', $shopOrder['ShopBillingAddress']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($shopOrder['ShopShippingAddress']['name'], array('controller' => 'shop_addresses', 'action' => 'view', $shopOrder['ShopShippingAddress']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($shopOrder['ShopPaymentMethod']['name'], array('controller' => 'shop_payment_methods', 'action' => 'view', $shopOrder['ShopPaymentMethod']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($shopOrder['ShopShippingMethod']['name'], array('controller' => 'shop_shipping_methods', 'action' => 'view', $shopOrder['ShopShippingMethod']['id'])); ?>
					</td>
					<td><?php echo $shopOrder['ShopOrder']['tracking_number']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($shopOrder['InfinitasPaymentLog']['id'], array('controller' => 'infinitas_payment_logs', 'action' => 'view', $shopOrder['InfinitasPaymentLog']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($shopOrder['ShopOrderStatus']['name'], array('controller' => 'shop_order_statuses', 'action' => 'view', $shopOrder['ShopOrderStatus']['id'])); ?>
					</td>
					<td><?php echo $shopOrder['ShopOrder']['ip_address']; ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopOrder['ShopOrder']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopOrder['ShopOrder']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');