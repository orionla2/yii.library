<?php
/* @var $this ProductSelectController */
/* @var $model ProductSelect */

$this->breadcrumbs=array(
	'Product Selects'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProductSelect', 'url'=>array('index')),
	array('label'=>'Create ProductSelect', 'url'=>array('create')),
	array('label'=>'Update ProductSelect', 'url'=>array('update', 'id'=>$model->p_id)),
	array('label'=>'Delete ProductSelect', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->p_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductSelect', 'url'=>array('admin')),
);
xdebug_break();
?>

<h1>View ProductSelect #<?php echo $model->p_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'p_id',
		'price',
		'full_name',
		'name',
		'year',
		'available',
		'isbn',
		'description',
		'category',
		'picture',
		'publisher',
	),
)); ?>
