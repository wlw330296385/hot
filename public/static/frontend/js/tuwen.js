/**!
 * 公用功能包括：
 *
 *  篮球管家简易版图文插件
 *
 */

$(function () {

    ////////////////////////////// 编辑页面专用：图文转换成可编辑状态

    $(".operationDiv h5").each(function (i) {
        $(this).parent().empty().html('<div contenteditable="true" placeholder="请输入标题" class="title">'+$(this).text()+'</div>');
    });
    $(".operationDiv p").each(function (i) {
        $(this).parent().empty().html('<div contenteditable="true" placeholder="请输入正文" class="textarea">'+$(this).text()+'</div>');
    });

    /////////////////////////////// 图文操作功能开始

    $(document).bind("click",function(e){
        //点击introBoxh和mui-row-operation a之外则触发
        if($(e.target).closest(".introBox").length == 0 && $(e.target).closest(".mui-row-operation a").length == 0){
            $(".introBox .operationDiv").removeClass("bgorange")
        }
    })

    //添加图片检查是否大于10张
    $(document).on('tap', '.filePickerTwo', function () {
        //用于标记哪个大区域（intrBox）插入图片
        $(".introBox").removeClass("uploadActive");
        var toIntroBox = $(this).parentsUntil('.mui-input-row').parent().find(".introBox");
        toIntroBox.addClass("uploadActive");
        /////////////////////////////////
        if (toIntroBox.find('.desimg').length >= 10) {
            mui.toast('上传的图片建议在10张之内，不然用户打开您的页面会很慢哦！');
        }
    });

    //添加活动详情标题
    $(".titleClass").on('tap', '', function () {
        $(".introBox .operationDiv .delbtn").remove();
        var title = '<div class="operationDiv bgorange"><i class="delbtn mui-icon mui-icon-close"></i><div contenteditable="true" placeholder="请输入标题" class="title"></div></div>';
        var getOptDiv = $(this).parentsUntil('.mui-input-row').parent().find(".introBox");
        if(getOptDiv.find(".bgorange").length==0){
            getOptDiv.append(title);
        }else{
            getOptDiv.find(".bgorange").removeClass("bgorange").after(title);
        }

    });

    //添加活动详情正文
    $(".textClass").on('tap', '', function () {
        $(".introBox .operationDiv .delbtn").remove();
        var text = '<div class="operationDiv bgorange"><i class="delbtn mui-icon mui-icon-close"></i><div contenteditable="true" placeholder="请输入正文" class="textarea"></div></div>';
        var getOptDiv = $(this).parentsUntil('.mui-input-row').parent().find(".introBox");
        if(getOptDiv.find(".bgorange").length==0){
            getOptDiv.append(text);
        }else{
            getOptDiv.find(".bgorange").removeClass("bgorange").after(text);
        }
    });

    //删除操作
    $(document).on('tap', '.delbtn', function () {
        $(this).parent().remove();
    });

    // 点击时把加上背景色去除和显示图标隐藏
    $(document).on('tap', '.operationDiv div.title, .operationDiv div.textarea, .operationDiv .desimg', function () {
        $(".introBox .operationDiv").removeClass("bgorange");
        $(".introBox .operationDiv .delbtn").remove();
        $(this).before('<i class="delbtn mui-icon mui-icon-close"></i>');
        $(this).parent().addClass("bgorange");
    });
    // 焦点离开后把背景色去除和删除图标隐藏
    $(document).on('blur', '.operationDiv div.title ,.operationDiv div.textarea, .operationDiv .desimg', function () {
        $(this).siblings(".delbtn").remove();
        // $(this).parent().removeClass("bgorange");
    });

    // 上移动
    $(document).on('tap', '.up', function () {
        if($(".introBox .bgorange").length==0){
            mui.toast('请先选中您要移位的区域！');
        }else{
            var selectOrange = $(".bgorange");
            selectOrange.prev().insertAfter(".bgorange");
        }
    });
    // 上移动
    $(document).on('tap', '.down', function () {
        $(".bgorange").next().insertBefore(".bgorange");
    });

    ////////////////////////////////////////////////////////////// 图文详情结束


    //此段代码用于提交时转化
    //图文编辑状态转换浏览状态
    // $(".introBox .operationDiv .delbtn").remove();
    // $(".introBox .operationDiv").removeClass("bgorange");
    // $(".operationDiv div.title").each(function (i) {
    //     $(this).parent().empty().html('<h5>'+$(this).text()+'</h5>');
    // });
    // $(".operationDiv div.textarea").each(function (i) {
    //     $(this).parent().empty().html('<p>'+$(this).text()+'</p>');
    // });
})