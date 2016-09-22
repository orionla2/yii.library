<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'p_id'); ?>
        <?php echo $form->textField($model,'p_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'price'); ?>
        <?php echo $form->textField($model,'price'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'full_name'); ?>
        <?php echo $form->textField($model,'full_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'name'); ?>
        <?php echo $form->textField($model,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'year'); ?>
        <?php echo $form->textField($model,'year'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'available'); ?>
        <?php echo $form->textField($model,'available'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'isbn'); ?>
        <?php echo $form->textField($model,'isbn'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'category'); ?>
        <?php echo $form->textField($model,'category'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'publisher'); ?>
        <?php echo $form->textField($model,'publisher'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->