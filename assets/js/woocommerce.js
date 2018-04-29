(function($){
    $(window).load(function () {
        $.ajax({
            url: wc_cart_fragments_params.ajax_url,
            type:'POST',
            data:'action=memoo_get_cart_count',
            success: function(result) {
                $('.wc-mini-cart-wrapper .cart-count-total .number').text(result);
            },
            error: function(error) {
                $('.wc-mini-cart-wrapper .cart-count-total .number').text('0');
            }
        });
        $.ajax ({
            url: wc_cart_fragments_params.ajax_url,
            type:'POST',
            data:'action=memoo_get_mini_cart',

            success: function(results) {
                $('.wc-mini-cart-wrapper .wc-mini-cart').detach();
                $('.wc-mini-cart-wrapper').append(results);
            },
            error: function(error) {
                $('.wc-mini-cart-wrapper .wc-mini-cart').detach();
                $('.wc-mini-cart-wrapper').append(error);
            }
        });
    });
    $(document).ready(function() {
        $('.woocommerce .col-sidebar .widget-title').on('click', function(){
            $(this).parent().toggleClass('is-expanded');

            $(this).next().slideToggle('400');
        });

        $('.wrapper-dropdown').on('click', function(){
            $(this).toggleClass('active');
        });

        /*$('body').on('click', function(){
            $('.wrapper-dropdown').removeClass('active');
        });*/

        $('.wrapper-dropdown li a').on('click', function(e){
            e.preventDefault();

            $(this).parent().siblings().removeClass('selected');
            $(this).parent().addClass('selected');

            var span = $(this).parent().parent().siblings('.selected');
            var ul = $(this).parent().parent();
            var attribute_slug = ul.data('attribute_slug');
            var attribute_name = ul.data('attribute_name');
            var value = $(this).data('value');
            var select_id = ul.attr('id').replace('memoo_', '');
            var select = $('#'+select_id);

            if (select.length) {
                if (value != '') {
                    span.text(memoo.selected_custom_dropdown+$(this).text());
                } else {
                    span.text(attribute_name);
                }

                $('#'+select_id+' option').removeAttr('selected');
                select.val(value);
            }

            var $form = select.closest('form.cart');

            $form.trigger( 'check_variations' );
            $form.trigger( 'wc_variation_form' );

            $form.trigger( 'check_variations' );
            $form.trigger( 'woocommerce_variation_select_change' );
            $form.trigger( 'woocommerce_update_variation_values' );
            $form.trigger( 'woocommerce_variation_has_changed' );
        });

        // This button will increment the value
        //$('.qty-increment').on('click', function(e){
        $(document).on('click', '.qty-increment', function(e){
            e.preventDefault();

            var fieldName = $(this).data('field');
            var input = $(this).parent().parent().find('.quantity input.'+fieldName); //$('.quantity input.'+fieldName);


            var currentVal = parseInt(input.val());
            
            if (!isNaN(currentVal)) {
                if (currentVal < input.attr('max') || input.attr('max') === '' ) {
                    input.val(currentVal + 1);
                }
            } else {
                input.val(0);
            }
        });
        // This button will decrement the value till 0
        $(document).on('click', '.qty-decrement', function(e){
        //$('.qty-decrement').on('click', function(e) {
            e.preventDefault();

            fieldName = $(this).data('field');
            var input = $(this).parent().parent().find('.quantity input.'+fieldName);;
            var currentVal = parseInt(input.val());

            if (!isNaN(currentVal) && currentVal > 0) {
                if (currentVal > input.attr('min') ) {
                    input.val(currentVal - 1);
                }
            } else {
                input.val(0);
            }
        });

        $('.single_add_to_cart_button, .add_to_cart_button.ajax_add_to_cart').on('click', function(e) { //.add_to_cart_button
            if ($(this).hasClass('disabled') || $(this).is(':disabled')) {
                return;
            }

            if ($(this).data('product_id') != '' && $(this).data('product_id') != undefined) {
                //catalog / shop page
                var product_id = $(this).data('product_id');
                var quantity = $(this).data('quantity');

                var hasClass = $(this).parent().hasClass('product-type-variable');
                if (!hasClass) {
                    e.preventDefault();
                }
            } else {
                e.preventDefault();

                var product_id = $(this).val();
                var variation_id = $('input[name="variation_id"]').val();
                var quantity = parseInt($('input[name="quantity"]').val());
                var max = $('input[name="quantity"]').attr('max');
                var min = $('input[name="quantity"]').attr('min');

                var max = parseInt(max);
                var min = parseInt(min);

                if (product_id === '' && variation_id !== '') {
                    product_id = $('input[name="product_id"]').val();
                }

                if (quantity > max) {
                    $('input[name="quantity"]').val(max);
                    quantity = max;
                }

                if (quantity < min) {
                    $('input[name="quantity"]').val(min);
                    quantity = min;
                }
            }

            var btn = $(this);
            btn.prop('disabled', true);
            btn.addClass('loading-spinner');


            var qty_cart_header = $('.wc-mini-cart-wrapper .cart-count-total .number').text();
            var qty_cart_current = (+qty_cart_header) + (+quantity);

            if (variation_id !== '' && variation_id !== undefined) {
                $.ajax ({
                    url: wc_cart_fragments_params.ajax_url,
                    type:'POST',
                    data:'action=memoo_wc_add_cart_ajax_single_product&product_id=' + product_id + '&variation_id=' + variation_id + '&quantity=' + quantity,

                    success: function(results) {
                        $('.wc-mini-cart-wrapper .cart-count-total .number').text(qty_cart_current);
                        $('.wc-mini-cart-wrapper .wc-mini-cart').detach();
                        $('.wc-mini-cart-wrapper').append(results);
                        btn.removeAttr('disabled');
                        btn.removeClass('loading-spinner');

                        if (memoo.popup_enabled == 1 && memoo.popup_enabled !== '') {
                            $('.modal').removeClass('fade-out').addClass('fade-in');
                        } else {
                            btn.addClass('rubberBand');
                            btn.on('transitionend MSTransitionEnd webkitTransitionEnd oTransitionEnd', function() {
                                btn.removeClass('rubberBand');
                            });
                        }
                    },
                    error: function(error) {
                        btn.removeAttr('disabled');
                        btn.removeClass('loading-spinner');
                        console.log(error);

                        location.reload();
                    }
                });
            } else {
                $.ajax ({
                    url: wc_cart_fragments_params.ajax_url,
                    type:'POST',
                    data:'action=memoo_wc_add_cart_ajax_single_product&product_id=' + product_id + '&quantity=' + quantity,

                    success:function(results) {
                        $('.wc-mini-cart-wrapper .cart-count-total .number').text(qty_cart_current);
                        $('.wc-mini-cart-wrapper .wc-mini-cart').detach();
                        $('.wc-mini-cart-wrapper').append(results);
                        btn.removeAttr('disabled');
                        btn.removeClass('loading-spinner');

                        if (memoo.popup_enabled == 1 && memoo.popup_enabled !== '') {
                            $('.modal').removeClass('fade-out').addClass('fade-in');
                        } else {
                            btn.addClass('rubberBand');
                            btn.on('transitionend MSTransitionEnd webkitTransitionEnd oTransitionEnd', function() {
                                btn.removeClass('rubberBand');
                            });

                            var cart = $('#menu-4 .wc-mini-cart-wrapper');
                            var startpos = $(btn).parent().find('a.woocommerce-LoopProduct-link img');

                            var imgclone = $('<i class="fas fa-plus-circle"></i>').offset({
                                top: startpos.offset().top,
                                left: startpos.offset().left
                            }).css({
                                'opacity': '0.75',
                                'position': 'absolute',
                                'height': '50px',
                                'width': '50px',
                                'z-index': '999999',
                                'border-radius': '50%',
                                'background': '0',
                                'font-size': '50px',
                            }).appendTo('body').animate({
                                top: cart.offset().top,
                                left: cart.offset().left + cart.outerWidth()/2,
                                width: 25,
                                height: 25,
                                'font-size': 25
                            }, 400);

                            imgclone.animate({
                                'width': 0,
                                'height': 0,
                                'opacity': 0,
                                'font-size': 0,
                            }, function () {
                                $(this).detach()
                            });
                        }
                    },
                    error: function(error) {
                        btn.removeAttr('disabled');
                        btn.removeClass('loading-spinner');
                        console.log(error);

                        location.reload();
                    }
                });
            }
        });


        /*$('.archive .add_to_cart_button.ajax_add_to_cart').on('click', function () {
            var cart = $('#menu-4 .wc-mini-cart-wrapper');
            var startpos = $(this).parent().find('a.woocommerce-LoopProduct-link img');
            //var imgtodrag = $(this).parent().find('a.woocommerce-LoopProduct-link img');
            //if (imgtodrag) {
                if (memoo.popup_enabled == 1 && memoo.popup_enabled !== '') {
                    setTimeout(function(){
                        $('.modal').removeClass('fade-out').addClass('fade-in');
                    }, 1000);
                } else {
                    var imgclone = $('<i class="fas fa-plus-circle"></i>').offset({
                        top: startpos.offset().top,
                        left: startpos.offset().left
                    }).css({
                        'opacity': '0.75',
                        'position': 'absolute',
                        'height': '50px',
                        'width': '50px',
                        'z-index': '999999',
                        'border-radius': '50%',
                        'background': '0',
                        'font-size': '50px',
                    }).appendTo('body').animate({
                        top: cart.offset().top,
                        left: cart.offset().left + cart.outerWidth()/2,
                        width: 25,
                        height: 25,
                        'font-size': 25
                    }, 400);

                    imgclone.animate({
                        'width': 0,
                        'height': 0,
                        'opacity': 0,
                        'font-size': 0,
                    }, function () {
                        $(this).detach()
                    });
                }
            //}
        });*/

        $('body').on('click', function(e){
            if ($(e.target).hasClass('modal-overlay')){
                $('.modal').removeClass('fade-in').addClass('fade-out');
            }
        });

        $('.modal .button.button-underline').on('click', function(e){
            if ($('body').hasClass('archive')) {
                e.preventDefault();
                $('.modal').removeClass('fade-in').addClass('fade-out');
            }
        });

        var qtyDelayTimeout;

        $(document).on('click', '.actions .buttons-qty .btn', function () {
            window.clearTimeout(qtyDelayTimeout);
            qtyDelayTimeout = window.setTimeout(function(){
                $("[name='update_cart']").removeAttr('disabled');
                $("[name='update_cart']").trigger("click");
            }, 500);   
            //$('body').trigger('wc_update_cart');
        });
        $(document).on('blur', '.actions .quantity .qty', function () {
            $("[name='update_cart']").removeAttr('disabled');
            $("[name='update_cart']").trigger("click");   
            //$('body').trigger('wc_update_cart');
        });

        $(document).on('click', '.woocommerce-cart-coupon-form input[name="apply_coupon"]', function(e){
            e.preventDefault();

            apply_coupon($( '.woocommerce-cart-coupon-form' ))
        });

        var apply_coupon = function( $form ) {
            block( $form );

            var cart = this;
            var $text_field = $( '#coupon_code' );
            var coupon_code = $text_field.val();

            var data = {
                security: wc_cart_params.apply_coupon_nonce,
                coupon_code: coupon_code
            };

            $.ajax( {
                type:     'POST',
                url:      get_url( 'apply_coupon' ),
                data:     data,
                dataType: 'html',
                success: function( response ) {
                    //$( '.woocommerce-error, .woocommerce-message, .woocommerce-info' ).remove();
                    //show_notice( response );
                    var error = response.indexOf('woocommerce-error');
                    var string = response.slice(error, 17+error);

                    window.couponAppliedResponse = string;

                    var li_start = response.indexOf('<li>');
                    var li_end = response.indexOf('</li>');

                    var text = response.slice(li_start + 4, li_end);

                    $('.woocommerce-cart-coupon .coupon .error-message').text('');

                    if (string == 'woocommerce-error') {
                        $('.woocommerce-cart-coupon .coupon').addClass('error');
                        $('.woocommerce-cart-coupon .coupon .error-message').text(text);
                    } else {
                        $('.woocommerce-cart-coupon .coupon').addClass('success');
                    }

                    $( document.body ).trigger( 'applied_coupon', [ coupon_code ] );
                },
                complete: function() {
                    unblock( $form );
                    $text_field.val( '' );

                    if ( window.couponAppliedResponse != 'woocommerce-error') {
                        $( document.body ).trigger( 'wc_update_cart' );   
                    }
                }
            } );
        }

        var is_blocked = function( $node ) {
            return $node.is( '.processing' ) || $node.parents( '.processing' ).length;
        };

        var get_url = function( endpoint ) {
            return wc_cart_params.wc_ajax_url.toString().replace(
                '%%endpoint%%',
                endpoint
            );
        };

        var block = function( $node ) {
            if ( ! is_blocked( $node ) ) {
                $node.addClass( 'processing' ).block( {
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                } );
            }
        };

        var unblock = function( $node ) {
            $node.removeClass( 'processing' ).unblock();
        };
    });
})(jQuery);
