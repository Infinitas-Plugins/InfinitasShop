<?php
    /**
     * Comment Template.
     *
     * @todo -c Implement .this needs to be sorted out.
     *
     * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @filesource
     * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     * @link          http://infinitas-cms.org
     * @package       sort
     * @subpackage    sort.comments
     * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
     * @since         0.5a
     */

    echo $this->Form->create(false, array('url' => array('action' => 'mass')));

    $massActions = $this->Infinitas->massActionButtons(
        array(
            'add',
            'edit',
            'copy',
            'toggle',
            'delete'
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
                    $this->Paginator->sort('symbol') => array(
                        'style' => 'width:50px;'
                    ),
                    $this->Paginator->sort('product_count', __d('shop', 'Products')) => array(
                        'style' => 'width:75px;'
                    ),
                    $this->Paginator->sort('modified') => array(
                        'style' => 'width:75px;'
                    ),
                    $this->Paginator->sort('active') => array(
                        'style' => 'width:50px;'
                    )
                )
            );

            foreach ($units as $unit) {
                ?>
                	<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
                        <td><?php echo $this->Infinitas->massActionCheckBox($unit); ?>&nbsp;</td>
                		<td>
                			<?php echo $this->Html->link($unit['ShopUnit']['name'], array('action' => 'edit', $unit['ShopUnit']['id']), array('title' => __d('shop', 'Description').' :: '.$unit['ShopUnit']['description'])); ?>&nbsp;
                		</td>
						<td>
							<?php echo $unit['ShopUnit']['symbol']; ?>
						</td>
						<td>
							<?php echo $unit['ShopUnit']['product_count']; ?>
						</td>
						<td>
							<?php echo $this->Infinitas->date($unit['ShopUnit']['modified']); ?>
						</td>
                		<td>
                			<?php echo $this->Infinitas->status($unit['ShopUnit']['active']); ?>&nbsp;
                		</td>
                	</tr>
                <?php
            }
        ?>
    </table>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>