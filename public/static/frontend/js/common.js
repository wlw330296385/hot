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
