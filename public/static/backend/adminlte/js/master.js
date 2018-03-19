$(function() {
    $('.pagination').addClass('pagination-sm no-margin pull-right')

    $('.del-btn').click(function() {
        if ( confirm('确定要删除记录吗? 不可恢复的喔~') ){
            return true;
        } else {
            return false;
        }

    });
});
