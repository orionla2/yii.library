<?php
/* @var $this ProductController */
/* @var $data Product */
//var_dump($data);
?>

<div class="templatemo_product_box">

	<h1 class="ellipsis">
        <?php echo CHtml::link(CHtml::encode($data->name) . ' ' . CHtml::encode($data->surname), array('view', 'id'=>$data->id)); ?>
    </h1>
	<?php //echo CHtml::image(Yii::app()->request->baseUrl .DIRECTORY_SEPARATOR. $data->picture[0],$alt = 'image'); ?>
	<?php $arr = (array_key_exists($data->id, $pictures)) ? $pictures[$data->id] : array('/images/storage/defaultAuthor.gif');
        //var_dump($arr);
        $this->widget('ext.customWidgets.ProductSliderWidget', array(
        'picturesArr' => $arr,
        'itemView' => 'productSlider'
    ));  ?>
    <div class="product_info">
	<p><?php echo CHtml::encode($data->description) . CHtml::link('...Read More.', array('view', 'id'=>$data->id), array('class' => 'read_more')); ?></p>
	
    <div class="detail_button">
        <?php echo CHtml::link('Detail', array('view', 'id'=>$data->id)); ?>
    </div>
    <div class='cleaner'>&nbsp</div>
    
    </div>

</div>