<div class="productSlider">
    <div class="productSlider-wrapper-tape">
        <?php
            foreach ($pictureArr as $k => $data) {
                echo "<div class='productSlider-wrapper-tape-image'>";
                echo CHtml::image(Yii::app()->request->baseUrl .DIRECTORY_SEPARATOR. substr($data,1),$alt = "image");  
                echo '</div>';
            }
        ?>
    </div>
</div>


