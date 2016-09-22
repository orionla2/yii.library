<?php
/* @var $this AuthorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Authors',
);
$this->menu[0]=array(
	array('label'=>'Product item', 'url'=>array('/admin/product')),
	array('label'=>'Category', 'url'=>array('/admin/category')),
	array('label'=>'Author', 'url'=>array('/admin/author')),
	array('label'=>'Publisher', 'url'=>array('/admin/publisher')),
	array('label'=>'User', 'url'=>array('/admin/user'),'visible' => Yii::app()->user->isAdmin()),
);
$this->menu[1]=array(
	array('label'=>'Create Author', 'url'=>array('create')),
	array('label'=>'Manage Author', 'url'=>array('admin')),
);
?>

<h1>Authors</h1>
<?php if(isset($this->breadcrumbs)):?>
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->
<?php endif?>
<br>
<?php $this->widget('ext.customWidgets.ItemViewWidget', array(
	'dataProvider'=>$dataProvider,
	'pictures'=>Author::model()->getAllPicturesByAuthor(),
	'itemView' => '_items',
    'separator' => '<div class="cleaner_with_height"></div>',
    'itemsCssClass' => 'templatemo_content_right',
    'textLength' => 110,
)); ?>
