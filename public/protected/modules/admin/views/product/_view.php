<?php
/* @var $this ProductController */
/* @var $data Product */
?>

<div class="view productFullInfo">
    <?php $this->widget('ext.customWidgets.ProductSliderWidget', array(
        'picturesArr' => $data->picture,
        'itemView' => 'productSlider'
    )); ?>
    
    
	<h2><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->p_id)); ?>
	</h2>
    <table class="span-13">
        <tr>
            <td class="span-6">
               <ul>
                    <li>
                        <b><?php echo CHtml::encode($data->getAttributeLabel('isbn')); ?>:</b>
                        <?php echo CHtml::encode($data->isbn); ?>
                    </li>
                    <li>
                        <b><?php echo CHtml::encode($data->getAttributeLabel('full_name')); ?>:</b>
                        <?php echo CHtml::encode($data->full_name); ?>
                    </li>
                    <li>
                        <b><?php echo CHtml::encode($data->getAttributeLabel('category')); ?>:</b>
                        <?php echo CHtml::encode($data->category); ?>
                    </li>
                </ul> 
            </td>
            <td class="span-5">
                <div class='price'><?php echo CHtml::encode($data->price); ?></div>
            </td>
        </tr>
                
    </table>
    <ul>
        <li>
            <b><?php echo CHtml::encode($data->getAttributeLabel('publisher')); ?>:</b>
            <?php echo CHtml::encode($data->publisher); ?>

        </li>
        <li>
            <b><?php echo CHtml::encode($data->getAttributeLabel('year')); ?>:</b>
            <?php echo CHtml::encode($data->year); ?>
        </li>
    </ul>
    <br>
	<?php echo CHtml::encode($data->description); ?>
	<br />
</div>