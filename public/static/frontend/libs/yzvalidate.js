var user_Boolean = false;
var password_Boolean = false;
var varconfirm_Boolean = false;
var Mobile_Boolean = false;
//user
$('.reg_user').blur(function () {
    if ((/^[a-z0-9_-]{4,8}$/).test($(".reg_user").val())) {
        $('.user_hint').html("").css("color","green");
        user_Boolean = true;
    } else {
        $('.user_hint').html("请输入4-8位的英文或数字").css("color", "red");
        user_Boolean = false;
    }
});
// password
$('.reg_password').blur(function () {
    if ((/^[a-z0-9_-]{6,16}$/).test($(".reg_password").val())) {
        $('.password_hint').html("").css("color","green");
        password_Boolean = true;
    } else {
        $('.password_hint').html("请输入6-16位的密码").css("color", "red");
        password_Boolean = false;
    }
});


// password_confirm
$('.reg_confirm').blur(function () {
    if (($(".reg_password").val()) == ($(".reg_confirm").val())) {
        $('.confirm_hint').html("").css("color","green");
        varconfirm_Boolean = true;
    } else {
        $('.confirm_hint').html("两次密码输入不一致").css("color", "red");
        varconfirm_Boolean = false;
    }
});

 // Email
 $(".reg_email").blur(function(){
    var email =$(this).val();
    if(!/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(email)){
        $(".email_hint").text("请输入正确的邮箱格式").css("color", "red");
    }else{
        $('.email_hint').text("");
    }
})

// Mobile
$('.reg_mobile').blur(function () {
    if ((/^1[34578]\d{9}$/).test($(".reg_mobile").val())) {
        $('.mobile_hint').html("").css("color","green");
        Mobile_Boolean = true;
    } else {
        $('.mobile_hint').html("请输入正确的手机格式").css("color", "red");
        Mobile_Boolean = false;
    }
});

// Validate
// $(".reg_validate").blur(function(){
//     var validate =$(this).val();
//     if(!/^\d{6}$/.test(validate)){
//         $(".validate_hint").text("请输入正确的验证码").css("color", "red");
//         return false;
//     }else{
//         $('.validate_hint').text("");
//         return true;
//     }
// })

