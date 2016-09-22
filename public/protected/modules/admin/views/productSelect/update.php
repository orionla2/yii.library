<?php
/* @var $this ProductSelectController */
/* @var $model ProductSelect */

$this->breadcrumbs=array(
	'Product Selects'=>array('index'),
	$model->name=>array('view','id'=>$model->p_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductSelect', 'url'=>array('index')),
	array('label'=>'Create ProductSelect', 'url'=>array('create')),
	array('label'=>'View ProductSelect', 'url'=>array('view', 'id'=>$model->p_id)),
	array('label'=>'Manage ProductSelect', 'url'=>array('admin')),
);
?>

<h1>Update ProductSelect <?php echo $model->p_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>