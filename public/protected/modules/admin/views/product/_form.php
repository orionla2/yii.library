<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>
<div class="form">
    <div class="createProductForm">
    <table id='createProductForm'><tbody>
        <tr>
            <td rowspan="5"  class='span-5'>
                <div class="slider">
        
                    <div class="slider-img-wrapper">
                        <img class="img-add" src="<?php echo Yii::app()->request->baseUrl; ?>/images/storage/default.jpg">
                        <div class="slider-img-drop">
                            <form id="upload" method="post" action="/admin/product/ajaxImg" enctype="multipart/form-data">
                                <div id="drop">
                                    <a id='drop-link'>Browse</a>
                                    <input type="file" name="gfiles" multiple />
                                    <span>Drop Here</span>
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
                                   <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/storage/default.jpg" alt="Loading">
                               </div>

                            </div>    

                        </div>    

                        <div class="slider-add-btn-right slider-add-btn"></div>

                    </div>    

                </div> <!-- slider -->
            </td>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); 
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($model->book,$model->product)); ?>
    

                    
                    
                    
                
                <td class='span-5'>
                    <?php echo $form->labelEx($model->book,'name'); ?>
                    <?php echo $form->textField($model->book,'name',array('name' => 'productForm[name]')); ?>
                    <?php echo $form->error($model->book,'name'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model->book,'isbn'); ?>
                    <?php echo $form->textField($model->book,'isbn',array('name' => 'productForm[isbn]')); ?>
                    <?php echo $form->error($model->book,'isbn'); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $form->labelEx($model->product,'price'); ?>
                    <?php echo $form->textField($model->product,'price',array('name' => 'productForm[price]')); ?>
                    <?php echo $form->error($model->product,'price'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model->book,'year'); ?>
                    <?php echo $form->textField($model->book,'year',array('name' => 'productForm[year]')); ?>
                    <?php echo $form->error($model->book,'year'); ?>
                </td>
                <td class='span-4'>
                    <?php echo $form->labelEx($model->publisher,'name'); ?>
                    <?php echo $form->dropDownList(
                        $model->publisher,
                        'name',
                        Publisher::all(),
                        array(
                            'class' => 'span-4',
                            'name' => 'productForm[publisher]',
                            'options' => isset($model->productPublisher) ? $model->productPublisher : ''
                            )); ?>
                    <?php echo $form->error($model->publisher,'publisher'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model->author,'name'); ?>
                    <div id='authorsList'></div>
                </td>
                <td class='span-4'>
                    <?php echo $form->dropDownList(
                        $model->author,
                        'name',
                        Author::all(),
                        array(
                            'multiple' => 'multiple',
                            'class' => 'span-4',
                            'name' => 'productForm[author]',
                            'options' => isset($model->productAuthor) ? $model->productAuthor : ''
                        )); ?>
                    <?php echo $form->error($model->author,'name'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model->category,'name'); ?>
                    <div id='categoriesList'></div>
                </td>
                <td class='span-4'>
                    <?php echo $form->dropDownList(
                        $model->category,
                        'name',
                        Category::all(),
                        array(
                            'multiple' => 'multiple',
                            'class' => 'span-4',
                            'name' => 'productForm[category]',
                            'options' => isset($model->productCategory) ? $model->productCategory : ''
                            )); ?>
                    <?php echo $form->error($model->category,'name'); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php echo $form->labelEx($model->book,'description'); ?>
                    <?php $this->widget('application.extensions.ckeditor.CKEditor', array(
                        'model'=>$model->book,
                        'value' => $model->book->description,
                        'language'=>'ru', 
                        'editorTemplate'=>'full',
                        'name' => 'productForm[description]'
                        
                        )); ?>
                    <?php echo $form->error($model->book,'description'); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $form->labelEx($model->book,'available'); ?>
                    <?php echo $form->checkBox($model->book,'available',array('name' => 'productForm[available]')); ?>
                    <?php echo $form->error($model->book,'available'); ?>
                </td>
                <td>
                    <div class="row buttons">
                        <?php echo $form->hiddenField($model->picture,'path', array('value' => (isset($model->productPicture) ? $model->productPicture : '{}'), 'name' => 'productForm[pictures]')); ?>
                        <?php echo CHtml::submitButton($model->book->isNewRecord ? 'Create' : 'Save'); ?>
                    </div>
                </td>
            </tr>
        

	

<?php
$this->endWidget(); 
?>
        </tbody></table>
	</div>
</div><!-- form -->