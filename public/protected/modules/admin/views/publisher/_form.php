<?php
/* @var $this PublisherController */
/* @var $model Publisher */
/* @var $form CActiveForm */
?>

<div class="form">
    <div class="createProductForm">
    <table id='createProductForm'><tbody>
        <tr>
            <td rowspan="5"  class='span-5'>
                <div class="slider">
        
                    <div class="slider-img-wrapper">
                        <img class="img-add" src="<?php echo Yii::app()->request->baseUrl; ?>/images/storage/defaultLogo.jpg">
                        <div class="slider-img-drop">
                            <form id="upload" method="post" action="/admin/product/ajaxImg" enctype="multipart/form-data">
                                <div id="drop">
                                    Drop Here

                                    <a id='drop-link'>Browse</a>
                                    <input type="file" name="gfiles" multiple />
                                </div>
                                <div class="progress-bar">
                                    <!-- The file uploads will be shown here -->
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="slider-add">

                        <div class="slider-add-btn-left slider-add-btn"></div>    

                        <div class="slider-add-view slider-add-elm">



                            <div class="slider-add-tape slider-add-elm">

                               <div class="slider-add-img-wrapper slider-add-etalon">
                                   <div class="slider-add-img-close" style=""></div>
                                   <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/storage/defaultLogo.jpg" alt="Loading">
                               </div>

                            </div>    

                        </div>    

                        <div class="slider-add-btn-right slider-add-btn"></div>

                    </div>    

                </div> <!-- slider -->
            </td>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'publisher-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($model->publisher)); ?>
    <tr>
        <td class='span-5'>
            <div class="row">
                <?php echo $form->labelEx($model->publisher,'name'); ?>
                <?php echo $form->textField($model->publisher,'name',array('size'=>60,'maxlength'=>255,'name' => 'publisherForm[name]')); ?>
                <?php echo $form->error($model->publisher,'name'); ?>
            </div> 
        </td>
    </tr>
    <tr>
        <td class='span-5'>
            <div class="row">
                <?php echo $form->labelEx($model->publisher,'address'); ?>
                <?php echo $form->textField($model->publisher,'address',array('size'=>60,'maxlength'=>255,'name' => 'publisherForm[address]')); ?>
                <?php echo $form->error($model->publisher,'address'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model->publisher,'phone'); ?>
                <?php echo $form->textField($model->publisher,'phone',array('size'=>60,'maxlength'=>255,'name' => 'publisherForm[phone]')); ?>
                <?php echo $form->error($model->publisher,'phone'); ?>
            </div>
        </td>
    </tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr>
        <td colspan="2" class='span-5'>
            <div class="row">
                <?php echo $form->labelEx($model->publisher,'description'); ?>
                <?php $this->widget('application.extensions.ckeditor.CKEditor', array(
                    'model'=>$model->publisher,
                    'value' => $model->publisher->description,
                    'language'=>'ru', 
                    'editorTemplate'=>'full',
                    'name' => 'publisherForm[description]'

                    )); ?>
                <?php echo $form->error($model->publisher,'description'); ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2" class='span-5'>
            <div class="row buttons">
                 <?php echo $form->hiddenField($model->picture,'path', array('value' => (isset($model->itemPicture) ? $model->itemPicture : '{}'), 'name' => 'publisherForm[pictures]')); ?>
                <?php echo CHtml::submitButton($model->publisher->isNewRecord ? 'Create' : 'Save'); ?>
            </div>
        </td>
    </tr>
<?php $this->endWidget(); ?>
        </tbody></table>
	</div>
</div><!-- form -->