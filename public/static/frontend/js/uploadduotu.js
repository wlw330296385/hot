if (jQuery) { 
// jQuery 已加载 
} else { 
    document.write('<script src="/static/frontend/js/jquery-3.2.1.min.js"></script>');   
} 
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
    fileNumLimit: 5,
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
    // var $li = $('#preview_'+window.id);
    var $li = $(".previewList");
    if ( eval('responce').status == 0 ) {
        // alert('上传失败');
        mui.toast('上传失败,请重试', {'duration':'long'});
    } else {
        mui.toast('上传成功', {'duration':'long'});
        $li.append("<li><i id='del'>X</i><img id='img' src="+responce.path+"></li>");

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

$(document).on( 'click', '#del', function() {
    $(this).parent().remove()
});

var covers ='';
$(function(){
    covers =[];
    $(document).ready(function(){
        $(".createBtn").on('click',function(){
            $(".previewList img").each(function(){
                covers.push($(this).attr('src'));
            }).get().join(",")
            console.log(covers)
        })
    })
    
})


