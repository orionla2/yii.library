<?php
/* @var $this ProductController */
/* @var $data Product */
//var_dump($data);
?>

<div class="templatemo_product_box">

	<h1 class="ellipsis">
        <?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->p_id)); ?>
    </h1>
	<?php //echo CHtml::image(Yii::app()->request->baseUrl .DIRECTORY_SEPARATOR. $data->picture[0],$alt = 'image'); ?>
	<?php $this->widget('ext.customWidgets.ProductSliderWidget', array(
        'picturesArr' => $data->picture,
        'itemView' => 'productSlider'
    )); ?>
    <div class="product_info">
	<p><?php echo CHtml::encode($data->description) . CHtml::link('...Read More.', array('view', 'id'=>$data->p_id), array('class' => 'read_more')); ?></p>
	
    <?php //echo CHtml::encode($data->getAttributeLabel('isbn')); ?>
	
    
    <h3><?php echo CHtml::encode($data->price); ?></h3>
    <div class="buy_now_button">
        <?php echo CHtml::link('Buy Now', '#'); ?>
    </div>
    <div class="detail_button">
        <?php echo CHtml::link('Detail', array('view', 'id'=>$data->p_id)); ?>
    </div>
    <div class='cleaner'>&nbsp</div>
    
    </div>

</div>