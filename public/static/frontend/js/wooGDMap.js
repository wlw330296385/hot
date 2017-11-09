
if (typeof jQuery == 'undefined') { 
document.write('<script src="/static/frontend/js/jquery-3.2.1.min.js"></script>');
} else { 
    
} 

document.write('<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.0&key=7568bf7e7c18c65a1fecd44762bcbd83"></script>');
var wooGDMap = {
    // 获取当前城市名称
    'currentCityInfo':function() {
            //实例化城市查询类
            var citysearch = new AMap.CitySearch();
            //自动获取用户IP，返回当前城市
            citysearch.getLocalCity(function (status, result) {
                if (status === 'complete' && result.info === 'OK') {
                    if (result && result.city) {
                        return result;
                    }
                } else {
                    return result.infocode;
                }
            });
    },
    'chooseLocation':function(keyword, adcode) {
            //接收url中传入的搜索值
            AMap.service(['AMap.PlaceSearch'], function () {
                //关键字查询
                var placeSearch = initSearch();
                placeSearch.setCity(adcode || '100000');
                placeSearch.search(keyword, function (status, result) {
                    if (status === 'complete' && result.info === 'OK') {
                        alert(result);
                    } else {
                         return result.infocode;
                    }
                });
            });
    },

}

  