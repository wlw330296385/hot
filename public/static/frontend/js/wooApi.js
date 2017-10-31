
if (typeof jQuery == 'undefined') { 
document.write('<script src="/static/frontend/js/jquery-3.2.1.min.js"></script>');
} else { 
    
} 


var wooApi = {
        //同步访问接口
        'asyncF':function (url,data) {
            data=data||'';
            //访问接口
            var postMsgF = $.ajax({
                url: url,
                data: data,
                async: false,
                type: 'post',
                dataType:'json',
                success: function(msg) {

                }
            });
            return postMsgF.responseJSON;
        },
        //异步访问接口
        'asyncT':function (url,data) {

            //访问接口
            var postMsgT = $.ajax({
                url: url,
                data: data,
                async: true,
                type: 'post',
                dataType:'json',
                success: function(msg) {

                }
            });
            return postMsgT.responseJSON;
        },
        // 一键获取已有变量
        'getJson':function(str){
            var jsonData = JSON.parse(str);
            return jsonData; 
        },


        // 一键获取input下的值
        'getInputData':function(domName,className,data){
            domName=domName||'input';
            className=className||'data';
            data=data||[];
            switch(domName){
                case 'input':
                var inputs = "input."+className;
                $(inputs).each(function(i){
                    var name = $(this).attr('name');
                    var val = $(this).val();
                    var son = name+'='+val;
                    data.push(son);
                })
                break;
                case 'select':
                    var selects = "select."+className;
                    $(selects).each(function(i){
                        var name = $(this).attr('name');
                        var val = $(this).val();
                        var son = name+'='+val;
                        data.push(son);
                    })
                break;
                case 'checkbox':
                    var checkboxs = "checkbox."+className;
                    $(checkboxs).each(function(i){
                        if($(this).attr('checked')==true){
                            var name = $(this).attr('name');
                            var val = $(this).data();
                            var son = name+'='+val;
                            data.push(son);
                        }
                    })
                break;
                case 'radio':
                    var radios = "radio."+className;
                    $(radios).each(function(i){
                        if($(this).attr('checked')==true){
                            var name = $(this).attr('name');
                            var val = $(this).val();
                            var son = name+'='+val;
                            data.push(son);
                        }
                    })
                break;
                default :
                var dName = domName+"."+className;
                $(dName).each(function(i){
                    var name = $(this).attr('name');
                    var val = $(this).val();
                    var son = name+'='+val;
                    data.push(son);
                })
                break;
            }
            return data;
        },
        'getDomData':function(className,data){
            className=className||'domData';
            data=data||[];
            var cName = '.'+className;
            $(cName).each(function(i){
                    var name = $(this).attr('name');
                    var val = $(this).html();
                    var son = name+'='+val;
                    data.push(son);
            })
            return data;
        },

        //发送请求
        'ajaxSend':function(url,data){
            $.ajax({
                url:url,
                data:data,
                type:'post',
                dataType:'JSON',
                error:function(result){

                },
                success:function(result){

                },

            })
        },


        //数组转对象
        'arrTOobj':function(arr){
            var obj = new Object();
            for (var x in arr){
                var splits = arr[x].split('=');
                obj[splits[0]] = splits[1];
            }
            return obj;
        },




        // 选择课时
        'selectLessonTotal':function(domName,className){
            var dName = domName+"."+className;
            $(dName).addClass('mui-btn-warning');
            return $(dName).data();
        },


        //选择课时
        'selectLessonTotal2':function(dom){
            dom.addClass('mui-btn-warning');
            var data = dom.attr('data');
            // var data = dom.data();
            return data;
        },




        GetQueryString:function (name)
        {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");   
            var r = window.location.search.substr(1).match(reg);   
            if (r != null) return decodeURI(r[2]); return null;   
        }
    
    }