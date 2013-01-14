<?php
/**
 * Order index for frontend
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/Shop
 * @package Shop.View.index
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			$this->Paginator->sort('invoice_number'),
			$this->Paginator->sort('ShopPaymentMethod.name', __d('shop', 'Payment')),
			$this->Paginator->sort('ShopShippingMethod.name', __d('shop', 'Shipping')),
			$this->Paginator->sort('tracking_number'),
			$this->Paginator->sort('InfinitasPaymentLog.id', __d('shop', 'Transaction #')),
			$this->Paginator->sort('ShopOrderStatus.name', __d('shop', 'Status')),
			$this->Paginator->sort('modified', __d('shop', 'Updated')) => array(
				'class' => 'date'
			),
			__d('shop', 'Actions')
		), false);

		foreach ($shopOrders as $shopOrder) { ?>
			<tr>
				<td><?php echo sprintf('#%s', $shopOrder['ShopOrder']['invoice_number']); ?>&nbsp;</td>
				<td><?php echo $shopOrder['ShopPaymentMethod']['name']; ?>&nbsp;</td>
				<td><?php echo $shopOrder['ShopShippingMethod']['name']; ?>&nbsp;</td>
				<td><?php echo $shopOrder['ShopOrder']['tracking_number']; ?>&nbsp;</td>
				<td><?php echo $shopOrder['InfinitasPaymentLog']['transaction_id']; ?>&nbsp;</td>
				<td><?php echo $shopOrder['ShopOrderStatus']['name']; ?>&nbsp;</td>
				<td><?php echo date('d-m-Y', strtotime($shopOrder['ShopOrder']['modified'])); ?>&nbsp;</td>
				<td>
					<?php
						echo $this->Html->link($this->Design->icon('edit'), array(
							'action' => 'invoice',
							$shopOrder['ShopOrder']['id']
						), array('escape' => false));
						echo $this->Html->link($this->Design->icon('retweet'), array(
							'action' => 'reorder',
							$shopOrder['ShopOrder']['id']
						), array('escape' => false));
					?>
				</td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->element('pagination/navigation');