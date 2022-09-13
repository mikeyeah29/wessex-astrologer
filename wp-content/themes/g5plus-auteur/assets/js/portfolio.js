var G5_Portfolio = window.G5_Portfolio || {};
(function ($) {
    "use strict";
    window.G5_Portfolio = G5_Portfolio;

    var $window = $(window),
        $body = $('body'),
        isLazy = $body.hasClass('gf-lazy-load'),
        isRTL = $body.hasClass('rtl');
    G5_Portfolio = {
        ajax_call: false,
        cache: {
            group: 'portfolio_gallery'
        },
        init: function () {
            this.light_box_gallery();
            var $portfolio_gallery = $('.gallery-layout-thumbnail');
            if ($portfolio_gallery.length) {
                this.single_portfolio_gallery($portfolio_gallery);
            }
            this.initJustifiedLayout();
            this.updateAjaxSuccess();
        },
        get_gallery_cache_key: function (id) {
            return 'portfolio_gallery_' + id;
        },
        light_box_gallery: function () {
            var _that = this;
            $(document).on('click', '[data-portfolio-gallery]', function (event) {
                event.preventDefault();
                if (_that.ajax_call !== false) {
                    return;
                }
                var $this = $(this),
                    item_inner = $this.closest('.portfolio-item-inner').addClass('active'),
                    id = parseInt($this.data('id'), 10),
                    cacheKey = _that.get_gallery_cache_key(id);
                $this.append('<i class="fal fa-spinner fa-spin"></i>');
                var cacheData = G5_Core.cache.getCache(cacheKey, _that.cache.group);
                if (cacheData !== '') {
                    _that.show_popup_gallery(cacheData);
                    $this.html('');
                    _that.ajax_call = false;
                    setTimeout(function () {
                        item_inner.removeClass('active')
                    }, 200);
                } else {
                    _that.ajax_call = $.ajax({
                        'url': g5plus_variable.ajax_url,
                        'data': {
                            action: 'portfolio_gallery',
                            id: id
                        },
                        success: function (response) {
                            _that.ajax_call = false;
                            $this.html('');
                            if (response.success) {
                                G5_Core.cache.addCache(cacheKey, response.data, _that.cache.group);
                                _that.show_popup_gallery(response.data);
                                setTimeout(function () {
                                    item_inner.removeClass('active')
                                }, 200);
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            setTimeout(function () {
                                item_inner.removeClass('active')
                            }, 200);
                        }
                    });
                }
            });
        },
        show_popup_gallery: function (data) {
            var type = data.type === 'video' ? 'iframe' : 'image';
            $.magnificPopup.open({
                type: type,
                mainClass: 'mfp-zoom-in',
                midClick: true,
                removalDelay: 500,
                items: data.items,
                gallery: {
                    enabled: true
                },
                callbacks: {
                    beforeOpen: function () {
                        // just a hack that adds mfp-anim class to markup
                        switch (this.st.type) {
                            case 'image':
                                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                                break;
                            case 'iframe' :
                                this.st.iframe.markup = this.st.iframe.markup.replace('mfp-iframe-scaler', 'mfp-iframe-scaler mfp-with-anim');
                                break;
                        }
                    },
                    change: function () {
                        var _this = this;
                        if (this.isOpen) {
                            this.wrap.removeClass('mfp-ready');
                            setTimeout(function () {
                                _this.wrap.addClass('mfp-ready');
                            }, 10);
                        }
                    }
                }
            });
        },
        single_portfolio_gallery: function ($portfolio_gallery) {
            var slider_main = $portfolio_gallery.find('.single-portfolio-gallery-main'),
                slider_thumb = $portfolio_gallery.find('.single-portfolio-gallery-thumb');

            slider_main.owlCarousel({
                items: 1,
                nav: false,
                dots: false,
                loop: false,
                rtl: isRTL,
                lazyLoad: isLazy
            }).on('changed.owl.carousel', syncPosition);

            slider_thumb.on('initialized.owl.carousel', function (event) {
                slider_thumb.find(".owl-item").eq(0).addClass("current");
            }).owlCarousel({
                items: 4,
                nav: false,
                dots: false,
                rtl: isRTL,
                lazyLoad: isLazy,
                margin: 10,
                responsive: {
                    992: {
                        items: 4
                    },
                    768: {
                        items: 3
                    },
                    0: {
                        items: 2
                    }
                }
            });

            function syncPosition(el) {
                //if you set loop to false, you have to restore this next line
                var current = el.item.index;

                slider_thumb
                    .find(".owl-item")
                    .removeClass("current")
                    .eq(current)
                    .addClass("current");
                var onscreen = slider_thumb.find('.owl-item.active').length - 1;
                var start = slider_thumb.find('.owl-item.active').first().index();
                var end = slider_thumb.find('.owl-item.active').last().index();

                if (current > end) {
                    slider_thumb.data('owl.carousel').to(current, 100, true);
                }
                if (current < start) {
                    slider_thumb.data('owl.carousel').to(current - onscreen, 100, true);
                }
            }

            slider_thumb.on("click", ".owl-item", function (e) {
                e.preventDefault();
                if ($(this).hasClass('current')) return;
                var number = $(this).index();
                slider_main.data('owl.carousel').to(number, 300, true);
            });

            $(document).on('reset_data', function (event) {
                slider_main.data('owl.carousel').to(0, 300, true);
            });
        },
        initJustifiedLayout: function ($container) {
            if (typeof($container) == 'undefined') {
                $container = $('body');
            }
            $('.layout-justified', $container).each(function () {
                var $this = $(this),
                    config = $this.data("justified-options"),
                    $row_height = config.row_height,
                    $max_row_height = config.row_max_height,
                    $margin = config.margin;
                if (!$this.hasClass('justified-init')) {
                    $this.imagesLoaded({background: true}, function () {
                        $this.justifiedGallery({
                            rowHeight: $row_height,
                            maxRowHeight: $max_row_height,
                            waitThumbnailsLoad: false,
                            selector: 'article.portfolio-grid',
                            margins: $margin,
                            lastRow: 'justify',
                            cssAnimation: true
                        }).on('jg.complete', function () {
                            $this.addClass('justified-init');
                            $('article.portfolio-grid', $this).each(function () {
                                var $div_thumbnail = '';
                                if ($('.entry-thumbnail-overlay', $(this)).length === 0) {
                                    $div_thumbnail = $('.portfolio-item-inner', $(this));
                                } else {
                                    $div_thumbnail = $('.entry-thumbnail-overlay', $(this));
                                }
                                var $height = $(this).height();
                                $div_thumbnail.css('height', $height + 'px');
                            });
                        }).on('jg.resize', function () {
                            $('article.portfolio-grid', $this).each(function () {
                                var $div_thumbnail = '';
                                if ($('.entry-thumbnail-overlay', $(this)).length === 0) {
                                    $div_thumbnail = $('.portfolio-item-inner', $(this));
                                }
                                else {
                                    $div_thumbnail = $('.entry-thumbnail-overlay', $(this));
                                }
                                var $height = $(this).height();
                                $div_thumbnail.css('height', $height + 'px');
                            });
                        });
                    });
                }
            });
        },
        updateAjaxSuccess: function () {
            var _that = this;
            $body.on('gf_pagination_ajax_success', function (event, _data,$ajaxHTML,target) {
                if (_data.settings['post_type'] === 'portfolio') {
                    $(event.target).imagesLoaded({background: true}, function () {
                        $('.layout-justified', $body).each(function () {
                            $(this).removeClass('justified-init');
                        });
                        setTimeout(function () {
                            G5_Portfolio.initJustifiedLayout();
                        }, 500)
                    });
                    G5_Core.pagination_ajax.updatePageTitle(_data,$ajaxHTML,target);
                    G5_Core.pagination_ajax.updateSideBar(_data,$ajaxHTML,target);

                }
            });
        }
    };

    $(document).ready(function () {
        G5_Portfolio.init();
    });

})(jQuery);
