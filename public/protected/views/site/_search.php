<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
    <div class="row">
        <?php echo $form->label($model,'price', array('style' => 'color:#cbc750; text-align: left')); ?>
        <br><span id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
            <?php echo Money::getPrice($minMax[0]); ?> - <?php echo Money::getPrice($minMax[1]); ?>
        </span><br>
        <?php
        $this->widget('zii.widgets.jui.CJuiSlider',array(
            'value'=>37,
            // additional javascript options for the slider plugin
            'options'=>array(
                'range' => true,
                'min'=>$minMax[0],
                'max'=>$minMax[1],
                'cssFile' => "jquery-ui.css",
                'themeUrl' => Yii::app()->request->baseUrl . "/assets",
                'theme' => "jQueryUI",
                'values' => array($minMax[0],$minMax[1]),
                'slide' => 'js:function( event, ui ) {
                                    $( "#amount" ).html( "$" + (ui.values[ 0 ] / 100) + " - $" + (ui.values[ 1 ] / 100) );
                                    $( "#ProductSelect_price" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
                                }',
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;',
            ),
        ));
        ?>
        <?php echo $form->hiddenField($model,'price'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'year',array('style' => 'color:#cbc750; text-align: left')); ?>
        <?php echo $form->textField($model,'year',array('class' => 'span-2', 'maxLength' => 4, 'style' => 'margin-right: 40px;')); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'full_name', array('style' => 'color:#cbc750; text-align: left')); ?>
        <?php echo $form->textField($model,'full_name',array('class' => 'span-5')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'name', array('style' => 'color:#cbc750; text-align: left')); ?>
        <?php echo $form->textField($model,'name',array('class' => 'span-5')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'isbn', array('style' => 'color:#cbc750; text-align: left')); ?>
        <?php echo $form->textField($model,'isbn',array('class' => 'span-5', 'maxLength' => 17)); ?>
    </div>
    
    <div class="row">
        <?php echo $form->hiddenField($model,'category'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'publisher', array('style' => 'color:#cbc750; text-align: left')); ?>
        <?php echo $form->textField($model,'publisher',array('class' => 'span-5')); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>
    
    
<?php $this->endWidget(); ?>

</div><!-- search-form -->