/**
 * Created by Administrator on 10/3/2016.
 */

(function ($) {
    "use strict";
    var G5PlusTimeLine = {
        init: function () {
            G5PlusTimeLine.animated();
        },
        animated: function () {
            var wr_class = $('.time-line-item');
            $(window).on('scroll', function (event) {
                wr_class.each(function () {
                    var scrollBottom = $(window).scrollTop() + $(window).height(),
                        time_line_height = $(this).offset().top;
                    if (scrollBottom > time_line_height + 100) {
                        $(this).addClass('animated');
                    }
                });
            });
        }
    };
    $(document).ready(G5PlusTimeLine.init);
    $(window).resize(G5PlusTimeLine.init);
    $(window).load(G5PlusTimeLine.init);
})(jQuery);