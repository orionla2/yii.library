<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/templatemo_style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/jQueryUI/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/myStyle.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    
    <meta name="keywords" content="Book Store Template, Free CSS Template, CSS Website Layout, CSS, HTML" />
    <meta name="description" content="Book Store Template, Free CSS Template, Download CSS Website" />
    
    <?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/jQueryUI/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/custom/custom.js"></script>
</head>
<body>
<!--  Free CSS Templates from www.Ftemplate.ru -->
<div id="templatemo_container">
	<div id="templatemo_menu">
        <?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Admin', 'url'=>array('/admin'), 'visible'=>Yii::app()->user->hasAdminAccess()),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Registration', 'url'=>array('/site/Registration'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
    </div> <!-- end of menu -->
    
    <div id="templatemo_header">
                <span id="logo"><?php echo CHtml::encode(Yii::app()->name); ?>
                    <br><div id="slogan">
                        The biggest online book store
                    </div>
                </span>
    	<div id="templatemo_special_offers">
        	<p>
                <span>Please visit About section before serfing the site</span>
        	</p>
			<a href="http://yii.library/site/about" style="margin-left: 50px;">Read more...</a>
        </div>
        
        
        <div id="templatemo_new_books">
            <?php $arr = ProductSelect::getNewUpdates(4) ?>
        	<ul>
            <?php foreach($arr as $v): ?>
                <li><div class="ellipsis"><?php echo CHtml::link(CHtml::encode($v->name), array('view', 'id'=>$v->p_id)); ?></div></li>
            <?php endforeach; ?>
            </ul>
        </div>
        
    </div> <!-- end of header -->
    
    <div id="templatemo_content">
        <?php echo $content; ?>
        <div class="clear"></div>
    	<div class="cleaner_with_height">&nbsp;</div>
    </div> <!-- end of content -->
    
    <div id="templatemo_footer">
    
	       <a href="http://yii.library/site/index">Home</a> | <a href="http://yii.library/site/index">Search</a> | <a href="http://yii.library/site/index">Books</a> | <a href="#">New Releases</a> | <a href="#">FAQs</a> | <a href="/site/contact">Contact Us</a><br />
        Copyright © 2024 <a href="#"><strong>Orionla2</strong></a> | Designed by <a href="http://www.Ftemplate.ru" target="_parent" title="free css templates">Free CSS Templates</a>	</div> 
    <!-- end of footer -->
<!--  Free CSS Template www.Ftemplate.ru -->
</div> <!-- end of container -->
</body>
</html>
