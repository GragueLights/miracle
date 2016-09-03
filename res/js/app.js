/**
 * Created by xiao on 16/8/30.
 */
(function (win,doc,$) {
    var path = window.location.pathname;
    if(path=='/club'){
        console.log(path)
        $(".menu .item-club").addClass("active");
    }else if(path=='/business'){
        $(".menu .item-business").addClass("active");

    }else if(path=='/history'){
        $(".menu .item-history").addClass("active");

    }else if(path=='/me'){
        $(".menu .item-me").addClass("active");
    }
})(window,document,window.$);




