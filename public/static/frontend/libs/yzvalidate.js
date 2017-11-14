// user

$('.reg_user').blur(function () {
    $('.validate-result span').remove('.user_yz');
    if ((/^[a-zA-Z0-9_\u4e00-\u9fa5]{6,15}$/).test($(".reg_user").val())==false) {
        $('.validate-result').append('<span class="user_yz">会员名只能包含英文、数字或中文，长度为6-15位</span>');
    }
});
// password
$('.reg_password').blur(function () {
    $('.validate-result span').remove('.password_yz');
    if ((/^[a-z0-9_-]{6,16}$/).test($(".reg_password").val())==false) {
        $('.validate-result').append('<span class="password_yz">密码长度为6-16位</span>');
    }
});


// password_confirm
$('.reg_confirm').blur(function () {
    $('.validate-result span').remove('.confirm_yz');
    if (($(".reg_password").val()) != ($(".reg_confirm").val())) {
        $('.validate-result').append('<span class="confirm_yz">两次密码输入不一致</span>');
    }
});


// Email
$('.reg_email').blur(function () {
    $('.validate-result span').remove('.email_yz');
    if ((/^[a-z\d]+(\.[a-z\d]+)*@([\da-z](-[\da-z])?)+(\.{1,2}[a-z]+)+$/).test($(".reg_email").val())==false) {
        $('.validate-result').append('<span class="email_yz">两次密码输入不一致</span>');
    }
});


// Mobile
$('.reg_mobile').blur(function () {
    $('.validate-result span').remove('.mobile_yz');
    if ((/^1[34578]\d{9}$/).test($(".reg_mobile").val())==false) {
        $('.validate-result').append('<span class="mobile_yz">请输入正确的手机格式</span>');
    }
});


// click
// $('.red_button').click(function () {
//     if (user_Boolean && password_Boolea && varconfirm_Boolean && emaile_Boolean && Mobile_Boolean == true) {
//         alert("注册成功");
//     } else {
//         alert("请完善信息");
//     }
// });
