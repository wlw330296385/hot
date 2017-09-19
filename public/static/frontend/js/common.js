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




//获取当前定位，并本地存储
function getSetLocation(locationApiUrl){
    mui.ajax({
        url:locationApiUrl,
        data: '',
        dataType: 'json',//服务器返回json格式数据
        type: 'post',//HTTP请求类型
        timeout: 10000,//超时时间设置为10秒；
        headers: {'Content-Type': 'application/json'},
        success: function (data) {
            if (data.code == 0) {
                var city = data.data.city;
                var province = data.data.region;
                //本地存储当前省市
                setLocalStorage(province,city);
            }
        },
        error: function (xhr, type, errorThrown) {
            console.log(xhr + type + errorThrown);
        }
    });
}
//设置定位本地存储
function setLocalStorage(province,city){
    var allArea = '';
    //本地存储当前省市
    localStorage.currentCity=city;
    localStorage.currentProvince=province;
    //获取当前城市各区，并组合成字符串存储
    $.each(cityData3, function(n1, jProvince) {
        if(jProvince.text==province) {
            $.each(jProvince.children, function (n2, jCity) {
                if(jCity.text==city) {
                    $.each(jCity.children, function (n3, jArea) {
                        allArea += jArea.text +',';
                    });
                    if(allArea.length>0){
                        allArea = allArea.substr(0, allArea.length - 1);
                    }
                    return false;
                }
            });
        }
    });
    //本地存储当前城市各区
    localStorage.currentAreas=allArea;
}
