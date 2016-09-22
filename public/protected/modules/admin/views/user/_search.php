<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
	</div>
    
	<div class="row">
		<?php echo $form->label($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role',array('' => '', 3 => 'Admin' , 2 => 'Moderator' , 1 => 'User')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>20,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ban'); ?>
		<?php echo $form->dropDownList($model,'ban',array('' => '', 0 => 'No' , 1 => 'Yes')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->