<?php
/* @var $this AuthorController */
/* @var $model Author */

$this->breadcrumbs=array(
	'Authors'=>array('index'),
	$model->name . ' ' . $model->surname,
);
$this->menu[0]=array(
	array('label'=>'Product item', 'url'=>array('/admin/product')),
	array('label'=>'Category', 'url'=>array('/admin/category')),
	array('label'=>'Author', 'url'=>array('/admin/author')),
	array('label'=>'Publisher', 'url'=>array('/admin/publisher')),
	array('label'=>'User', 'url'=>array('/admin/user'),'visible' => Yii::app()->user->isAdmin()),
);
$this->menu[1]=array(
	array('label'=>'List Author', 'url'=>array('index')),
	array('label'=>'Create Author', 'url'=>array('create')),
	array('label'=>'Update Author', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Author', 'url'=>array('admin')),
);
?>

<h1>Update Author <?php echo $model->name . ' ' . $model->surname; ?></h1>
<?php if(isset($this->breadcrumbs)):?>
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->
<?php endif?>
<br>
<?php $this->widget('ext.customWidgets.ItemViewWidget', array(
	'dataProvider'=>$dataProvider,
	'pictures'=>Author::model()->getAllPicturesByAuthor(),
	'itemView' => '_view',
    'itemsCssClass' => 'templatemo_content_right'
)); ?>
