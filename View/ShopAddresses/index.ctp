<?php
/**
 * Index view for addresses
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

echo $this->element('Shop.profile/header');
echo $this->Form->create(null, array('action' => 'mass'));
echo $this->Infinitas->massActionButtons(array(
	'add',
	'edit',
	'toggle',
	'delete'
));
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			$this->Form->checkbox('all') => array(
				'class' => 'first',
			),
			$this->Paginator->sort('name'),
			$this->Paginator->sort('address_1'),
			$this->Paginator->sort('address_2'),
			$this->Paginator->sort('state_id'),
			$this->Paginator->sort('country_id'),
			$this->Paginator->sort('post_code'),
			$this->Paginator->sort('modified', __d('shop', 'Updated')) => array(
				'style' => 'width:75px;'
			)
		));

		foreach ($shopAddresses as $shopAddress) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopAddress); ?>&nbsp;</td>
				<td><?php echo $this->Html->adminQuickLink($shopAddress['ShopAddress']); ?>&nbsp;</td>
				<td><?php echo $shopAddress['ShopAddress']['address_1']; ?>&nbsp;</td>
				<td><?php echo $shopAddress['ShopAddress']['address_2']; ?>&nbsp;</td>
				<td><?php echo $shopAddress['ShopAddress']['state_id']; ?>&nbsp;</td>
				<td><?php echo $shopAddress['ShopAddress']['country_id']; ?>&nbsp;</td>
				<td><?php echo $shopAddress['ShopAddress']['post_code']; ?>&nbsp;</td>
				<td><?php echo $this->Infinitas->date($shopAddress['ShopAddress']); ?>&nbsp;</td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/navigation');