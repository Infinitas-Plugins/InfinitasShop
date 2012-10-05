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

    echo $this->Form->create('Spotlight', array('url' => array('action' => 'mass')));

    $massActions = $this->Infinitas->massActionButtons(
        array(
            'add',
            'edit',
            'copy',
            'toggle',
            'move',
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
                    __d('shop', 'Image') => array(
                        'style' => 'width:100px;'
                    ),
                    $this->Paginator->sort('Product.name', __d('shop', 'Product')),
                    $this->Paginator->sort('Product.price', __d('shop', 'Price')),
                    $this->Paginator->sort('start_date') => array(
                        'style' => 'width:75px;'
                    ),
                    $this->Paginator->sort('end_date') => array(
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

            foreach ($spotlights as $spotlight) {
                ?>
                	<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
                        <td><?php echo $this->Infinitas->massActionCheckBox($spotlight); ?>&nbsp;</td>
                        <td>
							<?php echo $this->Shop->getImage($spotlight); ?>&nbsp;
						</td>
                		<td>
                			<?php echo $this->Html->link($spotlight['Product']['name'], array('action' => 'edit', $spotlight['Spotlight']['id'])); ?>&nbsp;
                		</td>
						<td title="<?php echo $this->Shop->breakdown($spotlight['Product'], $spotlight['Product']['Special']); ?>">
							<?php echo $this->Shop->calculateSpecial($spotlight['Product'], $spotlight['Product']['Special']); ?>&nbsp;
						</td>
						<td>
							<?php echo $this->Infinitas->date($spotlight['Spotlight']['start_date'].' '.$spotlight['Spotlight']['start_time']); ?>&nbsp;
						</td>
						<td>
							<?php echo $this->Infinitas->date($spotlight['Spotlight']['end_date'].' '.$spotlight['Spotlight']['end_time']); ?>&nbsp;
						</td>
						<td>
							<?php echo $this->Infinitas->date($spotlight['Spotlight']['modified']); ?>&nbsp;
						</td>
                		<td>
                			<?php echo $this->Infinitas->status($spotlight['Spotlight']['active']); ?>&nbsp;
                		</td>
                	</tr>
                <?php
            }
        ?>
    </table>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>