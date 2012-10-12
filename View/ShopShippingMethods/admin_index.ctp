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

$massActions = $this->Infinitas->massActionButtons(
	array(
		'add',
		'edit',
		'toggle',
		'copy',
		'delete',

		// other methods available
		// 'unlock',
	)
);

echo $this->Infinitas->adminIndexHead($filterOptions, $massActions);
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
					$this->Paginator->sort('shop_shipping_method_value_count', __d('shop', 'Tiers')) => array(
						'style' => 'width:50px;'
					),
					$this->Paginator->sort('active') => array(
						'style' => 'width:50px;'
					),
					$this->Paginator->sort('created') => array(
						'style' => 'width:75px;'
					),
				)
			);

			foreach ($shopShippingMethods as $shopShippingMethod) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><?php echo $this->Infinitas->massActionCheckBox($shopShippingMethod); ?>&nbsp;</td>
					<td><?php echo $this->Html->adminQuickLink($shopShippingMethod['ShopShippingMethod']); ?>&nbsp;</td>
					<td>
						<?php 
							if(!$shopShippingMethod['ShopShippingMethod']['shop_shipping_method_value_count']) {
								$shopShippingMethod['ShopShippingMethod']['shop_shipping_method_value_count'] = '-';
							}
							echo $this->Html->link(
								$shopShippingMethod['ShopShippingMethod']['shop_shipping_method_value_count'], array(
								'controller' => 'shop_shipping_method_values',
								'action' => 'index',
								'ShopShippingMethodValue.shop_shipping_method_id' => $shopShippingMethod['ShopShippingMethod']['id']
							)); 
						?>&nbsp;
					</td>
					<td><?php echo $this->Infinitas->status($shopShippingMethod['ShopShippingMethod']['active']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopShippingMethod['ShopShippingMethod']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>