
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
    'asyncT':function (url,data,Fn) {

        //访问接口
        var postMsgT = $.ajax({
            url: url,
            data: data,
            async: true,
            type: 'post',
            dataType:'json',
            complete: function(msg) {
                Fn(msg.responseJSON);
            }
        });
        
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

    // 获取cookie
    'getCookie':function(c_name)
    {
        if (document.cookie.length>0)
        {
            c_start=document.cookie.indexOf(c_name + "=")
            if (c_start!=-1)
            { 
                c_start=c_start + c_name.length+1 
                c_end=document.cookie.indexOf(";",c_start)
                if (c_end==-1) c_end=document.cookie.length
                return unescape(document.cookie.substring(c_start,c_end))
            } 
        }
        return ""
    },
    //设置cookie
    'setCookie':function(c_name,value,expiredays)
    {
        var exdate = new Date();
        exdate.setDate(exdate.getDate()+expiredays)
        document.cookie=c_name+ "=" +escape(value)+
        ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
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

    // 获取消息小红点
    'getUnreadMessage':function(url,data){
        $.ajax({
            url: url,
            data: data,
            async: true,
            type: 'post',
            dataType:'json',
            complete: function(msg) {

                if(msg.responseJSON.code == 200){
                    window.unReadMessage = msg.responseJSON.data;
                    var html = `<span class="mui-badge">${window.unReadMessage}</span>`;
                    $('#Message').html(html);
                }else{
                    window.unReadMessage = 0;
                    $('#Message').html('');
                } 
            }
        })
        
    },

    // 获取路径上?的参数
    GetQueryString:function (name){
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");   
        var r = window.location.search.substr(1).match(reg);   
        if (r != null) return decodeURI(r[2]); return null;   
    },

    // 时间戳转换为日期nS为时间戳
    timeTOstr:function(nS) {  
        //           将时间戳换成毫秒        转换时间格式     去掉秒
        return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');  
        // 返回格式:2017/11/16 下午2:43 
    },
    
    // 自定义格式时间戳转换为日期
    dateIt:function(format, timestamp){ 
        var a, jsdate=((timestamp) ? new Date(timestamp*1000) : new Date()); 
        var pad = function(n, c){ 
            if((n = n + "").length < c){ 
                return new Array(++c - n.length).join("0") + n; 
            } else { 
                return n; 
            } 
        }; 
        var txt_weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]; 
        var txt_ordin = {1:"st", 2:"nd", 3:"rd", 21:"st", 22:"nd", 23:"rd", 31:"st"}; 
        var txt_months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]; 
        var f = { 
            // Day 
            d: function(){return pad(f.j(), 2)}, 
            D: function(){return f.l().substr(0,3)}, 
            j: function(){return jsdate.getDate()}, 
            l: function(){return txt_weekdays[f.w()]}, 
            N: function(){return f.w() + 1}, 
            S: function(){return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th'}, 
            w: function(){return jsdate.getDay()}, 
            z: function(){return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0}, 

            // Week 
            W: function(){ 
                var a = f.z(), b = 364 + f.L() - a; 
                var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1; 
                if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){ 
                    return 1; 
                } else{ 
                    if(a <= 2 && nd >= 4 && a >= (6 - nd)){ 
                        nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31"); 
                        return date("W", Math.round(nd2.getTime()/1000)); 
                    } else{ 
                        return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0); 
                    } 
                } 
            }, 

            // Month 
            F: function(){return txt_months[f.n()]}, 
            m: function(){return pad(f.n(), 2)}, 
            M: function(){return f.F().substr(0,3)}, 
            n: function(){return jsdate.getMonth() + 1}, 
            t: function(){ 
                var n; 
                if( (n = jsdate.getMonth() + 1) == 2 ){ 
                    return 28 + f.L(); 
                } else{ 
                    if( n & 1 && n < 8 || !(n & 1) && n > 7 ){ 
                       return 31; 
                   } else{ 
                       return 30; 
                   } 
               } 
            }, 

            // Year 
            L: function(){var y = f.Y();return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0}, 
            //o not supported yet 
            Y: function(){return jsdate.getFullYear()}, 
            y: function(){return (jsdate.getFullYear() + "").slice(2)}, 

            // Time 
            a: function(){return jsdate.getHours() > 11 ? "pm" : "am"}, 
            A: function(){return f.a().toUpperCase()}, 
            B: function(){ 
            // peter paul koch: 
                var off = (jsdate.getTimezoneOffset() + 60)*60; 
                var theSeconds = (jsdate.getHours() * 3600) + (jsdate.getMinutes() * 60) + jsdate.getSeconds() + off; 
                var beat = Math.floor(theSeconds/86.4); 
                if (beat > 1000) beat -= 1000; 
                if (beat < 0) beat += 1000; 
                if ((String(beat)).length == 1) beat = "00"+beat; 
                if ((String(beat)).length == 2) beat = "0"+beat; 
                return beat; 
            }, 
            g: function(){return jsdate.getHours() % 12 || 12}, 
            G: function(){return jsdate.getHours()}, 
            h: function(){return pad(f.g(), 2)}, 
            H: function(){return pad(jsdate.getHours(), 2)}, 
            i: function(){return pad(jsdate.getMinutes(), 2)}, 
            s: function(){return pad(jsdate.getSeconds(), 2)}, 
            //u not supported yet 

            // Timezone 
            //e not supported yet 
            //I not supported yet 
            O: function(){ 
                var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4); 
                if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t; 
                return t; 
            }, 
            P: function(){var O = f.O();return (O.substr(0, 3) + ":" + O.substr(3, 2))}, 
            //T not supported yet 
            //Z not supported yet 

            // Full Date/Time 
            c: function(){return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P()}, 
            //r not supported yet 
            U: function(){return Math.round(jsdate.getTime()/1000)} 
        }; 

        return format.replace(/([a-zA-Z])/g, function(t, s){ 
            // var t =1,s=2;
            if( t!=s ){ 
                    // escaped 
                    ret = s; 
                } else if( f[s] ){ 
                    // a date function exists 
                    ret = f[s](); 
                } else{ 
                    // nothing special 
                    ret = s; 
                } 
            
            // console.log(ret)
            return ret; 
        }); 
    }        
}