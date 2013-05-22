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
	'invoice',
	'packing_slip',
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
				$this->Paginator->sort('invoice_number', '#'),
				$this->Paginator->sort('ShopAssignedUser.username', 'Assigned'),
				$this->Paginator->sort('User.username', 'User'),
				$this->Paginator->sort('ShopShippingMethod.name', __d('shop', 'Shipping')),
				$this->Paginator->sort('ShopPaymentMethod.name', __d('shop', 'Payment')),
				$this->Paginator->sort('tracking_number', __d('shop', 'Tracking #')),
				$this->Paginator->sort('ShopOrderStatus.name', 'Status'),
				$this->Paginator->sort('ip_address'),
				$this->Paginator->sort('total'),
				$this->Paginator->sort('modified') => array(
					'class' => 'date'
				),
				__d('shop', 'Payment')
			)
		);

		foreach ($shopOrders as $shopOrder) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopOrder); ?>&nbsp;</td>
				<td>
					<?php
						echo $this->Html->link($shopOrder['ShopOrder']['invoice_number'], array(
							'action' => 'view',
							$shopOrder['ShopOrder']['id']
						));
					?>&nbsp;
				</td>
				<td>
					<?php
						if ($shopOrder['ShopAssignedUser']['id']) {
							echo $this->Html->link($shopOrder['ShopAssignedUser']['username'], array(
								'plugin' => 'users',
								'controller' => 'users',
								'action' => 'edit',
								$shopOrder['ShopAssignedUser']['id']
							));
						} else {
							echo '-';
						}
					?>&nbsp;
				</td>
				<td>
					<?php
						echo $this->Html->link($shopOrder['User']['username'], array(
							'plugin' => 'users',
							'controller' => 'users',
							'action' => 'edit',
							$shopOrder['User']['id']
						));
					?>&nbsp;
				</td>
				<td>
					<?php
						if ($shopOrder['ShopShippingMethod']['name']) {
							echo $this->Html->link($shopOrder['ShopShippingMethod']['name'], array(
								'controller' => 'shop_shipping_methods',
								'action' => 'edit',
								$shopOrder['ShopShippingMethod']['id']
							));
						} else {
							echo '-';
						}
					?>&nbsp;
				</td>
				<td>
					<?php
						if ($shopOrder['ShopPaymentMethod']['name']) {
							echo $this->Html->link($shopOrder['ShopPaymentMethod']['name'], array(
								'controller' => 'shop_payment_methods',
								'action' => 'edit',
								$shopOrder['ShopPaymentMethod']['id']
							));
						} else {
							echo '-';
						}
					?>&nbsp;
				</td>
				<td><?php echo $shopOrder['ShopOrder']['tracking_number'] ?: $this->Html->tag('em', 'null'); ?>&nbsp;</td>
				<td><?php echo $this->Design->label($shopOrder['ShopOrderStatus']['name']); ?></td>
				<td><?php echo $shopOrder['ShopOrder']['ip_address']; ?>&nbsp;</td>
				<td><?php echo $this->Shop->adminCurrency($shopOrder['ShopOrder']['total']); ?>&nbsp;</td>
				<td><?php echo $this->Infinitas->date($shopOrder['ShopOrder']); ?></td>
				<td>
					<?php
						$popover = $this->Html->tag('dl', implode('', array(
							$this->Html->tag('dt', __d('shop', 'Token')),
							$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['token']),
							$this->Html->tag('dt', __d('shop', 'Transaction ID')),
							$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['transaction_id']),
							$this->Html->tag('dt', __d('shop', 'Type')),
							$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['transaction_type']),
							$this->Html->tag('dt', __d('shop', 'Currency')),
							$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['currency_code']),
							$this->Html->tag('dt', __d('shop', 'Fee')),
							$this->Html->tag('dd', $this->Shop->currency($shopOrder['InfinitasPaymentLog']['transaction_fee'], $shopOrder['InfinitasPaymentLog']['currency_code'])),
							$this->Html->tag('dt', __d('shop', 'Total')),
							$this->Html->tag('dd', $this->Shop->currency($shopOrder['InfinitasPaymentLog']['total'], $shopOrder['InfinitasPaymentLog']['currency_code'])),
							$this->Html->tag('dt', __d('shop', 'Status')),
							$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['status']),
							$this->Html->tag('dt', __d('shop', 'Date')),
							$this->Html->tag('dd', CakeTime::nice($shopOrder['InfinitasPaymentLog']['created'])),
						)), array('class' => 'dl-horizontal'));
						echo $this->Html->link($this->Design->icon('money'), $this->here . '#', array(
							'escape' => false,
							'data-html' => true,
							'data-placement' => 'left',
							'data-title' => __d('shop', 'Payment status'),
							'data-content' => htmlspecialchars($popover)
						));
					?>
				</td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');