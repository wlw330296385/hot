/**!
 * 公用功能包括：
 *
 * 1、获取性别值（1/0）返回图片地址
 * 2、
 *
 */


//获取性别值（1/0）返回图片地址
function getSexIconUrl(sexNum) {
	var iconUrl='';
    if (sexNum==1) {
        iconUrl = "/static/frontend/images/male.png";
    }else{
        iconUrl = "/static/frontend/images/female.png";
	}
	return iconUrl;
}




// =========================定位====================================



var x = "";  
    var y = "";  
    var dizhi = "";  
 
    function getLocation(){  
        if (navigator.geolocation) {  
            navigator.geolocation.getCurrentPosition(showPosition,showError);  
        }else{  
            mui.toast("浏览器不支持地理定位。");  
        }  
    }  
 
    function showPosition(position){  
      
 
        y = position.coords.latitude;//纬度  
        x = position.coords.longitude;//经度  
           
 
        // 百度地图API功能  
        //GPS坐标  
        var x = 116.32715863448607;  
        var y = 39.990912172420714;  
        var ggPoint = new BMap.Point(x, y);  
           
        //地图初始化  
        var bm = new BMap.Map("allmap");  
 
        bm.centerAndZoom(ggPoint, 15);  
        bm.addControl(new BMap.NavigationControl());  
        bm.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用  
        bm.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用  
        bm.addEventListener("tilesloaded", function () { });//地图加载完成  
 
        var gc = new BMap.Geocoder();  
 
 
        bm.addEventListener("click", function (e) {  
               
            ggPoint = new BMap.Point(e.point.lng, e.point.lat);  
            gc.getLocation(ggPoint, function (rs) {  
                  
                var addComp = rs.addressComponents;  
                var mapAddress = addComp.province + addComp.city + addComp.district  
                + addComp.street + addComp.streetNumber;  
 
                dizhi = mapAddress;  
 
                if (confirm(dizhi)) {  
                    window.location.href = "succes.html" 
                }  
 
                var marker = new BMap.Marker(ggPoint); // 创建点  
                bm.addOverlay(marker);  
                var label = new BMap.Label("您选择的位置为"+dizhi, { offset: new BMap.Size(20, -10) });  
                marker.setLabel(label); //添加百度label  
                bm.setCenter(ggPoint);  
            });  
        });  
           
              
          
 
        bm.addControl(new BMap.NavigationControl());  
 
 
 
        //坐标转换完之后的回调函数  
        translateCallback = function (data) {  
            if (data.status === 0) {  
                var marker = new BMap.Marker(data.points[0]);  
                bm.addOverlay(marker);  
                marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画  
                //marker.enableDragging();//可拖拽  
                //var label = new BMap.Label("您所在的位置", { offset: new BMap.Size(20, -10) });  
                //marker.setLabel(label); //添加百度label  
                //bm.setCenter(data.points[0]);  
 
                  
 
                //var a=BMap.Convertor(ggPoint, 0);  
 
 
                gc.getLocation(data.points[0], function (rs) {  
                    //mui.toast(rs.sematic_description);  
 
                    var addComp = rs.addressComponents;  
                    var mapAddress = addComp.province + addComp.city + addComp.district  
                    + addComp.street + addComp.streetNumber;  
 
                    dizhi = mapAddress;  
 
                    confirm(dizhi);  
                    if (confirm(dizhi)) {  
                        window.location.href = "succes.html" 
                    }  
 
                    var label = new BMap.Label("定位您所在的位置为"+dizhi, { offset: new BMap.Size(20, -10) });  
                    marker.setLabel(label); //添加百度label  
                    bm.setCenter(data.points[0]);  
 
                });  
                                      
            }  
        }  
 
        setTimeout(function () {  
            var convertor = new BMap.Convertor();  
            var pointArr = []  
            pointArr.push(ggPoint);  
            convertor.translate(pointArr, 1, 5, translateCallback)  
        }, 1000);  
 
 
    }  
 
    function showError(error){  
        switch(error.code) {  
            case error.PERMISSION_DENIED:  
                mui.toast("定位失败,用户拒绝请求地理定位");  
                break;  
            case error.POSITION_UNAVAILABLE:  
                mui.toast("定位失败,位置信息是不可用");  
                break;  
            case error.TIMEOUT:  
                mui.toast("定位失败,请求获取用户位置超时");  
                break;  
            case error.UNKNOWN_ERROR:  
                mui.toast("定位失败,定位系统失效");  
                break;  
        }  
    }  
 
// ===============================定位结束==========================

    getLocation();  

