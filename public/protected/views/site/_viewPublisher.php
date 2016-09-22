<?php
/* @var $this PublisherController */
/* @var $data Publisher */
?>

<div class="view productFullInfo">
    <?php $arr = (array_key_exists($data->id, $pictures)) ? $pictures[$data->id] : array('/images/storage/defaultLogo.jpg');
        //var_dump($arr);
        $this->widget('ext.customWidgets.ProductSliderWidget', array(
        'picturesArr' => $arr,
        'itemView' => 'productSlider'
    ));  ?>
    <script>
    custom.sliderReactivation();
    </script>
    <table class="span-13" style='margin-right: 30px;'>
        <tr>
            <td class="span-6">
               <ul>
                    <li>
                        <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
                        <?php echo CHtml::encode($data->name); ?>
                    </li>
                    <li>
                        <b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
                        <?php echo CHtml::encode($data->address); ?>
                    </li>
                    <li>
                        <b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
                        <?php echo CHtml::encode($data->phone); ?>
                    </li>
                </ul> 
            </td>
            <td class="span-5">
            </td>
        </tr>
                
    </table>
    <div style='display:block; width:100%'>
	<?php echo CHtml::encode($data->description); ?>
    </div>
	<br />
</div>
