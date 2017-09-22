/**!
 * 微信内置浏览器的Javascript API，功能包括：
 *
 * 1、分享到微信朋友圈
 * 2、分享给微信好友
 * 3、分享到腾讯微博
 * 4、隐藏/显示右上角的菜单入口
 * 5、隐藏/显示底部浏览器工具栏
 * 6、获取当前的网络状态
 * 7、调起微信客户端的图片播放组件
 *
 * @author zhaoxianlie(http://www.baidufe.com)
 */

 
if (typeof jQuery == 'undefined') { 
document.write('<script src="/static/frontend/js/jquery-3.2.1.min.js"></script>');   
} else { 
    
} 
var WeixinApi = (function () { 
 
    /* 这里省略了一堆代码……下面直接看调用接口 */ 
    return {
        ready           :wxJsBridgeReady,
        shareToTimeline :weixinShareTimeline,
        shareToWeibo    :weixinShareWeibo,
        shareToFriend   :weixinSendAppMessage,
        showOptionMenu  :showOptionMenu,
        hideOptionMenu  :hideOptionMenu,
        showToolbar     :showToolbar,
        hideToolbar     :hideToolbar,
        getNetworkType  :getNetworkType,
        imagePreview    :imagePreview
    };    
 
});




// 所有功能必须包含在 WeixinApi.ready 中进行
function wxShare(imgUrl,link,desc,title){
    WeixinApi.ready(function(Api){
 
        // 微信分享的数据
        var wxData = {
            "imgUrl":imgUrl,
            "link":link,
            "desc":desc,
            "title":title
        };
     
        // 分享的回调
        var wxCallbacks = {
            // 分享操作开始之前
            ready:function () {
                // 你可以在这里对分享的数据进行重组
            },
            // 分享被用户自动取消
            cancel:function (resp) {
                // 你可以在你的页面上给用户一个小Tip，为什么要取消呢？
            },
            // 分享失败了
            fail:function (resp) {
                // 分享失败了，是不是可以告诉用户：不要紧，可能是网络问题，一会儿再试试？
            },
            // 分享成功
            confirm:function (resp) {
                // 分享成功了，我们是不是可以做一些分享统计呢？
            },
            // 整个分享过程结束
            all:function (resp) {
                // 如果你做的是一个鼓励用户进行分享的产品，在这里是不是可以给用户一些反馈了？
            }
        };
     
        // 用户点开右上角popup菜单后，点击分享给好友，会执行下面这个代码
        Api.shareToFriend(wxData, wxCallbacks);
     
        // 点击分享到朋友圈，会执行下面这个代码
        Api.shareToTimeline(wxData, wxCallbacks);
     
        // 点击分享到腾讯微博，会执行下面这个代码
        Api.shareToWeibo(wxData, wxCallbacks);
    });
}


// 分享的时候生成一张图片分享
function wxShareIMG(url,data){
    // 所有功能必须包含在 WeixinApi.ready 中进行
    WeixinApi.ready(function(Api){
     
        // 分享的回调
        var wxCallbacks = {
            // 分享过程需要异步执行
            async : true,
            // 分享操作开始之前
            ready:function () {
                var self = this;
                // 假设你需要在这里发一个 ajax 请求去获取分享数据
                $.post(url,data,function(responseData){
                    // 可以解析reponseData得到wxData
                    var wxData = responseData;
                    // 调用dataLoaded方法，会自动触发分享操作
                    // 注意，当且仅当 async为true时，wxCallbacks.dataLoaded才会被初始化，并调用
                    self.dataLoaded(wxData);
                });
            }
            /* cancel、fail、confirm、all 方法同示例2，此处略掉 */
        };
     
        // 用户点开右上角popup菜单后，点击分享给好友，会执行下面这个代码
        Api.shareToFriend({}, wxCallbacks);
    });
}




// 调起微信客户端的图片播放组件进行播放
function imgSlider(){
    WeixinApi.ready(function(Api){
        var srcList = [];
        $.each($('img'),function(i,item){
           if(item.src) {
               srcList.push(item.src);
               $(item).click(function(e){
                   // 通过这个API就能直接调起微信客户端的图片播放组件了
                   Api.imagePreview(this.src,srcList);
               });
           }
        });
    });
}



/**
 * 调起微信Native的图片播放组件。
 * 这里必须对参数进行强检测，如果参数不合法，直接会导致微信客户端crash
 *
 * @param {String} curSrc 当前播放的图片地址
 * @param {Array} srcList 图片地址列表
 */
function imagePreview(curSrc,srcList) ;