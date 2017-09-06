// webuploader实例化js
// 上传
var uploader = WebUploader.create({
    auto : true, //自动上传
    server : serverUrl, //处理路径
    pick : "#filePicker", //选择文件按钮
    resize: false, //压缩image
    accept : {title:'Images', extensions:'gif,jpg,jpeg,bmp,png', mineTypes:'images/*'} //只允许选择图片文件
});
// 上传进度
uploader.on( 'uploadProgress', function( file, percentage ) {
    $('#uploader-preview').removeClass('hidden');
    var $li = $( '#uploader-preview' ),
        $percent = $li.find('.progress .progress-bar');

    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<div class="progress"><div class="progress-bar"></div></div>')
            .appendTo( $li )
            .find('.progress-bar');
    }

    $percent.css( 'width', percentage * 100 + '%' );
});
// 文件上传成功
uploader.on( 'uploadSuccess', function( file, response ) {
    $( '#uploader-preview' ).addClass('upload-state-done');
    //console.log(response);
    if ( eval('response').status == 0 ) {

    } else {
        $('#uploader-input').attr('value', response.id);
        $('#uploader-preview img').attr('src', response.path);
    }
});
// 文件上传失败
uploader.on( 'uploadError', function( file ) {
    var $li = $( '#uploader-preview' ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});
// 完成上传完币,删除进度条
uploader.on( 'uploadComplete', function( file ) {
    $( '#uploader-preview' ).find('.progress').remove();
});
$(document).on( 'click', '#uploader-preview .remove-picture', function() {
    $('#uploader-input').val('');
    $('#uploader-preview').addClass('hidden');
});