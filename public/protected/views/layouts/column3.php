<?php /* @var $this Controller */ ?>
<?php $this->beginContent('/layouts/main'); ?>
<div class="span-6 last">
	<div id="sidebar" >
    <div id="templatemo_content_left">
	<?php
        $this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'<h1>Categories</h1>',
            'htmlOptions' => array('class' => 'templatemo_content_left_section')
		));
    ?>
    <div class="menu-top">
    <?php $this->widget('ext.customWidgets.JuiMenuWidget', array(
    'items' => Category::model()->findAll(),
    'model' => array(
        'id' => 'id',
        'parent_id' => 'parent_id',
        'name' => 'name',
        'start_id' => 1,
        'request' => '/site/category/name/'
    ),
    'itemsCssContainer' => 'myMenu',
    )); 
        $this->endWidget();
    ?>
    </div>
    
    </div>
	</div><!-- sidebar -->
</div>
<div class="span-17">
	<div id="templatemo_content_right">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>