 //验证码

document.write('<script src="/static/frontend/js/jquery-3.2.1.min.js"></script>');  
    var smsCode = {
        'getMobileCodeApi':function (obj,mobile,url) {
            var obj = $(obj);
            obj.attr("disabled", "disabled");
            /*按钮倒计时*/
            var time = 60;
            var set = setInterval(function () {
                obj.val(--time + "(s)");
            }, 1000);
            /*等待时间*/
            setTimeout(function () {
                obj.attr("disabled", false).val("重新获取验证码");
                /*倒计时*/
                clearInterval(set);
            }, 60000);

            //访问接口
            var postMsg = $.ajax({
                url: url,
                data: {'telephone': mobile},
                async: false,
                type: 'post',
                success: function(msg) {

                }
            });
            return postMsg.responseJSON;
        },

        'validateSmsCodeApi':function(mobile,smsCode,url){
            //访问接口
            var postMsg = $.ajax({
                url:url,
                data:{'telephone':mobile,'smsCode':smsCode},
                async:false,
                type:'post',
                success: function(msg){

                }
            });
            return postMsg.responseJSON;
        }
    }

