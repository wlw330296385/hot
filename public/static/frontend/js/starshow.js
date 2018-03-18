// 星级显示
function starShow(star) {
    
    var star1 = '<i data-index="1" class="mui-icon mui-icon-star-filled"></i>';
    var star2 = '<i data-index="1" class="mui-icon mui-icon-star-filled"></i><i data-index="2" class="mui-icon mui-icon-star-filled"></i>';
    var star3 = '<i data-index="1" class="mui-icon mui-icon-star-filled"></i><i data-index="2" class="mui-icon mui-icon-star-filled"></i><i data-index="3" class="mui-icon mui-icon-star-filled"></i>';
    var star4 = '<i data-index="1" class="mui-icon mui-icon-star-filled"></i><i data-index="2" class="mui-icon mui-icon-star-filled"></i><i data-index="3" class="mui-icon mui-icon-star-filled"></i><i data-index="4" class="mui-icon mui-icon-star-filled"></i>';
    var star5 = '<i data-index="1" class="mui-icon mui-icon-star-filled"></i><i data-index="2" class="mui-icon mui-icon-star-filled"></i><i data-index="3" class="mui-icon mui-icon-star-filled"></i><i data-index="4" class="mui-icon mui-icon-star-filled"></i><i data-index="5" class="mui-icon mui-icon-star-filled"></i>';

    if (star == 1) {
        $(".icons").empty().append(star1);
        return star1;
    } else if (star == 2) {
        $(".icons").empty().append(star2);
        return star2;
    } else if (star == 3) {
        $(".icons").empty().append(star3);
        return star3;
    } else if (star == 4) {
        $(".icons").empty().append(star4);
        return star4;
    } else if (star == 5) {
        $(".icons").empty().append(star5);
        return star5;
    }
}

