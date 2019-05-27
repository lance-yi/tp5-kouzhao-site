$(document).ready(function () {
    /** 初始化布局 */
    var height = $("#menu").height() - 70;
    $("#menu").height(height);
    $("#menu").addClass("master").height(height);
    var width = $("#master").width() - 160;
    $("#master").width(width);
    $("#master").height(height);

    /** header 导航*/
    $(".nav-top a").click(function (e) {
        e.preventDefault();

        $(".nav-top .selected").removeClass("selected");
        $(this).addClass("selected");
        var box = $(this).attr("href");

        $(".sub-nav").hide();

        $(box).show();
    });


    /** left 导航选中样式*/
    $(".sub-nav ul li a span").click(function () {
        $(".sub-nav ul li a span.selected-left").removeClass("selected-left");
        $(this).addClass("selected-left");
    });

    $('.sub-nav ul li a span').eq(0).addClass("selected-left");

    rowEven = $(".list-table tr:even");
    rowMouse = $(".list-table tr");

    // 鼠标经过、离开
    rowMouse.mouseover(function () {
        $(this).removeClass("double");
        $(this).addClass("over");
    });
    rowMouse.mouseout(function () {
        $(this).removeClass("over");
        rowEven.addClass("double");
    });

    rowEven.addClass("double"); // 双行

});

