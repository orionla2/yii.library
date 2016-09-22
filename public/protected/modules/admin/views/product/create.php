<?php
/* @var $this ProductController */
/* @var $model Product */
$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Create',
);
$this->menu[0]=array(
	array('label'=>'Product item', 'url'=>array('/admin/product')),
	array('label'=>'Category', 'url'=>array('/admin/category')),
	array('label'=>'Author', 'url'=>array('/admin/author')),
	array('label'=>'Publisher', 'url'=>array('/admin/publisher')),
	array('label'=>'User', 'url'=>array('/admin/user'),'visible' => Yii::app()->user->isAdmin()),
);
$this->menu[1]=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>Create Product</h1>
<?php if(isset($this->breadcrumbs)):?>
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->
<?php endif?>
    <br>
<?php if(Yii::app()->user->hasFlash('create')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('create'); ?>
</div>

<?php endif; ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>