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
				__d('shop', 'Icon') => array(
					'class' => 'medium'
				),
				$this->Paginator->sort('name', __d('shop', 'Displayed Name')),
				$this->Paginator->sort('infinitas_payment_method_id', __d('shop', 'Provider')),
				$this->Paginator->sort('total_minimum', __d('shop', 'Order Min')) => array(
					'class' => 'large'
				),
				$this->Paginator->sort('total_maximum', __d('shop', 'Order Max')) => array(
					'class' => 'large'
				),
				$this->Paginator->sort('ordering') => array(
					'class' => 'small'
				),
				__d('shop', 'Status') => array(
					'class' => 'medium'
				),
				$this->Paginator->sort('modified') => array(
					'class' => 'date'
				),
			)
		);

		foreach ($shopPaymentMethods as $shopPaymentMethod) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopPaymentMethod); ?>&nbsp;</td>
				<td>
					<?php 
						echo $this->Html->image($shopPaymentMethod['InfinitasPaymentMethod']['image_thumb']); 
					?>&nbsp;
				</td>
				<td><?php echo $this->Html->adminQuickLink($shopPaymentMethod['ShopPaymentMethod']); ?>&nbsp;</td>
				<td>
					<?php 
						echo $this->Html->link($shopPaymentMethod['InfinitasPaymentMethod']['name'], array(
							'plugin' => 'infinitas_payments',
							'controller' => 'infinitas_payment_methods',
							'action' => 'edit',
							$shopPaymentMethod['InfinitasPaymentMethod']['id']
						));
					?>&nbsp;
				</td>
				<td><?php echo $this->Shop->adminCurrency($shopPaymentMethod['ShopPaymentMethod']['total_minimum']); ?>&nbsp;</td>
				<td><?php echo $this->Shop->adminCurrency($shopPaymentMethod['ShopPaymentMethod']['total_maximum']); ?>&nbsp;</td>
				<td><?php echo $this->Shop->ordering($shopPaymentMethod['ShopPaymentMethod']['id'], $shopPaymentMethod['ShopPaymentMethod']['ordering']); ?></td>
				<td>
					<?php
						$data = array(
							'title_no' => __d('shop', 'Payment method disabled for shop only')
						);
						if (!$shopPaymentMethod['InfinitasPaymentMethod']['active']) {
							$data['title_no'] = __d('infinitas_payments', 'Payment provider is disabled globally');
						}
						$status = $shopPaymentMethod['InfinitasPaymentMethod']['active'] && $shopPaymentMethod['ShopPaymentMethod']['active'];
						echo $this->Infinitas->status($status, $data);
						if ($shopPaymentMethod['ShopPaymentMethod']['require_login']) {
							echo $this->Html->link($this->Design->icon('lock'), $this->here . '#', array(
								'title' => __d('shop', 'Account required for use'),
								'escape' => false
							));
						}
						if ($shopPaymentMethod['InfinitasPaymentMethod']['testing']) {
							echo $this->Html->link($this->Design->icon('bolt'), $this->here . '#', array(
								'title' => __d('infinitas_payments', 'Sandbox mode is active'),
								'escape' => false
							));
						}
					?>
				</td>
				<td><?php echo $this->Infinitas->date($shopPaymentMethod['ShopPaymentMethod']); ?></td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');