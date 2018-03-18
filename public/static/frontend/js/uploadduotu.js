if (jQuery) {
    // jQuery 已加载 
} else {
    document.write('<script src="/static/frontend/js/jquery-3.2.1.min.js"></script>');
}
// 针对花絮小图多图上传实例
// 初始化Web Uploader
var uploaderOne = WebUploader.create({
    auto: true,
    server: uploadApiUrl,
    pick: '#filePickerOne',
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
});
// 上传过程
uploaderOne.on('uploadProgress', function (file, percentage) {
    mui.toast('正在上传...');
});
// 上传成功
uploaderOne.on('uploadSuccess', function (file, responce) {
    if (eval('responce').status == 0) {
        mui.toast('上传失败,请重试', { 'duration': 'long' });
    } else {
        mui.toast('上传成功', { 'duration': 'long' });
        var $li = '<div class="fl albumImg"><i class="delbtn mui-icon mui-icon-close"></i><img src="' + responce.path + '"></div>';
        $(".albumBox").append($li);
    }
});
// 上传失败
uploaderOne.on('uploadError', function (file, reason) {
    mui.alert('图片太大，上传失败');
});

//////////////////////////////////////////////////////////////////////////////////////// 

// 针对详情大图多图上传实例
// 初始化Web Uploader
var uploaderTwo = WebUploader.create({
    auto: true,
    server: uploadApiUrl,
    pick: '.filePickerTwo',
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
});
// 上传过程
uploaderTwo.on('uploadProgress', function (file, percentage) {
    mui.toast('正在上传...');
});
// 上传成功
uploaderTwo.on('uploadSuccess', function (file, responce) {
    console.log(responce);
    if (eval('responce').status == 0) {
        mui.toast('上传失败,请重试', { 'duration': 'long' });
    } else {
        mui.toast('上传成功', { 'duration': 'long' });
        var $li = '<div class="operationDiv"><i class="delbtn mui-icon mui-icon-close"></i><img class="desimg" src="' + responce.path + '" style="padding-top:5px"></div>';
        var getOptDiv = $(".uploadActive");
        if(getOptDiv.find(".bgorange").length==0){
            getOptDiv.append($li);
        }else{
            getOptDiv.find(".bgorange").removeClass("bgorange").after($li);
        }
    }
});
// 上传失败
uploaderTwo.on('uploadError', function (file, reason) {
    mui.alert('图片太大，上传失败');
});
