<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->name,
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
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Update Product', 'url'=>array('update', 'id'=>$model->p_id)),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1><?php echo "$model->name (ISBN #$model->isbn)"; ?></h1>
<?php if(isset($this->breadcrumbs)):?>
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->
<?php endif?>
    <br>
<?php $this->widget('ext.customWidgets.ProductViewWidget', array(
	'dataProvider'=>$dataProvider,
	'itemView' => '_view',
    'itemsCssClass' => 'templatemo_content_right'
)); ?>