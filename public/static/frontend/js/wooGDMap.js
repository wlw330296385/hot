





var map, geolocation;
        // 注册一个地图并初始化到当前定位城市
    map = new AMap.Map('mapContainer', {
        resizeEnable: true
    });


    // 获取用户所在城市信息(未调试)
    var getCurrentCityInfo = function() {
            //实例化城市查询类
            var citysearch = new AMap.getCity();

            //自动获取用户IP，返回当前城市
            citysearch.getLocalCity(function (status, result) {
                if (status === 'complete' && result.info === 'OK') {
                    if (result && result.city) {
                        console.log('获取用户所在城市信息');
                        console.log(result);
                        return result;
                    }
                } else {
                    console.log('获取用户所在城市信息错误信息');
                    console.log(result.infocode);
                    return result.infocode;
                }
            });
    };
    // 搜索一个地名(未调试)
    var chooseLocation = function(keyword, adcode) {
            //接收url中传入的搜索值
            AMap.service(['AMap.PlaceSearch'], function () {
                //关键字查询
                var placeSearch = initSearch();
                placeSearch.setCity(adcode || '100000');
                placeSearch.search(keyword, function (status, result) {
                    if (status === 'complete' && result.info === 'OK') {
                        console.log('搜索一个地名');
                        console.log(result);
                    } else {
                        console.log('搜索一个地名错误信息');
                         return result.infocode;
                    }
                });
            });
    };


    // 获取用户当前坐标(已调试)
    var getGeoLocation = function(){
        // 声明方法
        map.plugin('AMap.Geolocation', function () {
            geolocation = new AMap.Geolocation({
                enableHighAccuracy: true,//是否使用高精度定位，默认:true
                timeout: 3000,           //超过3秒后停止定位，默认：无穷大
                maximumAge: 0,           //定位结果缓存0毫秒，默认：0
                convert: true,           //自动偏移坐标，偏移后的坐标为高德坐标，默认：true
                showButton: true,        //显示定位按钮，默认：true
                buttonPosition: 'LB',    //定位按钮停靠位置，默认：'LB'，左下角
                buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
                showMarker: true,        //定位成功后在定位到的位置显示点标记，默认：true
                showCircle: true,        //定位成功后用圆圈表示定位精度范围，默认：true
                panToLocation: true,     //定位成功后将定位到的位置作为地图中心点，默认：true
                zoomToAccuracy:true      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
            });


                geolocation.getCurrentPosition();
                AMap.event.addListener(geolocation, 'complete', onComplete);//返回定位信息
                AMap.event.addListener(geolocation, 'error', onError);      //返回定位出错信息
        })


          //解析定位结果
        function onComplete(data) {
            // var str=['定位成功'];
            // str.push('经度：' + data.position.getLng());
            // str.push('纬度：' + data.position.getLat());
            // if(data.accuracy){
            //      str.push('精度：' + data.accuracy + ' 米');
            // }//如为IP精确定位结果则没有精度信息
            // str.push('是否经过偏移：' + (data.isConverted ? '是' : '否'));
            // console.log(str);
            var result = [];
            result.push({Lng:data.position.getLng()});
            result.push({Lat:data.position.getLat()});
            if(data.accuracy){
                 result.push({accuracy : data.accuracy});
            }//如为IP精确定位结果则没有精度信息
            result.push({isConverted:(data.isConverted ? 1 : 0)});
            console.log('获取经纬度');
            console.log(result);
            return result;
        };
        //解析定位错误信息
        function onError(data) {
            return false;
        };
    };




  