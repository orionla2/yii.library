<?php /* @var $this Controller */ ?>
<?php $this->beginContent('/layouts/main2'); ?>
<div class="span-6 last">
	<div id="sidebar" >
    <div id="templatemo_content_left">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'<h1>CRUD Controllers</h1>',
            'htmlOptions' => array('class' => 'templatemo_content_left_section')
		));
    ?>
    
    <?php
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu[0],
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>
    
    <?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'<h1>Operations</h1>',
            'htmlOptions' => array('class' => 'templatemo_content_left_section')
		));
    ?>
    
    <?php
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu[1],
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>
    </div>
	</div><!-- sidebar -->
</div>
<div class="span-17">
	<div id="templatemo_content_right">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>