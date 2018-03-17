// 图片上传
window.id=0;
function add_id(id) {
    window.id=id;
    console.log(window.id);
}

// 初始化 webuloader
var uploader = WebUploader.create({
    auto: true,
    server: uploadApiUrl,
    pick: {
        id:'.filePicker',
        multiple: false
    },
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    },
    fileNumLimit: 1,
});
// 预览图
uploader.on('fileQueued', function(file) {
    var $li = $('#preview_'+window.id);
    uploader.makeThumb(file, function(error, src) {
        if (error) {

        }
        $li.attr('src', src);
    })
});
// 上传成功
uploader.on('uploadSuccess', function(file, responce) {
    //console.log(responce);
    var $li = $('#preview_'+window.id);
    if ( eval('responce').status == 0 ) {

    } else {
        $li.next().attr('value', responce.path);
    }
});
// 上传失败
uploader.on('uploadError', function(file) {

});