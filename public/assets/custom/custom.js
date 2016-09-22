$(document).ready(function() {
    form.tagsDecorator('#productForm_author','#authorsList');
    form.tagsDecorator('#productForm_category','#categoriesList');
    $('.productSlider-wrapper-tape').click(function(){
        var $this = $(this);
        $this.css({"width":($(this).find('div').length * 100) + 'px'});
        var $length = parseInt($this.css("width"));
        var $left = parseInt($this.css("left"));
        var $shift = $left + 100;
        if ($shift >= $length) {
            $this.css({"left":"0px"});
        } else {
            $this.css({"left":-$shift + "px"});
        }
    });
    $( "#top-menu" ).menu();
    $( "#menu" ).menu();
});

var form = {
    tagsDecorator: function(select,container){
        $(container).empty();
        $(select + ' option:selected').each(function(){
            var myDiv = document.createElement('div');
            $(myDiv).addClass('itemBg');
            $(myDiv).html($(this).text()).appendTo(container);
        });
        $(select).change(function(){
            $(container).empty();
            $(select + ' option:selected').each(function(){
                var myDiv = document.createElement('div');
                $(myDiv).addClass('itemBg');
                $(myDiv).html($(this).text()).appendTo(container);
            });
        });
    }
}

var custom = {
    menuHandler: function(id){
        $obj = $(id);
        $($obj).menu({
            icons: { submenu: "ui-icon-carat-1-e"},
            position: { my: "right top", at: "right+187 top+0"}
        });
    },
    sliderReactivation: function() {
        $('.productSlider-wrapper-tape').click(function(){
            var $this = $(this);
            $this.css({"width":($(this).find('div').length * 100) + 'px'});
            var $length = parseInt($this.css("width"));
            var $left = parseInt($this.css("left"));
            var $shift = $left + 100;
            if ($shift >= $length) {
                $this.css({"left":"0px"});
            } else {
                $this.css({"left":-$shift + "px"});
            }
        });
    },
    test: function(){
        alert('contact');
    }
}