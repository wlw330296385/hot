
if (jQuery) { 
// jQuery 已加载 
} else { 
    document.write('<script src="/static/frontend/js/jquery-3.2.1.min.js"></script>');   
} 


var wooApi = {
        //同步访问接口
        'asyncF':function (url,data) {

            //访问接口
            var postMsg = $.ajax({
                url: url,
                data: data,
                async: false,
                type: 'post',
                success: function(msg) {

                }
            });
            return postMsg.responseJSON;
        },
        //异步访问接口
        'asyncT':function (url,data) {

            //访问接口
            var postMsg = $.ajax({
                url: url,
                data: data,
                async: false,
                type: 'post',
                success: function(msg) {

                }
            });
            return postMsg.responseJSON;
        },
        // 一键获取已有变量
        'getData':function(str){
            var jsonData = JSON.parse(str);
            return jsonData; 
        },


        // 一键获取dom下的值
        'getInput':function(domName = 'input'){
            var data = {};
            switch(domName){
                case 'input':
                $(domName).each(function(i){
                    var name = $(this).attr('name');
                    var val = $(this).val();
                    var son = {name:val};
                    data.push(son);
                }
                break;
                case 'checkbox':
                $(domName).each(function(i){
                    if($(this).attr('checked')==true){
                        var name = $(this).attr('name');
                        var val = $(this).data();
                        var son = {name:val};
                        data.push(son);
                    }
                }
                break;
                case 'radio':
                $(domName).each(function(i){
                    if($(this).attr('checked')==true){
                        var name = $(this).attr('name');
                        var val = $(this).val();
                        var son = {name:val};
                        data.push(son);
                    }
                }
                break;
                default:
                $('.'+domName).each(function(i){
                    var name = $(this).attr('name');
                    var val = $(this).data();
                    var son = {name:val};
                    data.push(son);
                }
            }
            
        }
    }