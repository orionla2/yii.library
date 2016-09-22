<?php /* @var $this Controller */ ?>
<?php $this->beginContent('/layouts/main'); ?>
<div class="span-6 last">
	<div id="sidebar" >
        <div id="templatemo_content_left">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'<h1>CRUD Controllers</h1>',
                'htmlOptions' => array('class' => 'templatemo_content_left_section')
            ));
        ?>
            <div class="menu-top">
            <?php $this->widget('ext.customWidgets.JuiMenuWidget', array(
            'items' => $this->menu[0],
            'itemsCssContainer' => 'myMenu',
            )); 
            $this->endWidget();
            ?>
            </div>
            <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=>'<h1>Operations</h1>',
                    'htmlOptions' => array('class' => 'templatemo_content_left_section')
                ));
            ?>

            <?php ($this->menu[1]) ? $this->widget('ext.customWidgets.JuiMenuWidget', array(
            'items' => $this->menu[1],
            'itemsCssContainer' => 'myMenu1',
            )) : ''; 
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