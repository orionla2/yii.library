<?php
/* @var $this ProductSelectController */
/* @var $model ProductSelect */

$this->breadcrumbs=array(
	'Product Selects'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductSelect', 'url'=>array('index')),
	array('label'=>'Manage ProductSelect', 'url'=>array('admin')),
);
?>

<h1>Create ProductSelect</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>