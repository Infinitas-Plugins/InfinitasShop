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
	'delete',

echo ));
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
					$this->Paginator->sort('ordering'),
					$this->Paginator->sort('debug'),
					$this->Paginator->sort('total_minimum'),
					$this->Paginator->sort('total_maximum'),
					$this->Paginator->sort('require_login'),
					$this->Paginator->sort('infinitas_payment_method_id'),
					$this->Paginator->sort('active') => array(
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

			foreach ($shopPaymentMethods as $shopPaymentMethod) { ?>
				<tr>
					<td><?php echo $this->Infinitas->massActionCheckBox($shopPaymentMethod); ?>&nbsp;</td>
					<td><?php echo $this->Html->adminQuickLink($shopPaymentMethod['ShopPaymentMethod']); ?>&nbsp;</td>
					<td><?php echo $this->Shop->ordering($shopPaymentMethod['ShopPaymentMethod']['id'], $shopPaymentMethod['ShopPaymentMethod']['ordering']); ?>&nbsp;</td>
					<td><?php echo $shopPaymentMethod['ShopPaymentMethod']['debug']; ?>&nbsp;</td>
					<td><?php echo $shopPaymentMethod['ShopPaymentMethod']['total_minimum']; ?>&nbsp;</td>
					<td><?php echo $shopPaymentMethod['ShopPaymentMethod']['total_maximum']; ?>&nbsp;</td>
					<td><?php echo $shopPaymentMethod['ShopPaymentMethod']['require_login']; ?>&nbsp;</td>
					<td><?php echo $shopPaymentMethod['ShopPaymentMethod']['infinitas_payment_method_id']; ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->status($shopPaymentMethod['ShopPaymentMethod']['active']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopPaymentMethod['ShopPaymentMethod']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopPaymentMethod['ShopPaymentMethod']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');