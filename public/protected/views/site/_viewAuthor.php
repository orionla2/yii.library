<?php
/* @var $this SiteController */
/* @var $data Author */
?>

<div class="view productFullInfo">
    <?php $arr = (array_key_exists($data->id, $pictures)) ? $pictures[$data->id] : array('/images/storage/defaultAuthor.gif');
        //var_dump($arr);
        $this->widget('ext.customWidgets.ProductSliderWidget', array(
        'picturesArr' => $arr,
        'itemView' => 'productSlider'
    ));  ?>
    <script>
    custom.sliderReactivation();
    </script>
    <table class="span-13"  style='margin-right: 30px;'>
        <tr>
            <td class="span-6">
               <ul>
                    <li>
                        <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
                        <?php echo CHtml::encode($data->name); ?>
                    </li>
                    <li>
                        <b><?php echo CHtml::encode($data->getAttributeLabel('surname')); ?>:</b>
                        <?php echo CHtml::encode($data->surname); ?>
                    </li>
                </ul> 
            </td>
            <td class="span-5">
            </td>
        </tr>
                
    </table>
	<?php echo CHtml::encode($data->description); ?>
	<br />
</div>