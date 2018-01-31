/**!
 * 公用功能包括：
 *
 * 1、获取性别值（1/0）返回图片地址
 * 2、定位当前城市，并本地存储
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



//获取当前定位，并返回值
function getLocationApi(locationApiUrl) {

    if(window.localStorage){
        //判断是否有本地存储城市
        //重要提示：如有增减修改本地存储变量，必须更新updatetime的时间，这样客户端可重新获取最新的区域本地存储值
        if(localStorage.currentCity==''||localStorage.currentCity==null||localStorage.currentCity=='undefined'||localStorage.updatetime!='201812181650'){
            var city = '';
            var province = '';
            var area = '';
            var areas = '';
            mui.ajax({
                url: locationApiUrl,
                data: '',
                dataType: 'json',//服务器返回json格式数据
                type: 'post',//HTTP请求类型
                timeout: 10000,//超时时间设置为10秒；
                headers: {'Content-Type': 'application/json'},
                async:false, //设置为false后会在success执行完才继续后面代码
                success: function (msg) {
                    var data = JSON.parse(msg);
                    if (data.code == 0) {
                        area = data.data.area;
                        city = data.data.city;
                        province = data.data.region;
                        areas = getAreas(province,city);
                    }else{
                        //返回默认定位 Default Location
                        var getDL = getDefaultLCT();
                        city = getDL['city'];
                        province = getDL['province'];
                        area = getDL['area'];
                        areas = getDL['areas'];
                    }
                },
                error: function (xhr, type, errorThrown) {
                    //console.log(xhr + type + errorThrown);
                    //返回默认定位 Default Location
                    var getDL = getDefaultLCT();
                    city = getDL['city'];
                    province = getDL['province'];
                    area = getDL['area'];
                    areas = getDL['areas'];
                }
            });
            localStorage.currentCity = city;
            localStorage.currentProvince = province;
            localStorage.currentArea = area;
            localStorage.currentAreas = areas;
            localStorage.updatetime = "201812181650";
        }
        var returnLocation = {"province":localStorage.currentProvince,"city":localStorage.currentCity,"area":localStorage.currentArea,"areas":localStorage.currentAreas};
        return returnLocation;
    }else{
        //返回默认定位
        return getDefaultLCT();
    }
}
//获取当前城市各区，并组合成字符串存储
function getAreas(province,city) {
    var areas='';
    $.each(cityData3, function (n1, jProvince) {
        if (jProvince.text == province) {
            $.each(jProvince.children, function (n2, jCity) {
                if (jCity.text == city) {
                    $.each(jCity.children, function (n3, jArea) {
                        areas += jArea.text + ',';
                    });
                    if (areas.length > 0) {
                        areas = areas.substr(0, areas.length - 1);
                    }
                    return false
                }
            });
        }
    });
    return areas;
}
//获取默认省市区
function getDefaultLCT() {
    var defaultLocation = {"province":"广东省","city":"深圳市","area":"南山区","areas":"罗湖区,福田区,南山区,宝安区,龙岗区,龙华区,盐田区,光明新区,其他区"};
    return defaultLocation
}