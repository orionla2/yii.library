<?php
/* @var $this ProductSelectController */
/* @var $model ProductSelect */

$this->breadcrumbs=array(
	'Product Selects'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProductSelect', 'url'=>array('index')),
	array('label'=>'Create ProductSelect', 'url'=>array('create')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    consolelog('mark1');
	return false;
});
$('.search-form form').submit(function(){
	$('#product-select-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
    consolelog('mark2');
	return false;
});
");
?>

<h1>Manage Product Selects</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-select-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'p_id',
		'price',
		'full_name',
		'name',
		'year',
		'available',
		/*
		'isbn',
		'description',
		'category',
		'picture',
		'publisher',
		*/
		array(
			'class'=>'CButtonColumn',
            'deleteButtonOptions' => array('style' => 'display:none;')
		),
	),
)); ?>
