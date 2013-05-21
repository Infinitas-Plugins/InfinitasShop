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
					$this->Paginator->sort('image'),
					$this->Paginator->sort('ShopAttributeGroup.name', 'ShopAttributeGroup'),
					$this->Paginator->sort('created') => array(
						'style' => 'width:75px;'
					),
					$this->Paginator->sort('modified') => array(
						'style' => 'width:75px;'
					),
				)
			);

			foreach ($shopAttributes as $shopAttribute) { ?>
				<tr>
					<td><?php echo $this->Infinitas->massActionCheckBox($shopAttribute); ?>&nbsp;</td>
					<td title="<?php echo $shopAttribute['ShopAttribute']['slug']; ?>"><?php echo $this->Html->adminQuickLink($shopAttribute['ShopAttribute']); ?>&nbsp;</td>
					<td><?php echo $shopAttribute['ShopAttribute']['image']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($shopAttribute['ShopAttributeGroup']['name'], array('controller' => 'shop_attribute_groups', 'action' => 'view', $shopAttribute['ShopAttributeGroup']['id'])); ?>
					</td>
					<td><?php echo $this->Infinitas->date($shopAttribute['ShopAttribute']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopAttribute['ShopAttribute']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');