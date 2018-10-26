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


var star01 = '<i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star"></i><i class="mui-icon mui-icon-star"></i><i class="mui-icon mui-icon-star"></i><i class="mui-icon mui-icon-star"></i>';
var star02 = '<i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star"></i><i class="mui-icon mui-icon-star"></i><i class="mui-icon mui-icon-star"></i>';
var star03 = '<i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star"></i><i class="mui-icon mui-icon-star"></i>';
var star04 = '<i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star"></i>';
var star05 = '<i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star-filled"></i><i class="mui-icon mui-icon-star-filled"></i>';

// 星级显示
function fairnessStar(star) {
    if (star == 1) {
        $(".fairnessCont .icons").empty().append(star01);
        return star01;
    } else if (star == 2) {
        $(".fairnessCont .icons").empty().append(star02);
        return star02;
    } else if (star == 3) {
        $(".fairnessCont .icons").empty().append(star03);
        return star03;
    } else if (star == 4) {
        $(".fairnessCont .icons").empty().append(star04);
        return star04;
    } else if (star == 5) {
        $(".fairnessCont .icons").empty().append(star05);
        return star05;
    }
}

function punctualityStar(star) {
    if (star == 1) {
        $(".punctualityCont .icons").empty().append(star01);
        return star01;
    } else if (star == 2) {
        $(".punctualityCont .icons").empty().append(star02);
        return star02;
    } else if (star == 3) {
        $(".punctualityCont .icons").empty().append(star03);
        return star03;
    } else if (star == 4) {
        $(".punctualityCont .icons").empty().append(star04);
        return star04;
    } else if (star == 5) {
        $(".punctualityCont .icons").empty().append(star05);
        return star05;
    }
}

function professionStar(star) {
    if (star == 1) {
        $(".professionCont .icons").empty().append(star01);
        return star01;
    } else if (star == 2) {
        $(".professionCont .icons").empty().append(star02);
        return star02;
    } else if (star == 3) {
        $(".professionCont .icons").empty().append(star03);
        return star03;
    } else if (star == 4) {
        $(".professionCont .icons").empty().append(star04);
        return star04;
    } else if (star == 5) {
        $(".professionCont .icons").empty().append(star05);
        return star05;
    }
}

function attitudeStar(star) {
    if (star == 1) {
        $(".attitudeCont .icons").empty().append(star01);
        return star01;
    } else if (star == 2) {
        $(".attitudeCont .icons").empty().append(star02);
        return star02;
    } else if (star == 3) {
        $(".attitudeCont .icons").empty().append(star03);
        return star03;
    } else if (star == 4) {
        $(".attitudeCont .icons").empty().append(star04);
        return star04;
    } else if (star == 5) {
        $(".attitudeCont .icons").empty().append(star05);
        return star05;
    }
}