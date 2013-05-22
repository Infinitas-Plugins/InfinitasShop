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
					$this->Paginator->sort('User.username', 'User'),
					$this->Paginator->sort('name'),
					$this->Paginator->sort('address_1'),
					$this->Paginator->sort('address_2'),
					$this->Paginator->sort('state_id'),
					$this->Paginator->sort('country_id'),
					$this->Paginator->sort('post_code'),
					$this->Paginator->sort('created') => array(
						'style' => 'width:75px;'
					),
					$this->Paginator->sort('modified') => array(
						'style' => 'width:75px;'
					),
				)
			);

			foreach ($shopAddresses as $shopAddress) { ?>
				<tr>
					<td><?php echo $this->Infinitas->massActionCheckBox($shopAddress); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($shopAddress['User']['username'], array('controller' => 'users', 'action' => 'view', $shopAddress['User']['id'])); ?>
					</td>
					<td><?php echo $this->Html->adminQuickLink($shopAddress['ShopAddress']); ?>&nbsp;</td>
					<td><?php echo $shopAddress['ShopAddress']['address_1']; ?>&nbsp;</td>
					<td><?php echo $shopAddress['ShopAddress']['address_2']; ?>&nbsp;</td>
					<td><?php echo $shopAddress['ShopAddress']['state_id']; ?>&nbsp;</td>
					<td><?php echo $shopAddress['ShopAddress']['country_id']; ?>&nbsp;</td>
					<td><?php echo $shopAddress['ShopAddress']['post_code']; ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopAddress['ShopAddress']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopAddress['ShopAddress']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');