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
/*uploader.on('fileQueued', function(file) {
    var $li = $('#preview_'+window.id);
    uploader.makeThumb(file, function(error, src) {
        if (error) {

        }
        $li.attr('src', src);
    })
});*/
// 上传过程
uploader.on('uploadProgress', function(file, percentage){
    mui.toast('正在上传...');
   /* var container = mui("#p1");
    if (container.progressbar({
            progress: 0
        }).show()) {
        simulateLoading(container, percentage*100);
    }*/
});
// 上传成功
uploader.on('uploadSuccess', function(file, responce) {
    //console.log(responce);
    var $li = $('#preview_'+window.id);
    if ( eval('responce').status == 0 ) {
        // alert('上传失败');
        mui.toast('上传失败,请重试', {'duration':'long'});
    } else {
        mui.toast('上传成功', {'duration':'long'});
        $li.attr('src', responce.path);
        $li.next().attr('value', responce.path);
    }
});
// 上传失败
uploader.on('uploadError', function(file, reason) {
    // alert('上传的图片有问题,请换另一张');
    mui.alert('上传的图片有问题,请换另一张');
});

function simulateLoading(container, progress) {
    if (typeof container === 'number') {
        progress = container;
        container = 'body';
    }
    setTimeout(function() {
        // progress += Math.random() * 20;
        mui(container).progressbar().setProgress(progress);
        if (progress < 100) {
            simulateLoading(container, progress);
        } else {
            mui(container).progressbar().hide();
        }
    }, Math.random() * 200 + 200);
}