<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div >
    <?php //var_dump($items);?>
    <?php
    $var = $this->renderMenu($items,$itemsCssContainer);
    //$var = "<ul id=$itemsCssContainer><li>test1</li><li>test2</li></ul>";
    //$var = "test";
    //xdebug_break();
    echo $var;
    ?>
    <?php
    /*echo call_user_func(function() use ($items){
        foreach($items as $item){
            var_dump($item);
        }
    });*/
    ?>
</div>
<?php //$this->initJs($itemsCssContainer); 
Yii::app()->clientScript->registerScript('categoryClick', "$('.ui-menu-item a').click(function(){
    var obj = $(this); 
    var text = obj.html();
    $('#ProductSelect_category').val(text);
    $('#product-select-grid').yiiGridView('update', {
        data: $('#yw3').serialize()
    });
    });
    "
    );
?>

<script>
custom.menuHandler("#" + "<?php echo $itemsCssContainer; ?>");
</script>