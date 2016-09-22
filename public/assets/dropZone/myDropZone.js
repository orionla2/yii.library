$(document).ready(function() {
    onLoadPicturePrepare(getControllerName(window.location.pathname));
});
$(function(){
    var ul = $('#upload ul');

    $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {
           
            /*
            var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
                ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

            // Append the file name and file size
            tpl.find('p').text(data.files[0].name)
                         .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            tpl.find('input').knob();

            // Listen for clicks on the cancel icon
            tpl.find('span').click(function(){

                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }

                tpl.fadeOut(function(){
                    tpl.remove();
                });

            });
            */
            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
        },

        progress: function(e, data){

            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            $('.progress-bar').val(progress).change();

            if(progress == 100){
                
//                var txt = data.jqXHR.responseText;
  //              $('.img-add').attr('src', txt);
                //data.removeClass('working');
            } else {
            }
            
            a = 1;
        },

        fail:function(e, data){
            // Something has gone wrong!
            data.addClass('error');
        },
        
        done: function(res, r1, r2) {
            var $txt = r1.jqXHR.responseText;
            var controller = getControllerName(window.location.pathname);
            var obj = '#' + controller + 'Form_pictures';
            
            var $tape = $('.slider-add-tape');
            
            var $imgWrapper = $tape.find('.slider-add-etalon').clone();
            
            $imgWrapper.removeClass('slider-add-etalon').find('img').attr('src', $txt);
            formArr = jQuery.parseJSON($(obj).val());
            formArr[$txt] = $txt;
            formArr = JSON.stringify(formArr);
            $(obj).val(formArr);
            $($imgWrapper).click(function(){
                var path = $(this).find('img').attr('src');
                $('.slider-img-wrapper').find('img').attr('src',path);
            });
            var $close = $imgWrapper.find('div');
            $($close).click(function(){
                var $parent = $(this).parent();
                var path = $parent.find('img').attr('src');
                var controller = getControllerName(window.location.pathname);
                var obj = '#' + controller + 'Form_pictures';
                var formArr = jQuery.parseJSON($(obj).val());
                
                delete formArr[path];
                formArr = JSON.stringify(formArr);
                $(obj).val(formArr);
            
                $parent.remove();
                delImg(path);
                changeImg(path);
            });
            $imgWrapper.appendTo($tape);
            
            $('.img-add').attr('src',$txt);
            $('.slider-img-wrapper').css('background-image',$txt);
            
            //$('.img-add').attr('src', txt);
            
        }
    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }
    $('.slider-add-btn-left').click(function(){
        var curPos = parseInt($('.slider-add-tape').css('left'));
        if (curPos < 0 && curPos >= -parseInt($('.slider-add-tape').css('width'))) {
            $('.slider-add-tape').css('left',curPos + (60))
        }
    });
    $('.slider-add-btn-right').click(function(){
        var curPos = parseInt($('.slider-add-tape').css('left'));
        if (curPos <= 0 && curPos > -parseInt($('.slider-add-tape').css('width'))) {
            $('.slider-add-tape').css('left',curPos + (-60))
        }
    });
    $('.slider-add-img-wrapper').click(function(){
        //alert($(this).attr('class'));
    });
});
function delImg(path){
    var controller = getControllerName(window.location.pathname);
    $.ajax({
            url: '/admin/'+ controller +'/ajaxDelImg',
            type: 'POST',
            data: {
                filePath: path
            },
            async: true,
            complete: function (html) {
                //console.log('complete->' + html);
            },
            success: function (data) {
                //console.log('success->' + data);
            },
            error: function (data) {
                //console.log('error->' + data);
            }
        });
};
function changeImg (path){
    if (path == $('.slider-img-wrapper').find('img').attr('src')) {
        var newPath = $('.slider-add-tape div:last-child').find('img').attr('src');
        $('.slider-img-wrapper').find('img').attr('src',newPath);
    }
}
function onLoadPicturePrepare(controller){
    var $tape = $('.slider-add-tape');
    var obj = '#' + controller + 'Form_pictures';
    var myObj = {
        obj: obj
    }
    var $formArr = jQuery.parseJSON($(obj).val());
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
            var obj = myObj.obj;
            var $parent = $(this).parent();
            var path = '/' + $parent.find('img').attr('src').substr(1);

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
function getControllerName (path) {
    var arr = path.split('/');
    return arr[2];
}
function file_exists(path){
    $.ajax({
        url:path,
        type:'HEAD',
        error: function()
        {
            //file not exists
            return false;
        },
        success: function()
        {
            //file exists
            return true;
        }
    });
}
function srcPrepare (path) {
    var firstChar = path.substr(0,1);
    if (firstChar != '/') {
        var str = '/' + path;
    } else {
        var str = path;
    }
    return str;
}