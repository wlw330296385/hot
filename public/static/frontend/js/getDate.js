/**!
 *
 * 1、日期格式拆分，时间戳转日期格式
 *
 */

//创建补0函数
function p(s) {
    return s < 10 ? '0' + s : s;
}

// 拿当前时间处理，将时间戳转成日期格式。示例：var time = getTimeYear(时间戳(153146314) * 1000); 获取time=2018-08-10 15:30
// return 时间--供前端将时间戳转成日期格式并拆分

//获取当前具体时间 2018-08-10 15:30
function getNowTime() {
    var _time = new Date();
    var year = _time.getFullYear();
    var month = _time.getMonth() + 1;
    var day = _time.getDate();
    var hours = _time.getHours();
    var minutes = _time.getMinutes();
    return p(year) + "-" + p(month) + "-" + p(day) + " " + p(hours) + ":" + p(minutes);
}

//获取当前年份 2018
function getTimeYear(y) {
    var _time = new Date(y);
    var year = _time.getFullYear();
    return p(year);
}

//获取当前年份+中文 2018年
function getTimeYearCn(y) {
    var _time = new Date(y);
    var year = _time.getFullYear();
    return p(year) + "年";
}

//获取当前月日+中文 08月10日
function getTimeMDCn(m) {
    var _time = new Date(m);
    var month = _time.getMonth() + 1;
    var day = _time.getDate();
    return p(month) + "月" + p(day) + "日"
}

//获取当前月份 08
function getTimeMonth(m) {
    var _time = new Date(m);
    var month = _time.getMonth() + 1;
    return p(month);
}

//获取当前日期 10
function getTimeDay(d) {
    var _time = new Date(d);
    var day = _time.getDate();
    return p(day);
}

//获取当前时间 15:30
function getTimeHM(hm) {
    var _time = new Date(hm); 
    var hours = _time.getHours();
    var minutes = _time.getMinutes();
    return p(hours) + ":" + p(minutes);
}


