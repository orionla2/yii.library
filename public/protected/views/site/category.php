<?php

/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	"$model->category",
);
$this->menu[1]= $model;
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#product-select-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1>Category: <?php echo $model->category; ?></h1>
<?php if(isset($this->breadcrumbs)):?>
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->
<?php endif?>
<?php $this->widget('ext.customFilter.WidgetGridView', array(
    'id'=>'product-select-grid',
    'dataProvider'=>$model->search(),
    'filter' => $model,
    'itemsTagName' => 'div',
    'itemView' => '_products',
    'textLength' => 30,
    
    'controller' => $this,
    'menu' => 1,
    
    'columns'=>array(
        'p_id',
        'price',
        'full_name',
        'name',
        'year',
        'available',
        array(
            'class'=>'WidgetButtonColumn',
        ),
    ),
)); ?>

