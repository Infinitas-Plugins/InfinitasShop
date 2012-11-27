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
		echo $this->Infinitas->adminTableHeader(array(
			$this->Form->checkbox('all') => array(
				'class' => 'first'
			),
			$this->Paginator->sort('name'),
			$this->Paginator->sort('shop_option_value_count', 'Options'),
			$this->Paginator->sort('required') => array(
				'style' => 'width:50px;'
			),
			$this->Paginator->sort('modified') => array(
				'style' => 'width:100px;'
			),
		));

		foreach ($shopOptions as $shopOption) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopOption); ?>&nbsp;</td>
				<td><?php echo $this->Html->adminQuickLink($shopOption['ShopOption']); ?>&nbsp;</td>
				<td><?php echo $this->Design->count($shopOption['ShopOption']['shop_option_value_count']); ?>&nbsp;</td>
				<td>
					<?php
						echo $this->Infinitas->status($shopOption['ShopOption']['required'], array(
							'title_yes' => __d('shop', 'Required :: This option requres a value to be selected'),
							'title_no' => __d('shop', 'Required :: This option does not requre a value to be selected'),
						));
					?>&nbsp;
				</td>
				<td><?php echo $this->Infinitas->date($shopOption['ShopOption']); ?></td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');