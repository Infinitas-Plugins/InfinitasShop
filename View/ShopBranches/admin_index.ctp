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
echo $this->Filter->alphabetFilter('Contact.ContactBranch');
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			$this->Form->checkbox('all') => array(
				'class' => 'first'
			),
			$this->Paginator->sort('ContactBranch.name', __d('shop', 'Branch')),
			$this->Paginator->sort('manager_id'),
			$this->Paginator->sort('ordering') => array(
				'style' => 'width:75px'
			),
			$this->Paginator->sort('active') => array(
				'style' => 'width:75px'
			),
			$this->Paginator->sort('modified') => array(
				'style' => 'width:100px'
			)
		));

		foreach ($shopBranches as $shopBranch) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopBranch); ?>&nbsp;</td>
				<td>
					<?php
						echo $this->Shop->emailLink($shopBranch['ContactBranch']['email']);
						echo $this->Html->link($shopBranch['ContactBranch']['name'], array(
							'action' => 'edit',
							$shopBranch['ShopBranch']['id']
						));
					?>&nbsp;
				</td>
				<td>
					<?php
						echo $this->Shop->emailLink($shopBranch['Manager']['email']);
						echo $this->Html->link($shopBranch['Manager']['full_name'], array(
							'plugin' => 'users',
							'controller' => 'users',
							'action' => 'edit',
							$shopBranch['Manager']['id']
						));
					?>&nbsp;
				</td>
				<td>
					<?php
						echo $this->Infinitas->ordering(
							$shopBranch['ShopBranch']['id'],
							$shopBranch['ShopBranch']['ordering']
						);
					?>&nbsp;
				</td>
				<td><?php echo $this->Infinitas->status($shopBranch['ShopBranch']['active']); ?>&nbsp;</td>
				<td><?php echo $this->Infinitas->date($shopBranch['ShopBranch']); ?></td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');