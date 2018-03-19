// webuploader实例化js
// 上传

var uploader1 = WebUploader.create({
    auto : true, //自动上传
    server : serverUrl, //处理路径
    pick : "#filePicker1", //选择文件按钮
    resize: false, //压缩
});
// 上传进度
uploader1.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#uploader-preview1' ),
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
uploader1.on( 'uploadSuccess', function( file, response ) {
    $( '#uploader-preview1' ).addClass('upload-state-done');
    //console.log(response);
    if ( response.err == 0 ) {
        $('#uploader-input1').val(response.data);
        $('#uploader-preview1').attr('src', response.data);
    } else {

    }
});
// 文件上传失败
uploader1.on( 'uploadError', function( file ) {
    var $li = $( '#uploader-preview1' ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});
// 完成上传完币,删除进度条
uploader1.on( 'uploadComplete', function( file ) {
    $( '#uploader-preview1' ).find('.progress').remove();
});


// -------
var uploader2 = WebUploader.create({
    auto : true, //自动上传
    server : serverUrl, //处理路径
    pick : "#filePicker2", //选择文件按钮
    resize: false, //压缩
});
// 上传进度
uploader2.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#uploader-preview2' ),
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
uploader2.on( 'uploadSuccess', function( file, response ) {
    $( '#uploader-preview2' ).addClass('upload-state-done');
    //console.log(response);
    if ( response.err == 0 ) {
        $('#uploader-input2').val(response.data);
        $('#uploader-preview2').attr('src', response.data);
    } else {

    }
});
// 文件上传失败
uploader2.on( 'uploadError', function( file ) {
    var $li = $( '#uploader-preview2' ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});
// 完成上传完币,删除进度条
uploader2.on( 'uploadComplete', function( file ) {
    $( '#uploader-preview2' ).find('.progress').remove();
});

//--------
var uploader3 = WebUploader.create({
    auto : true, //自动上传
    server : serverUrl, //处理路径
    pick : "#filePicker3", //选择文件按钮
    resize: false, //压缩
});
// 上传进度
uploader3.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#uploader-preview3' ),
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
uploader3.on( 'uploadSuccess', function( file, response ) {
    $( '#uploader-preview3' ).addClass('upload-state-done');
    //console.log(response);
    if ( response.err == 0 ) {
        $('#uploader-input3').val(response.data);
        $('#uploader-preview3').attr('src', response.data);
    } else {

    }
});
// 文件上传失败
uploader3.on( 'uploadError', function( file ) {
    var $li = $( '#uploader-preview3' ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});
// 完成上传完币,删除进度条
uploader3.on( 'uploadComplete', function( file ) {
    $( '#uploader-preview3' ).find('.progress').remove();
});