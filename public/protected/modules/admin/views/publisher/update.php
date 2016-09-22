<?php
/* @var $this PublisherController */
/* @var $model Publisher */

$this->breadcrumbs=array(
	'Publishers'=>array('index'),
	$model->publisher->name=>array('view','id'=>$model->publisher->id),
	'Update',
);
$this->menu[0]=array(
	array('label'=>'Product item', 'url'=>array('/admin/product')),
	array('label'=>'Category', 'url'=>array('/admin/category')),
	array('label'=>'Author', 'url'=>array('/admin/author')),
	array('label'=>'Publisher', 'url'=>array('/admin/publisher')),
	array('label'=>'User', 'url'=>array('/admin/user'),'visible' => Yii::app()->user->isAdmin()),
);
$this->menu[1]=array(
	array('label'=>'List Publisher', 'url'=>array('index')),
	array('label'=>'Create Publisher', 'url'=>array('create')),
	array('label'=>'View Publisher', 'url'=>array('view', 'id'=>$model->publisher->id)),
	array('label'=>'Manage Publisher', 'url'=>array('admin')),
);
?>

<h1>Update Publisher: <?php echo $model->publisher->name; ?></h1>
<?php if(isset($this->breadcrumbs)):?>
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->
<?php endif?>
<br>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>