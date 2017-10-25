
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
                $(domName+"."+className).each(function(i){
                    var name = $(this).attr('name');
                    var val = $(this).val();
                    var son = name+'='+val;
                    data.push(son);
                })
                break;
                case 'select':
                $(domName+"."+className).each(function(i){
                    var name = $(this).attr('name');
                    var val = $(this).val();
                    var son = name+'='+val;
                    data.push(son);
                })
                break;
                case 'checkbox':
                $(domName+"."+className).each(function(i){
                    if($(this).attr('checked')==true){
                        var name = $(this).attr('name');
                        var val = $(this).data();
                        var son = name+'='+val;
                        data.push(son);
                    }
                })
                break;
                case 'radio':
                $(domName+"."+className).each(function(i){
                    if($(this).attr('checked')==true){
                        var name = $(this).attr('name');
                        var val = $(this).val();
                        var son = name+'='+val;
                        data.push(son);
                    }
                })
                break;
                default :
                $(domName+"."+className).each(function(i){
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
            $('.'+className).each(function(i){
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
                var split = arr[x].split('=');
                obj[split[0] ] = split[1];
            }
            return obj;
        },




        // 选择课时
        'selectLessonTotal':function(domName,className){
            $(domName+"."+className).addClass('mui-btn-warning');
            return $(domName+"."+className).data();
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