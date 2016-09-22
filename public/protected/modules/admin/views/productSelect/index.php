<?php
/* @var $this ProductSelectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Selects',
);

$this->menu=array(
	array('label'=>'Create ProductSelect', 'url'=>array('create')),
	array('label'=>'Manage ProductSelect', 'url'=>array('admin')),
);
?>

<h1>Product Selects</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
