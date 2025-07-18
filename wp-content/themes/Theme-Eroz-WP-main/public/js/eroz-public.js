/*! jQuery & Zepto Lazy v1.7.10 - http://jquery.eisbehr.de/lazy - MIT&GPL-2.0 license - Copyright 2012-2018 Daniel 'Eisbehr' Kern */
!function(t,e){"use strict";function r(r,a,i,u,l){function f(){L=t.devicePixelRatio>1,i=c(i),a.delay>=0&&setTimeout(function(){s(!0)},a.delay),(a.delay<0||a.combined)&&(u.e=v(a.throttle,function(t){"resize"===t.type&&(w=B=-1),s(t.all)}),u.a=function(t){t=c(t),i.push.apply(i,t)},u.g=function(){return i=n(i).filter(function(){return!n(this).data(a.loadedName)})},u.f=function(t){for(var e=0;e<t.length;e++){var r=i.filter(function(){return this===t[e]});r.length&&s(!1,r)}},s(),n(a.appendScroll).on("scroll."+l+" resize."+l,u.e))}function c(t){var i=a.defaultImage,o=a.placeholder,u=a.imageBase,l=a.srcsetAttribute,f=a.loaderAttribute,c=a._f||{};t=n(t).filter(function(){var t=n(this),r=m(this);return!t.data(a.handledName)&&(t.attr(a.attribute)||t.attr(l)||t.attr(f)||c[r]!==e)}).data("plugin_"+a.name,r);for(var s=0,d=t.length;s<d;s++){var A=n(t[s]),g=m(t[s]),h=A.attr(a.imageBaseAttribute)||u;g===N&&h&&A.attr(l)&&A.attr(l,b(A.attr(l),h)),c[g]===e||A.attr(f)||A.attr(f,c[g]),g===N&&i&&!A.attr(E)?A.attr(E,i):g===N||!o||A.css(O)&&"none"!==A.css(O)||A.css(O,"url('"+o+"')")}return t}function s(t,e){if(!i.length)return void(a.autoDestroy&&r.destroy());for(var o=e||i,u=!1,l=a.imageBase||"",f=a.srcsetAttribute,c=a.handledName,s=0;s<o.length;s++)if(t||e||A(o[s])){var g=n(o[s]),h=m(o[s]),b=g.attr(a.attribute),v=g.attr(a.imageBaseAttribute)||l,p=g.attr(a.loaderAttribute);g.data(c)||a.visibleOnly&&!g.is(":visible")||!((b||g.attr(f))&&(h===N&&(v+b!==g.attr(E)||g.attr(f)!==g.attr(F))||h!==N&&v+b!==g.css(O))||p)||(u=!0,g.data(c,!0),d(g,h,v,p))}u&&(i=n(i).filter(function(){return!n(this).data(c)}))}function d(t,e,r,i){++z;var o=function(){y("onError",t),p(),o=n.noop};y("beforeLoad",t);var u=a.attribute,l=a.srcsetAttribute,f=a.sizesAttribute,c=a.retinaAttribute,s=a.removeAttribute,d=a.loadedName,A=t.attr(c);if(i){var g=function(){s&&t.removeAttr(a.loaderAttribute),t.data(d,!0),y(T,t),setTimeout(p,1),g=n.noop};t.off(I).one(I,o).one(D,g),y(i,t,function(e){e?(t.off(D),g()):(t.off(I),o())})||t.trigger(I)}else{var h=n(new Image);h.one(I,o).one(D,function(){t.hide(),e===N?t.attr(C,h.attr(C)).attr(F,h.attr(F)).attr(E,h.attr(E)):t.css(O,"url('"+h.attr(E)+"')"),t[a.effect](a.effectTime),s&&(t.removeAttr(u+" "+l+" "+c+" "+a.imageBaseAttribute),f!==C&&t.removeAttr(f)),t.data(d,!0),y(T,t),h.remove(),p()});var m=(L&&A?A:t.attr(u))||"";h.attr(C,t.attr(f)).attr(F,t.attr(l)).attr(E,m?r+m:null),h.complete&&h.trigger(D)}}function A(t){var e=t.getBoundingClientRect(),r=a.scrollDirection,n=a.threshold,i=h()+n>e.top&&-n<e.bottom,o=g()+n>e.left&&-n<e.right;return"vertical"===r?i:"horizontal"===r?o:i&&o}function g(){return w>=0?w:w=n(t).width()}function h(){return B>=0?B:B=n(t).height()}function m(t){return t.tagName.toLowerCase()}function b(t,e){if(e){var r=t.split(",");t="";for(var a=0,n=r.length;a<n;a++)t+=e+r[a].trim()+(a!==n-1?",":"")}return t}function v(t,e){var n,i=0;return function(o,u){function l(){i=+new Date,e.call(r,o)}var f=+new Date-i;n&&clearTimeout(n),f>t||!a.enableThrottle||u?l():n=setTimeout(l,t-f)}}function p(){--z,i.length||z||y("onFinishedAll")}function y(t,e,n){return!!(t=a[t])&&(t.apply(r,[].slice.call(arguments,1)),!0)}var z=0,w=-1,B=-1,L=!1,T="afterLoad",D="load",I="error",N="img",E="src",F="srcset",C="sizes",O="background-image";"event"===a.bind||o?f():n(t).on(D+"."+l,f)}function a(a,o){var u=this,l=n.extend({},u.config,o),f={},c=l.name+"-"+ ++i;return u.config=function(t,r){return r===e?l[t]:(l[t]=r,u)},u.addItems=function(t){return f.a&&f.a("string"===n.type(t)?n(t):t),u},u.getItems=function(){return f.g?f.g():{}},u.update=function(t){return f.e&&f.e({},!t),u},u.force=function(t){return f.f&&f.f("string"===n.type(t)?n(t):t),u},u.loadAll=function(){return f.e&&f.e({all:!0},!0),u},u.destroy=function(){return n(l.appendScroll).off("."+c,f.e),n(t).off("."+c),f={},e},r(u,l,a,f,c),l.chainable?a:u}var n=t.jQuery||t.Zepto,i=0,o=!1;n.fn.Lazy=n.fn.lazy=function(t){return new a(this,t)},n.Lazy=n.lazy=function(t,r,i){if(n.isFunction(r)&&(i=r,r=[]),n.isFunction(i)){t=n.isArray(t)?t:[t],r=n.isArray(r)?r:[r];for(var o=a.prototype.config,u=o._f||(o._f={}),l=0,f=t.length;l<f;l++)(o[t[l]]===e||n.isFunction(o[t[l]]))&&(o[t[l]]=i);for(var c=0,s=r.length;c<s;c++)u[r[c]]=t[0]}},a.prototype.config={name:"lazy",chainable:!0,autoDestroy:!0,bind:"load",threshold:500,visibleOnly:!1,appendScroll:t,scrollDirection:"both",imageBase:null,defaultImage:"data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==",placeholder:null,delay:-1,combined:!1,attribute:"data-src",srcsetAttribute:"data-srcset",sizesAttribute:"data-sizes",retinaAttribute:"data-retina",loaderAttribute:"data-loader",imageBaseAttribute:"data-imagebase",removeAttribute:!0,handledName:"handled",loadedName:"loaded",effect:"show",effectTime:0,enableThrottle:!0,throttle:250,beforeLoad:e,afterLoad:e,onError:e,onFinishedAll:e},n(t).on("load",function(){o=!0})}(window);
/**
 * COOKIES: Read and Write
 * Plugin Admin Cookies
 * Developed by Github
 */
var createCookie = function(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}
function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}
/**
 * REPORT VIDEO - PLUGIN JS
 * V.1.0.1 Developed by CesarDpaz@torothemes.com
 * url: #
 * Compatible with ErozTheme
 * report with cookie user
 * For user no loggin
 */
jQuery(document).ready(function($){
    $.reportVideo = function(option){
        option = $.extend({
            container   : "#form-report",
            error_text  : erozPublic.report_error_text,
            send_text   : erozPublic.report_send_text,
            send_text_correct   : erozPublic.report_send_text_correct,
            write_reason   : erozPublic.report_write_reason,
            duplicate_report_text : erozPublic.report_duplicate_report_text
        }, option);
        var $container_button = $(option.container),
            html_button = '<button type="submit">'+ option.send_text +'</button>';
        $container_button.append(html_button); //Add button to HTML
        function clean_messages_report(){
            $('.error-send-report').remove();
            $('.error-duplicate-report').remove();
        }
        $container_button.on('submit', function(event) {
            event.preventDefault();
            var $this = $(this),
                id_post = $this.data('id'),
                reason = $this.find('input[name="radio2"]:checked').val();
            /*Prevent double report per user*/
            var cookie_report = getCookie('report_eroz');
            if( cookie_report == id_post) {
                clean_messages_report();
                var html = '';
                html += '<p class="licence-bx-no">';
                html += '<span class="fa-times"></span>' + option.duplicate_report_text;
                html += '</p>';
                $container_button.append(html);
                setTimeout(function() {
                    $.when($('.licence-bx-no').fadeOut(1000)).done(function() {
                         $(".licence-bx-no").remove();
                    });
                },2000);
                //$container_button.append('<div class="error-send-report">' + option.duplicate_report_text + '</div>');
                return;
            }
            /*Prevent dont choose reason*/
            if(!reason){
                clean_messages_report()
                var html = '';
                html += '<p class="licence-bx-no">';
                html += '<span class="fa-times"></span>' + option.error_text;
                html += '</p>';
                $container_button.append(html);
                setTimeout(function() {
                    $.when($('.licence-bx-no').fadeOut(1000)).done(function() {
                         $(".licence-bx-no").remove();
                    });
                },2000);
                return;
            }
            if(reason == 'Other') {
                reason = $('#reason_text').val();
                if($('#reason_text').val() == '') {
                    var html = '';
                    html += '<p class="licence-bx-no">';
                    html += '<span class="fa-times"></span>' + option.write_reason;
                    html += '</p>';
                    $container_button.append(html);
                    setTimeout(function() {
                        $.when($('.licence-bx-no').fadeOut(1000)).done(function() {
                             $(".licence-bx-no").remove();
                        });
                    },2000);
                    return;
                }
            }
            $('.error-send-report').remove();
            $.ajax({
                url     : erozPublic.url,
                method      : 'POST',
                dataType    : 'json',
                data     : {
                    action      : 'action_eroz_send_report',
                    nonce       : erozPublic.nonce,
                    id_post     : id_post,
                    reason      : reason
                }, 
                success: function( data ) {
                    console.log(data);
                    var html = '';
                    html += '<p class="licence-bx-ok">';
                    html += '<span class="fa-check"></span>' + option.send_text_correct;
                    html += '</p>';
                    $('#form-report').append(html);
                    createCookie('report_eroz', id_post);
                    setTimeout(function() {
                        $.when($('.licence-bx-ok').fadeOut(1000)).done(function() {
                             $(".licence-bx-ok").remove();
                        });
                    },2000);
                }
            });
        });
    };
})
/**
 * VOTE POST - PLUGIN JS
 * V.1.0.1 Developed by CesarDpaz@torothemes.com
 * url: #
 * Compatible with ErozTheme
 * report with cookie user
 * For user no loggin
 */
 jQuery(document).ready(function($){
    $.voteVideo = function(option){
        option = $.extend({
            duplicate_vote_text : erozPublic.vote_duplicate_vote_text,
            send_text_correct   : erozPublic.vote_send_text_correct
        }, option);
        //Like post
        $('#like-post').on('click', function(event) {
            event.preventDefault();
            var id_post = $(this).data('id');
            /*Prevent double report per user*/
            var cookie_vote = getCookie('vote_eroz');
            
            var cookie_vote_js = getCookie('vote_er');
            if(!cookie_vote_js) {
                var cookie_vote_js = new Array();
            } else {
                var cookie_vote_js = JSON.parse(cookie_vote_js);
                
                if(cookie_vote_js.indexOf(id_post) !== -1){
                    var html = '';
                    html += '<p class="licence-bx-no">';
                    html += '<span class="fa-times"></span>' + option.duplicate_vote_text;
                    html += '</p>';
                    $('.Options.Ul').parent().append(html);
                    setTimeout(function() {
                        $.when($('.licence-bx-no').fadeOut(1000)).done(function() {
                             $(".licence-bx-no").remove();
                        });
                    },2000);
                    return;
                }

            }
            $.ajax({
                url     : erozPublic.url,
                method     : 'POST',
                dataType    : 'json',
                data     : {
                    action      : 'action_eroz_send_vote',
                    nonce       : erozPublic.nonce,
                    id_post     : id_post,
                    type        : 'like'
                }, 
                success: function( data ) {

                    cookie_vote_js.push(id_post);
                    var cookie_ar_json = JSON.stringify(cookie_vote_js);
                    createCookie('vote_er', cookie_ar_json, 360);

                    createCookie('vote_eroz', id_post, 30);
                    console.log(data.percent);
                    $('.percnt > div').css('width', data.percent);
                    $('#txtmt strong').text(data.total);
                    $('.numper > strong').text(data.percent);
                    var html = '';
                    html += '<p class="licence-bx-ok">';
                    html += '<span class="fa-check"></span>' + option.send_text_correct;
                    html += '</p>';
                    $('.Options.Ul').parent().append(html);
                    setTimeout(function() {
                        $.when($('.licence-bx-ok').fadeOut(1000)).done(function() {
                             $(".licence-bx-ok").remove();
                        });
                    },2000);
                }
            })
        });
        //unLike post
        $('body').on('click', '#unlike-post', function(event) {
            event.preventDefault();
            var id_post = $(this).data('id');
            /*Prevent double report per user*/
            var cookie_vote = getCookie('vote_eroz');
            if( cookie_vote == id_post) {
                var html = '';
                html += '<p class="licence-bx-no">';
                html += '<span class="fa-times"></span>' + option.duplicate_vote_text;
                html += '</p>';
                $('.Options.Ul').parent().append(html);
                setTimeout(function() {
                    $.when($('.licence-bx-no').fadeOut(1000)).done(function() {
                         $(".licence-bx-no").remove();
                    });
                },2000);
                return;
            }
            $.ajax({
                url     : erozPublic.url,
                method     : 'POST',
                dataType    : 'json',
                data     : {
                    action      : 'action_eroz_send_vote',
                    nonce       : erozPublic.nonce,
                    id_post     : id_post,
                    type        : 'unlike'
                }, 
                success: function( data ) {
                    createCookie('vote_eroz', id_post);
                    $('.percnt > div').css('width', data.percent);
                    $('#txtmt strong').text(data.total);
                    $('.numper > strong').text(data.percent);
                    var html = '';
                    html += '<p class="licence-bx-ok">';
                    html += '<span class="fa-check"></span>' + option.send_text_correct;
                    html += '</p>';
                    $('.Options.Ul').parent().append(html);
                    setTimeout(function() {
                        $.when($('.licence-bx-ok').fadeOut(1000)).done(function() {
                             $(".licence-bx-ok").remove();
                        });
                    },2000);
                }
            })
        });
    };
})
/**
 * FUNCTIONS JS - After load document
 */
jQuery(document).ready(function($){
    /*Responsive*/
    $('.Header .Mid .Form-Search').clone().prependTo('.Header .Bot .menu-top-menu-container');
    /*Tabs*/
    $('.aa-tbs a').click(function(e){
        e.preventDefault();
          var $this = $(this),
              tabgroup = '#'+$this.parents('.aa-tbs').data('tbs'),
              others = $this.closest('li').siblings().children('a'),
              target = $this.attr('href');
          others.removeClass('on');
          $this.addClass('on');
          $(tabgroup).children().removeClass('on');
          $(target).addClass('on');
      });
    /*Dropdown*/
    $('.AADrpd').each(function() {
        var $AADrpdwn = $(this);
        $('.AALink', $AADrpdwn).click(function(e){
          e.preventDefault();
          $AADrpdDv = $('.AACont', $AADrpdwn);
          $AADrpdDv.parent('.AADrpd').toggleClass('on');
          $('.AACont').not($AADrpdDv).parent('.AADrpd').removeClass('on');
          return false;
        });
    });
    $(document).on('click', function(e){
        if ($(e.target).closest('.AACont').length === 0) {
            $('.AACont').parent('.AADrpd').removeClass('on');
        }
    });
    /*Toggle*/
    $('.AATggl').on('click', function(){
        var shwhdd = $(this).attr('data-tggl');
        $('#'+shwhdd).toggleClass('on');
        $(this).toggleClass('on');
    });
    /*Accordion*/
    $('.AACrdn').find('.AALink').click(function(){
        $(this).toggleClass('on');
        $('.AALink').not($(this)).removeClass('on');
    });
    /*menu-item-has-children*/
    $('.menu-item-has-children').append('<i class="fa-chevron-down"></i>');
    $('.menu-item-has-children>i').click(function(a){
        a.preventDefault();
        var b=$(this);
        if(b.parent().hasClass('on')){
            b.parent().removeClass('on');
        }
        else{
            b.parent().parent().find('.menu-item-has-children').removeClass('on');
            b.parent().toggleClass('on');
        }
    });
    /*SelectBox*/
    $('body').on('click', '.SelectBox', function(e){
        if($(this).hasClass('on')) {
            $(this).removeClass('on');
        } else {
           $(this).addClass('on');
        }
    });
    $('body').on('click', '.SelectBox ul li', function() {
        var v = $(this).text();
        $('.SelectBox ul li').not($(this)).removeClass('on');
        $(this).addClass('on');
        $(this).parent().parent().find('span').text(v);
    });    
    $(document).not('.SelectBox').on('click', function(event) {
        event.preventDefault();
        $('.SelectBox').removeClass('on');
        /* Act on the event */
    });
    /*$(document).click(function() {
        $('.SelectBox').removeClass('on');
    });*/
    /*Cookies Show*/
    console.log(erozPublic.cookie_enabled);
    if(erozPublic.cookie_enabled == 1) {
        var cookie = getCookie('cookie_accept');
        if(cookie != 'accept') {
            var html = '';
            html += ' <div class="Cookies Row DX Nsp" data-ttico="warning">';
            html += ' <p class="title">' + erozPublic.text_announce_cookies + '</p>';
            if(erozPublic.cookie_url_page != '' && erozPublic.cookie_text_page != ''){
            html += ' <span class="Auto"><a href="' + erozPublic.cookie_url_page + '" class="Button A">' + erozPublic.cookie_text_page + '</a></span>';
            }
            html += ' <span class="Auto"><a href="javascript:void(0)" class="Button A cookie_accept">' + erozPublic.cookie_btn_accept_text + '</a></span>';
            html += ' </div>';
            $('.precook').prepend(html);
        }
    }
    /*Cookies Accept*/
    $('body').on('click', '.cookie_accept', function(event) {
        event.preventDefault();
        createCookie('cookie_accept', 'accept', 30);
        $('.Cookies').remove();
    });
    $('#post-share').on('click', function(event) {
        event.preventDefault();
        $('.EzHdCn').removeClass('on');
        $('#post-report').removeClass('on');
        if($(this).hasClass('on')){
            $(this).removeClass('on');
            $('#EzShare').removeClass('on');
        } else {
            $(this).addClass('on');
            $('#EzShare').addClass('on');
        }
    });
    $('#post-report').on('click', function(event) {
        event.preventDefault();
        $('.EzHdCn').removeClass('on');
        $('#post-share').removeClass('on');
        if($(this).hasClass('on')){
            $(this).removeClass('on');
            $('#EzReport').removeClass('on');
        } else {
            $(this).addClass('on');
            $('#EzReport').addClass('on');
        }
    });
    $('.Player .Button').on('click', function(event) {
        event.preventDefault();
        $('.Player').removeClass('Pause');
    });
    /*Report Video*/
    $.reportVideo();
    /*Vote Video*/
    $.voteVideo();
    /*PREVIEW TRAILER*/
    function myLoop(selector, thumb, max) {
        if(selector.hasClass('on')){
        } else { return; }
        setTimeout(function () {  
            var $this = selector,
                image = $this.attr('data-thumbs');
            var numprev = image.slice(-6,-5);
            if(isNaN(numprev)) {
                var num =  image.slice(-5,-4),
                    ide = image.slice(-5);
                    n   = parseInt(max) - parseInt(1);
                if(num > n ) {
                    num = 0;
                }
            } else {
                var num =  image.slice(-6,-4);
                var ide = image.slice(-6);
                if(num > n ) {
                    num = 0;
                }
            }
            var res = ide.split(".");
            var new_num = parseInt(num) + parseInt(1);
            var nn = new_num + '.' + res[1];
            var image_n = image.replace(ide, nn);
            $this.find('img').attr('src', image_n);
            $this.attr('data-thumbs', image_n);
            if (num < max) {          
                myLoop($this, image, max);            
            }                   
        }, 600);
    }
    if ("ontouchstart" in document) { 
        $('.loop-post').on("touchstart", function (e) {;
            var $this     = $(this),
                vid       = $this.data('preview'),
                thumbs    = $this.data('thumbs'),
                thumb_max = $this.data('thumbsmax');
            $('video').remove();
            $('.loop-post').removeClass('on');
            if(vid){
                if(!vid || vid == '' || !thumbs || thumbs == '') { return; }
                var html = '';
                html += '<video src="'+vid+'" class="video-thumbnail" loop webkit-playsinline="true" playsinline="true" autoplay="true" muted=""></video>';
                $this.find('figure').append(html);
            } else if(thumbs){
                $this.addClass('on');
                myLoop($this, thumbs, thumb_max); 
            }
        }), $('.loop-post').on("touchmove", function() {
                e.originalEvent.touches;
            });
    } else {
        $('.loop-post').on('mouseenter', function(event) {
            var $this     = $(this),
                vid       = $this.data('preview'),
                thumbs    = $this.data('thumbs'),
                thumb_max = $this.data('thumbsmax');
            if(vid){
                $this.find('video').remove();
                if(!vid || vid == '') { return; }
                var html = '';
                html += '<video src="'+vid+'" class="video-thumbnail" loop webkit-playsinline="true" playsinline="true" autoplay="true" muted=""></video>';
                $this.find('figure').append(html);
            } else if(thumbs){
                $this.addClass('on');
                myLoop($this, thumbs, thumb_max); 
            }
        });
        $('.loop-post').on('mouseleave', function(event) {
            var $this = $(this);
            $this.find('video').remove();
            $('.loop-post').removeClass('on');
        })
    }  
    /*Video thumbnail*/
    /*$('.image-articles').on('mouseenter', function(event) {
        event.preventDefault();
        var $this = $(this);
        if($this.data('url') == '') {return;}
        $(this).find('video').show();
        $this.find('video').attr('src', $this.data('url'));
        $this.find('video').attr('autoplay', 'true');
        $this.find('img').hide();
    });*/
    /*$('.image-articles').on('mouseleave', function(event) {
        event.preventDefault();
        var $this = $(this);
        if($this.data('url') == '') {return;}
        $(this).find('video').hide();
        $this.find('video').removeAttr('src');
        $this.find('video').removeAttr('autoplay');
        $this.find('img').show();
    });*/
    $('img').Lazy();
    $('.filter-categories').one('click', function(event) {
        var html = '';
        html += '<ul class="result-filter-categories Ul">';
        html += '<li class="on">'+ erozPublic.all +'</li>'
        erozPublic.categories.forEach( function(valor, indice, array) {
            html+='<li>'+ valor['name'] +'</li>';
        });
        html += '</ul>';
        $('.filter-categories').parent().append(html);
    });
 
    $('.videos-ul-player a').on('click',   function(event) {
        event.preventDefault();
        var $this = $(this),
            ide = $this.attr('data-ide'),
            key = $this.attr('data-key');
        $.ajax({
            url     : erozPublic.url,
            method  : 'POST',
            dataType: 'json',
            data    : {
                action: 'action_change_player_eroz',
                ide   : ide,
                key   : key,
            }, 
            beforeSend: function(){
                console.log('cargando');
                $('.Player iframe').fadeOut( 'slow', function() { });
            },
            success: function( data ) {
                $('.Player').html(data.video);
            },
            error: function(){
                console.log('error');
            }
        });
    });
});