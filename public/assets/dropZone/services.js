$(document).ready(function() {
    /*sdfsdf*/
    
    var hash = window.location.hash;
    
    $('.services-menu').show().accordion({navigation: true});
    
    $('.services-items a').click(function() {
        services.router($(this).attr('href'));
    });

    $('.services-item-add').click(function() {
        services.addItemDialog();
    });

    
    $('.form-add-item-file').change(function() {
        var formData = new FormData($(".form-add-item")[0]);

        var formData = new FormData();
        
        formData.append()
        
        $.ajax({
            url: '/services/ajax',
            type: 'POST',
            processData: false,
            contentType: false,                        
            data:  formData,
            success: function(data) {
              $('.img-add').attr('src', data);
            }
        });
    });
    
    
    
    services.router(hash);
    onLoadPreparePic(getControllerName(window.location.pathname));
});


var services = {

    debug: false,
    typeId: 0,
    
    log: function(text) {
        if (this.debug) {
            console.log(text);
        }
    },
    
    addItemDialog: function() {
    
        var itemPoks = [];
        var typeId = this.TypeId;
        $.ajax({
            url: '/services/ajax',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {
                action: 'getPoks',
                typeId: typeId
            },
            
            success: function(data) {
                itemPoks = data;
            },
            error: function() {
                alert('Error getPoks');
            }
        });
        
        if (itemPoks.length == 0) {
            alert('List Pok Null');
            return false
        }
        
        
        var $itemPoks = $('.dialog-add .item-poks');
        $itemPoks.html('');
        
        for (var i = 0; i < itemPoks.length; i++) {
            $itemPoks.append(
                '<label>' + itemPoks[i]['title']+ ': </label> ' + 
                '<input class="item-pok" name="' + itemPoks[i]['pok']+ '"><br>'
            );
        }
        
        $('.dialog-add').dialog({
            title: 'Добавить',
            autoopen: false,
            width: 600,
            height: 450,
            buttons: {
                'Добавить': function() {
                    var $formAddItem = $('.form-add-item');
                    services.addItem(
                       $formAddItem.find('.type-id').val(),
                       $formAddItem.find('.title').val(),
                       $formAddItem.find('.img-add').attr('src'),
                       []
                    );
                    
                    $(this).dialog('close');
                },
                'Отмена': function() {
                    $(this).dialog('close');
                }
            },
            modal: true
        });
        
        $('.dialog-add').dialog('open');
        
    },
    
    addItem: function(typeId, title, img, poks) {
        
        $.ajax({
            url: '/services/ajax',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {
                action: 'addItem',
                typeId: typeId,
                title: title,
                img: img,
                poks: poks
            },
            
            success: function() {

                $("#items-list").trigger('reloadGrid');
                alert('Add item ok');
            },
            error: function() {
                
                alert('Add item Error');
            }
        });
    },

    router: function(actions) {

       var actions = actions.split('-');

        var res = false;
        
        if (typeof(actions) !== 'object' || actions.length !== 2) {
            res = false;
        } else {

            switch (actions[0]) {
                case '#items':
                    this.TypeId = $('.services-menu a[href="#items-' + actions[1] + '"]').attr('data-item-type-id');
                    services.viewData(this.TypeId);
                    break;
                case '#dict':
                    break;
            }
            
        }
        
    },
    
    viewData: function(type_id) {

        $('.services-list').show();

        $('#items-list').jqGrid('GridDestroy');

        $('.services-list').html('<table id="items-list"></table><div id="items-list-p"></div>');

        $("#items-list").jqGrid({
            url: '/services/ajax',
            mtype: 'POST',
            postData:{
                action: 'getItems',
                typeId: type_id
            },
            datatype: "json",
            colNames: ['№', 'Название'],
            colModel: [
                {name: 'id',index: 'id', width: 120, sortable: true, align: "right"},
                {name: 'title',index: 'title', width: 600, sortable: false, align: "left"}
            ],
            gridview: true,
            jsonReader: { repeatitems: true },
            beforeProcessing: function(data) {
                //tGetDataErrNoServer=data.errorNo;  
            },
            rowNum: 20,
            rowList: [10, 20, 50, 100, 500],
            pager: '#items-list-p',
            sortname: 'id',
            sortorder: 'asc',
            viewrecords: true,
            onSelectRow: function(id){
                    // обработка выбраной строки в таблице
            },
            gridComplete: function() {
                   /* if (tGetDataErrNoServer<0) {
                            $DialogListCarErr.find('p:first').text('Произошла ошибка при подготовке данных сервером (код ошибки:'+tGetDataErrNoServer+'). Обратитесь к администратору.');
                            $DialogListCarErr.dialog('open');
                    }*/
            },
            loadError: function(xhr,st,err) {
                            //tGetDataErrNoClient=-1002;
                            //$DialogListCarErr.find('p:first').text('Произошла ошибка при получении данных от сервера (код ошибки:'+tGetDataErrNoClient+'). Обратитесь к администратору.');
            },
            height: 400
        })
            .jqGrid('navGrid', '#items-list-p',{edit: true, add: true, del: true, search: true})
            /*.trigger('reloadGrid')*/;


        $('#items-list').jqGrid('filterToolbar',{stringResult: true, searchOnEnter : true});
        
        gridResize('#items-list');

    }    
};


$(window).bind('resize', function() {
    
    gridResize('#items-list');
    
}).trigger('resize');


function gridResize(idGrid) {
    
    if ($grid = $(idGrid + ':visible')) {
        $grid.each(function(index) {
            $gridId = $(this).attr('id');
            $gridParentWidth = $('#gbox_' + $gridId).parent().width();
            $('#' + $gridId).setGridWidth($gridParentWidth - 10);
        });
    }
}
function onLoadPreparePic(controller){
    var $tape = $('.slider-add-tape');
    var obj = '#' + controller + 'Form_pictures';
    var $formArr = $(obj).val();
    $.each($formArr, function($k,$val){
        if(file_exists($val)){
            var $v = srcPrepare($val);
        } else {
            var $v = srcPrepare($k);
        }
        var $imgWrapper = $tape.find('.slider-add-etalon').clone();
        $imgWrapper.removeClass('slider-add-etalon').find('img').attr('src', $v);
        
        $($imgWrapper).click(function(){
            var path = $(this).find('img').attr('src');
            $('.slider-img-wrapper').find('img').attr('src',path);
        });
        var $close = $imgWrapper.find('div');
        $($close).click(function(){
            var $parent = $(this).parent();
            var path = $parent.find('img').attr('src').substr(1);

            var formArr = jQuery.parseJSON($(obj).val());
            delete formArr[path];
            formArr = JSON.stringify(formArr);
            $(obj).val(formArr);

            $parent.remove();
            delImg($parent.find('img').attr('src'));
            changeImg($parent.find('img').attr('src'));
        });
        $imgWrapper.appendTo($tape);

        $('.img-add').attr('src',$v);
        $('.slider-img-wrapper').css('background-image',$v);
    });
}