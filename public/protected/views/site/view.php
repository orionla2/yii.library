<?php

/* @var $this ProductController */
/* @var $model SelectProduct */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	"Details: Book(#$id)",
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
<h1>Details</h1>
<?php if(isset($this->breadcrumbs)):?>
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->
<?php endif?>
<?php $this->widget('ext.customWidgets.ProductViewWidget', array(
	'dataProvider'=>$dataProvider,
	'itemView' => '_view',
    'itemsCssClass' => 'templatemo_content_right'
)); ?>


