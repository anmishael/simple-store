/**
 * User: mikel
 * Date: 21.11.12
 * Time: 14:53
 * To change this template use File | Settings | File Templates.
 */
(function( $ ) {
    var methods = {
            hideBoxDialog: function() {
                $('#my-box-back').hide();
                $('#my-box').hide();
                return false;
            },
            showBoxDialog: function() {
                $('#my-box-back').show();
                $('#my-box').show();
            },
            loadImages: function(elname,elindex,destination) {
                this.clearBoxDialog();
                var i=0;
                $(elname).each(function() {
                    var el = $(this);
                    var img = $('<img />');
                    i=0;
                    img.bind('load', function() {
                        i++;
                        if($(destination+' img').length == i) {
                            methods['resize'](elindex);
                        }
                    });
                    $(destination).append(img);
                    img.attr('src', el.attr('href'));
                    img.hide();
                });
            },
            loadThumbs: function(elname,elindex,destination) {
                this.clearThumbsDialog();
                var dest = $('<ul></ul>');
                $(destination).append(dest);
                var i=0;
                $(elname).each(function() {
                    var el = $(this);
                    var img = $('<img />');
                    i=0;
                    img.bind('load', function() {
                        i++;
                        if($(destination+' img').length == i) {
                            methods['bindthumbs'](destination);
                        }
                    });
                    var li = $('<li></li>');
                    var a = $('<a href="javascript:;"></a>');
                    $(dest).append(li.append(a.append(img)));
                    img.attr('src', el.find('img').attr('src'));
//                    img.hide();
                });
            },
            bindthumbs: function(destination) {
                $(destination).show();
                $(destination+' a').unbind('click').bind('click', function() {
                    $('#my-box .image-block img').hide();
                    methods['resize']($('#my-box .image-block img').eq($(this).parent().index()).index());
                });
            },
            resize: function(elindex) {
                var img = $('#my-box .image-block img').eq(elindex);
                var width = img.width();
                var height = img.height();
                var ratio_wh = width/height;
                if(width>$(window).width()*0.5) {
                    width = $(window).width()*0.5;
                    height = width/ratio_wh;
                }
                if(height>$(window).height()*0.5) {
                    height = $(window).height()*0.5;
                    width = height*ratio_wh;
                }
                img.attr('width', parseInt(width));
                img.attr('height', parseInt(height));
                $('#my-box').animate({left:parseInt(($(window).width()-width+40)/2)+'px'}, 500);
                $('#my-box .image-block').animate({height:parseInt(height)+'px',width:parseInt(width)+'px',left:parseInt(($(window).width()-width)/2)+'px'}, 500, function() {
//                    methods['alignbox']();
                    $('#my-box .image-block img').eq(elindex).css({opacity:'0.0'}).show().animate({opacity:'1.0'},500, function() {
                        methods['showarrows'](elindex);
                    });
                });
            },
            alignbox: function() {
                $('#my-box').animate({left:parseInt(($(window).width()-$('#my-box').width())/2)+'px'}, 500);
            },
            showarrows: function(elindex) {
                $('#my-box .arrow').css({height: parseInt($('#my-box .image-block').height()+40)+'px'});//.show();
                if($('#my-box .image-block img').size()>0) {
                    if(!$('#my-box .image-block img').eq(elindex).prev()[0]) {
                        $('#my-box .arrow-left').hide();
                    } else {
                        $('#my-box .arrow-left').show();
                    }
                    if(!$('#my-box .image-block img').eq(elindex).next()[0]) {
                        $('#my-box .arrow-right').hide();
                    } else {
                        $('#my-box .arrow-right').show();
                    }
                }
            },
            clearBoxDialog: function() {
                $('#my-box .image-block img').remove();
            },
            clearThumbsDialog: function() {
                $('#my-box .thumb-block').empty();
            },
            next: function() {
                var ind = $('#my-box .image-block img:visible').index();
                if(!ind) ind = 0;
                if($('#my-box .image-block img').eq(ind).next()[0]) {
                    $('#my-box .image-block img').eq(ind).hide();
                    methods['resize']($('#my-box .image-block img').eq(ind).next().index());
                }
            },
            prev: function() {
                var ind = $('#my-box .image-block img:visible').index();
                if(!ind) ind = 0;
                if($('#my-box .image-block img').eq(ind).prev()[0]) {
                    $('#my-box .image-block img').eq(ind).hide();
                    methods['resize']($('#my-box .image-block img').eq(ind).prev().index());
                }
            }
        }
    $.fn.myBox = function(options) {
        if(!$('#my-box-back')[0]) {
            $('body').append('<div id="my-box-back"></div>');
            $('#my-box-back').css({width: $(document).width()+'px', height: $(document).height()+'px'});
            $('body').append('<div id="my-box"></div>');
            $('#my-box').append('<div class="inner-block">'+
                '<div class="image-block"></div><div class="thumb-block"></div>'+'</div>');
            $('#my-box').prepend('<div class="arrow arrow-left"><div class="icon"></div></div><div class="arrow arrow-right"><div class="icon"></div></div>');
            $('#my-box').css({display: 'block'});
            $('#my-box .arrow').hide();
            $('#my-box').hide();
            $('#my-box .arrow-left').bind('click', function() {
                methods['prev']();
            });
            $('#my-box .arrow-right').bind('click', function() {
                methods['next']();
            });
        };
        $(this).unbind('click').bind('click', function() {
            methods['showBoxDialog']();
            methods['loadImages']('a.mybox-thumb.large', $(this).parents('.mybox-row').index(), '#my-box .image-block');
            methods['loadThumbs']('a.mybox-thumb.thumb', $(this).parents('.mybox-row').index(), '#my-box .thumb-block');
            return false;
        });
        $('#my-box-back').unbind('click').bind('click', function() {
            methods['hideBoxDialog']();
            return false;
        });
    };
})( jQuery );