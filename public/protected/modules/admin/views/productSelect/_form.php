<?php
/* @var $this ProductSelectController */
/* @var $model ProductSelect */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-select-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'p_id'); ?>
		<?php echo $form->textField($model,'p_id'); ?>
		<?php echo $form->error($model,'p_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'full_name'); ?>
		<?php echo $form->textArea($model,'full_name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'full_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'year'); ?>
		<?php echo $form->textField($model,'year'); ?>
		<?php echo $form->error($model,'year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'available'); ?>
		<?php echo $form->textField($model,'available'); ?>
		<?php echo $form->error($model,'available'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isbn'); ?>
		<?php echo $form->textField($model,'isbn',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'isbn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->textArea($model,'category',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'picture'); ?>
		<?php echo $form->textArea($model,'picture',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'picture'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'publisher'); ?>
		<?php echo $form->textField($model,'publisher',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'publisher'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->