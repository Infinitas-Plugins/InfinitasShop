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

$massActions = $this->Infinitas->massActionButtons(
	array(
		'add',
		'edit',
		'copy',
		'delete',
	)
);

echo $this->Infinitas->adminIndexHead($filterOptions, $massActions);
echo $this->Filter->alphabetFilter();
?>
<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<?php
			echo $this->Infinitas->adminTableHeader(
				array(
					$this->Form->checkbox('all') => array(
						'class' => 'first',
						'style' => 'width:25px;'
					),
					$this->Paginator->sort('name'),
					$this->Paginator->sort('shop_order_count', __d('shop', 'Orders')) => array(
						'style' => 'width:100px;'
					),
					$this->Paginator->sort('status') => array(
						'style' => 'width:100px;'
					),
					$this->Paginator->sort('modified') => array(
						'style' => 'width:100px;'
					),
				)
			);

			foreach ($shopOrderStatuses as $shopOrderStatus) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><?php echo $this->Infinitas->massActionCheckBox($shopOrderStatus); ?>&nbsp;</td>
					<td><?php echo $this->Html->adminQuickLink($shopOrderStatus['ShopOrderStatus']); ?>&nbsp;</td>
					<td>
						<?php
							if(!$shopOrderStatus['ShopOrderStatus']['shop_order_count']) {
								$shopOrderStatus['ShopOrderStatus']['shop_order_count'] = '-';
							}
							echo $this->Html->link($shopOrderStatus['ShopOrderStatus']['shop_order_count'], array(
								'controller' => 'shop_orders',
								'action' => 'index',
								'ShopOrder.shop_order_status_id' => $shopOrderStatus['ShopOrderStatus']['id']
							));
						?>&nbsp;
					</td>
					<td><?php echo $statuses[$shopOrderStatus['ShopOrderStatus']['status']]; ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopOrderStatus['ShopOrderStatus']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>