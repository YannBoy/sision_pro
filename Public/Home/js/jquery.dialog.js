/**
 * Created by Administrator on 2015/12/22.
 */

;(function($,window,document){

    var pluginName = 'dialogBox',
        defaults = {

            width: null, //寮瑰嚭灞傚搴�
            height: null,  //寮瑰嚭灞傞珮搴�
            autoSize: true,  //鏄惁鑷€傚簲灏哄,榛樿鑷€傚簲
            autoHide: false,  //鏄惁鑷嚜鍔ㄦ秷澶憋紝閰嶅悎time鍙傛暟鍏辩敤
            time: 3000,  //鑷姩娑堝け鏃堕棿锛屽崟浣嶆绉�
            zIndex: 99999,  //寮瑰嚭灞傚畾浣嶅眰绾�
            hasMask: false,  //鏄惁鏄剧ず閬僵灞�
            hasClose: false,  //鏄惁鏄剧ず鍏抽棴鎸夐挳
            hasBtn: false,  //鏄惁鏄剧ず鎿嶄綔鎸夐挳锛屽鍙栨秷锛岀‘瀹�
            confirmValue: null,  //纭畾鎸夐挳鏂囧瓧鍐呭
            confirm: function(){}, //鐐瑰嚮纭畾鍚庡洖璋冨嚱鏁�
            cancelValue: null,  //鍙栨秷鎸夐挳鏂囧瓧鍐呭
            cancel: function(){},  //鐐瑰嚮鍙栨秷鍚庡洖璋冨嚱鏁帮紝榛樿鍏抽棴寮瑰嚭妗�
            effect: '', //鍔ㄧ敾鏁堟灉锛歠ade(榛樿),newspaper,fall,scaled,flip-horizontal,flip-vertical,sign,
            type: 'normal', //瀵硅瘽妗嗙被鍨嬶細normal(鏅€氬璇濇),correct(姝ｇ‘/鎿嶄綔鎴愬姛瀵硅瘽妗�),error(閿欒/璀﹀憡瀵硅瘽妗�)
            title: '',  //鏍囬鍐呭锛屽鏋滀笉璁剧疆锛屽垯杩炲悓鍏抽棴鎸夐挳锛堜笉璁鸿缃樉绀轰笌鍚︼級閮戒笉鏄剧ず鏍囬
            content: ''

        };

    function DialogBox(element,options){
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this.init();
    }

    DialogBox.prototype = {

        //鍒濆鍖栧脊鍑烘
        init: function(){
            var that = this,
                element = this.element;

            that.render(element);
            that.setStyle();
            that.show();
            that.trigger(element);
        },

        //鍒涘缓寮瑰嚭妗�
        create: function(element){
            var that = this,
                $this = $(element),
                title =  that.settings.title,
                hasBtn = that.settings.hasBtn,
                hasMask = that.settings.hasMask,
                hasClose = that.settings.hasClose,
                confirmValue = that.settings.confirmValue,
                cancelValue = that.settings.cancelValue,
                dialogHTML = [];


            if(!title){
                dialogHTML[0] = '<section class="dialog-box"><div class="dialog-box-container"><div class="dialog-box-content"></div>';
            }else{
                if(!hasClose){
                    dialogHTML[0] = '<section class="dialog-box"><div class="dialog-box-container"><div class="dialog-box-title"><h3>'+ title + '</h3></div><div class="dialog-box-content"></div>';
                }else{
                    dialogHTML[0] = '<section class="dialog-box"><div class="dialog-box-container"><div class="dialog-box-title"><h3>'+ title + '</h3><span class="dialog-box-close">×</span></div><div class="dialog-box-content"></div>';
                }
            }

            if(!hasBtn){
                dialogHTML[1] = '</div></section>';
            }else{
                if(confirmValue && cancelValue){
                    dialogHTML[1] = '<div class="dialog-btn"><span class="dialog-btn-cancel">' + cancelValue + '</span><span class="dialog-btn-confirm">' + confirmValue + '</span></div></div></section>';
                }else if(cancelValue){
                    dialogHTML[1] = '<div class="dialog-btn"><span class="dialog-btn-cancel">' + cancelValue + '</span></div></div></section>';
                }else if(confirmValue){
                    dialogHTML[1] = '<div class="dialog-btn"><span class="dialog-btn-confirm">' + confirmValue + '</span></div></div></section>';
                }else{
                    dialogHTML[1] = '<div class="dialog-btn"><span class="dialog-btn-cancel">鍙栨秷</span><span class="dialog-btn-confirm">纭畾</span></div></div></section>';
                }
            }

            if(!hasMask){
                dialogHTML[2] = '';
            }else{
                dialogHTML[2] = '<div id="dialog-box-mask"></div>';
            }

            return dialogHTML;
        },

        //娓叉煋寮瑰嚭妗�
        render: function(element){
            var that = this,
                $this = $(element),
                dialogHTML = that.create($this),
                $content = that.parseContent();

            $this.replaceWith(dialogHTML[0] + dialogHTML[1]);

            if(typeof($content) === 'object'){
                $content.appendTo('.dialog-box-content');
            }else{
                $('.dialog-box-content').append($content);
            }

            $('body').append(dialogHTML[2]);
        },

        //瑙ｆ瀽骞跺鐞嗗脊鍑烘鍐呭
        parseContent: function(){
            var that = this,
                content = that.settings.content,
                width = that.settings.width,
                height = that.settings.height,
                type = that.settings.type,
                $iframe = $('<iframe>'),
                random = '?tmp=' + Math.random(),
                urlReg = /^(https?:\/\/|\/|\.\/|\.\.\/)/;

            if(urlReg.test(content)){

                $iframe.attr({
                    src: content + random,
                    frameborder: 'no',
                    scrolling: 'no',
                    name: 'dialog-box-iframe',
                    id: 'dialog-box-iframe'
                })
                    .on('load',function(){

                        //鍔ㄦ€佽嚜閫傚簲iframe楂樺害;
                        var $iframe = $(window.frames['dialog-box-iframe'].document),
                            $iframeBody = $(window.frames['dialog-box-iframe'].document.body),
                            iframeWidth = $iframe.outerWidth() - 8,
                            iframeHeight = $iframe.outerHeight() - 16,
                            $dialogBox = $('.dialog-box'),
                            $content = $('.dialog-box-content'),
                            $container = $('.dialog-box-container');

                        dialogBoxWidth = iframeWidth + 40;
                        dialogBoxHeight = iframeHeight + 126;

                        if(that.settings.autoSize){
                            $(this).width(iframeWidth);
                            $(this).height(iframeHeight);

                            $iframeBody.css({
                                margin: '0',
                                padding: '0'
                            });

                            $content.css({
                                width: iframeWidth + 'px',
                                height: iframeHeight + 'px'
                            });

                            $container.css({
                                width: dialogBoxWidth + 'px',
                                height: dialogBoxHeight + 'px'
                            });

                            $dialogBox.css({
                                width: dialogBoxWidth,
                                height: function(){
                                    if(type === '' || type === 'normal'){
                                        return dialogBoxHeight + 'px';
                                    }else if(type === 'error' || type === 'correct'){
                                        dialogBoxHeight = dialogBoxHeight + 8;
                                        return dialogBoxHeight + 'px';
                                    }
                                },
                                'margin-top': function(){
                                    if(type === '' || type === 'normal'){
                                        return -Math.round(dialogBoxHeight/2) + 'px';
                                    }else if(type === 'error' || type === 'correct'){
                                        dialogBoxHeight = dialogBoxHeight + 4;
                                        return -Math.round(dialogBoxHeight/2) + 'px';
                                    }
                                },
                                'margin-left': -Math.round(dialogBoxWidth/2) + 'px'
                            });

                        }else{
                            $(this).width(that.settings.width - 40);
                            $(this).height(that.settings.height - 126);
                        }
                    });
                return $iframe;
            }else{
                return content;
            }
        },

        //鏄剧ず寮瑰嚭妗�
        show: function(){
            $('.dialog-box').css({display:'block'});

            setTimeout(function(){
                $('.dialog-box').addClass('show');
            },50)

            $('#dialog-box-mask').show();
        },

        //闅愯棌寮瑰嚭妗�
        hide: function(element){
            var $this = $(element),
                $dialogBox = $('.dialog-box'),
                $iframe = $('#dialogBox-box-iframe');

            $dialogBox.removeClass('show');

            setTimeout(function(){
                if($iframe){
                    $iframe.attr('src','_blank');
                }

                $dialogBox.replaceWith('<div id="' + $this.attr('id') + '"></div/>');
                $('#dialog-box-mask').remove();
            },150)
        },

        //璁剧疆寮瑰嚭妗嗘牱寮�
        setStyle: function(){
            var that = this,
                $dialog = $('.dialog-box'),
                $container = $('.dialog-box-container'),
                $content = $('.dialog-box-content'),
                $mask  = $('#dialog-box-mask'),
                type = that.settings.type,
                EFFECT = 'effect';

            //寮瑰嚭妗嗗妗嗘牱寮�
            $dialog.css({
                width: function(){
                    if(that.settings.width){
                        return that.settings.width + 'px';
                    }else{
                        return;
                    }
                },
                height: function(){
                    if(that.settings.height){
                        if(type === '' || type === 'normal'){
                            return that.settings.height + 'px';
                        }else if(type === 'error' || type === 'correct'){
                            return that.settings.height + 4 + 'px';
                        }
                    }else{
                        return;
                    }
                },
                'margin-top': function(){
                    var height;
                    if(type === '' || type === 'normal'){
                        height = that.settings.height;
                    }else if(type === 'error' || type === 'correct'){
                        height = that.settings.height + 4;
                    }
                    return -Math.round(height/5) + 'px';
                },
                'margin-left': function(){
                    var width = $(this).width();
                    return -Math.round(width/2) + 'px';
                },
                'z-index': that.settings.zIndex
            });

            //寮瑰嚭妗嗗唴灞傚鍣ㄦ牱寮�
            $container.css({
                width: function(){
                    if(that.settings.width){
                        return that.settings.width + 'px';
                    }else{
                        return;
                    }
                },
                height: function(){
                    if(that.settings.height){
                        return that.settings.height + 'px';
                    }else{
                        return;
                    }
                },
            });

            //寮瑰嚭妗嗗唴瀹规牱寮�
            $content.css({
                width: function(){
                    if(that.settings.width){
                        return that.settings.width - 40 + 'px';
                    }else{
                        return;
                    }
                },
                height: function(){
                    if(that.settings.height){
                        return that.settings.height - 126 + 'px';
                    }else{
                        return;
                    }
                }
            });

            //閬僵灞傛牱寮�
            $mask.css({
                height: $(document).height() + 'px'
            });


            //鍒ゆ柇寮瑰嚭妗嗙被鍨�
            switch(that.settings.type){
                case 'correct':
                    $container.addClass('correct');
                    break;
                case 'error':
                    $container.addClass('error');
                    break;
                default:
                    $container.addClass('normal');;
                    break;
            }

            //寮瑰嚭妗嗗绉嶅姩鐢绘晥鏋�
            switch(that.settings.effect){
                case 'newspaper':
                    $dialog.addClass(EFFECT + '-newspaper');
                    break;
                case 'fall':
                    $dialog.addClass(EFFECT + '-fall');
                    break;
                case 'scaled':
                    $dialog.addClass(EFFECT + '-scaled');
                    break;
                case 'flip-horizontal':
                    $dialog.addClass(EFFECT + '-flip-horizontal');
                    break;
                case 'flip-vertical':
                    $dialog.addClass(EFFECT + '-flip-vertical');
                    break;
                case 'sign':
                    $dialog.addClass(EFFECT + '-sign');
                    break;
                default:
                    $dialog.addClass(EFFECT + '-fade');
                    break;
            }

        },

        //寮瑰嚭妗嗚Е灞忓櫒(绯诲垪浜嬩欢)
        trigger: function(element,event){
            var that = this,
                $this = $(element);

            $('.dialog-box-close,#dialog-box-mask,.dialog-btn-cancel,.dialog-btn-confirm').on('click',function(){
                that.hide($this);
            });

            $(document).keyup(function(event){
                if(event.keyCode === 27){
                    that.hide($this);
                }
            });

            if(that.settings.autoHide){
                setTimeout(function(){
                    that.hide($this);
                },that.settings.time)
            }

            if($.isFunction(that.settings.confirm)){
                $('.dialog-btn-confirm').on('click',function(){
                    that.settings.confirm();
                })
            }

            if($.isFunction(that.settings.cancel)){
                $('.dialog-btn-cancel').on('click',function(){
                    that.settings.cancel();
                })
            }

        }

    };

    $.fn[pluginName] = function(options) {
        this.each(function() {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new DialogBox(this, options));
            }
        });
        return this;
    };

})(jQuery,window,document)