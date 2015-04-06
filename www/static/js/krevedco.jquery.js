(function($){
    $.fn.krevedco = function( orguments ){
        var o = $.extend({
                datepicker: '.endDatePicker',
                modal: '#newAdvert',
                login: '#loginModal',
                alert: '.alert-div',
                locale: {
                    selected: localStorage.getItem('lang') || 'ru',
                    class: '.translateMe',
                    available: {
                        'ru': 'Русский',
                        'ua': 'Українська',
                        'en': 'English'
                    }
                },
                debug: false,
                loginAddress: 'http://192.168.55.55/server/login.php'
            }, orguments),

        

            todo = this,

            //Cache. OMG LOL
            cache = {
                adverts: {},
                categories: {}
            },
            
            locale = {},
            handlers = {
                postError: function( error ){
                    var err = '';
                    if(o.debug){
                        err = '<br>' + error.responseText;
                    }

                    console.log( 'POST ERROR: ', error.responseText );
                    m.alert( locale.errors.client.failedSend + err );
                },
                getError: function( error ){
                    console.log('ERROR: ', error.responseText);
                }
            },
            animate = {
                  loading: function( target, text ){
                    var original = $(target).html();
                    var i = 0;
                    var A;

                    function startFun(){
                        A = setInterval(function(){
                            var display = text;
                            for(n=0; n < i; n++){
                                display += '.';
                            }
                            i = i < 3 ? i + 1 : 0;
                            $(target).html(display);
                        }, 300);
                    }
                        
                    return {
                        start: function(){
                            startFun();
                        },
                        stop: function(){
                            window.clearInterval(A);
                        },
                        update: function(text){
                            window.clearInterval(A);
                            $(target).html(text);
                        },
                        reset: function(){
                            window.clearInterval(A);
                            $(target).html(original);
                        }
                    }
                }
            },
            m = {
                alert: function(msg){
                    $( o.alert ).append('<div data-alert class="alert-box alert">' + msg + '<a href="#" class="close">&times;</a></div>');
                    $(document).foundation('alert', 'reflow');
                },
                success: function(msg){
                    $( o.alert ).append('<div data-alert class="alert-box success">' + msg + '<a href="#" class="close">&times;</a></div>');
                    $(document).foundation('alert', 'reflow');
                }
            }

            validate = {
                email: function( value ) {
                    return /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test( value );
                },

                url: function( value ) {
                    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test( value );
                },

                date: function( value ) {
                    return !/Invalid|NaN/.test( new Date( value ).toString() );
                },

                dateISO: function( value ) {
                    return /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test( value );
                },

                number: function( value ) {
                    return /^[\d\+\s]+$/.test( value );
                },

                title: function( value ) {
                    return value.split('').length <= 57;
                },

                text: function( value ) {
                    return value.split('').length <= 10000;
                },

                category:  function( value ) {
                    return cache.categories[ value ] !== undefined;
                }
            },

            //Models for Adverts, Categories and Modal window.
            models = {
                advert: function( data ){
                    return '<a href="#" class="modal-reveal" data-id="' + data.id + '">' + 
                                '<div class="large-3 columns item" data-id="' + data.id + '">' +
                                    '<img src="http://placehold.it/1000x1000&amp;text=Thumbnail">' +
                                    '<div class="panel">' +
                                        '<h5>' + data.title  + '</h5>' +
                                        '<p>' + data.text + '</p>' +
                                    '</div>' +
                                '</div></a>';
                }, 
                category: function( id, name ){
                    return {
                        link: '<li class="tab-title" role="presentational" ><a href="#cat-' + id + '" role="tab" tabindex="0"aria-selected="false" controls="cat-' + id + '">' + name + '</a></li>',
                        tab: '  <section role="tabpanel" aria-hidden="false" class="content" id="cat-' + id + '"><div class="large-12 columns items"></div></section>'
                    }
                },
                modal: function( data ){
                    return  '<div id="myModal" class="reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">' +
                                '<div class="large-4 columns">' +
                                    '<div class="modal image" style="background-image: url(\'' + 'http://placehold.it/1000x1000&amp;text=Thumbnail' + '\');"> </div>' +
                                '</div>' +
                                '<div class="large-8 columns">' +
                                    '<small>Published on ' + data.startDate + ' | Closing on ' + data.endDate + '</small><br/>' +
                                    '<h1>' + data.title + '</h1><br/>' +
                                    '<p>' + data.text + '</p>' +
                                '</div>' +
                                '<a class="close-reveal-modal" aria-label="Close">&#215;</a>' +
                            '</div>';
                }
            };


            render = {
                categories: function( parent, data ){
                        //Iteration through the categories
                    for( category of data ){

                        //Save category to cache
                        cache.categories[category.id] = category;

                        var catappend = models.category( category.id, category.name );

                        //Create tab
                        $(parent).append( catappend.tab );

                        //Create tab-link
                        $( o.links ).append( catappend.link );

                        //Add categories to options in modal form
                        $( 'select', o.modal).append('<option value="' + category.id + '">' + category.name + '</option>');
                    };
                },
                adverts: function( parent, data ){
                    //Iteration through the categories
                    for( advert of data ){


                        // //Checks if advert is not outdated. 
                        if( Date.parse(advert.endDate) > Date.now() ){

                            //Save advert to cache
                            cache.adverts[advert.id] = advert;

                            //Add item
                            this.addAdvert(parent, advert);
                            
                        }
                        
                    };
                },
                addAdvert: function( parent, data ){
                    $( 'section#cat-' + data.categoryId + ' > .items', parent ).append( models.advert(data) );
                    $(document).foundation('reveal', 'reflow');
                },
                locale: function(){
                    $(o.locale.class).each(function(){
                        var tid = $(this).data('tid');
                        $(this).text(locale.frontend[tid]);
                    })
                    $('.loading').remove();
                },
                languages: function(){
                    for(key of Object.keys(o.locale.available)){
                        $('.languages').append('<li><a href="#" class="lang" data-lang="' + key + '">' + o.locale.available[key] + '</a></li>')
                    }
                }
            };

        $.getJSON( 'locale/' + o.locale.selected + '.locale.json' ).done(function( l ){
            locale = l;
            cache.categories = locale.categories;
            todo.each(function(){
                render.categories(this, locale.categories);
            })

            $.getJSON( o.source ).done(function( data ){
                
                todo.each(function(){
                    render.adverts(this, data.adverts);
                    render.locale();
                    render.languages();
                })

            }).fail(handlers.getError);

        }).fail(handlers.getError);
       


        /*----------HANDLERS----------*/

        //Event handler for modal windows
        $(document).on( 'click', '.modal-reveal', function(){

            //Get items id
            var id = $(this).data('id');

            //Retrieves advert from cache
            var info = cache.adverts[id];

            //Generates new modal
            var modal = models.modal( info )

            //Reveals modal
            $(modal).foundation( 'reveal', 'open' );
        });

        //Form validation form
        $(document).on( 'click', '.sbmt', function(){

            var ok = true;
            var post = {};
            var st = $(this).parents().eq(2);

            //Resets errors
            $( 'small.error', st ).remove();
            $( '.error', st ).removeClass('error');

            $( 'input, select, textarea', st ).each(function(){
                var field = {
                    value: $(this).val(),
                    type: $(this).data('type'),
                    name: $(this).attr('name'),
                    sid: $(this).data('sid')
                }

                if(field.value){

                    if(!validate[field.type](field.value)){
                        ok = false;
                        $(this).addClass( 'error' );
                        $(this).after( '<small class="error">' + locale.errors.client.failedValidate.replace('%field%', field.name) + '</small>' );
                    }else{
                        post[field.sid] = field.value;
                    }

                }else{
                    ok = false;
                    $(this).addClass( 'error' );
                    $(this).after( '<small class="error">' + locale.errors.client.emptyField + '</small>' );
                }
                
            }).promise().done(function(){
                if(ok){
                    $( o.modal ).foundation('reveal', 'close');
                    $.post( o.source, post, function( data ){
                        var msg = '';

                        if(o.debug){
                            msg = '<br>' + data;
                            console.log('POST SUCCESS: ', data);
                        }

                        if(data.status === 200){
                            cache.adverts[data.advert.id] = data.advert;
                            render.addAdvert($(todo)[0], data.advert);
                            m.success( locale.errors.client.successAdded + msg );
                        }else{
                            m.alert( data.errorMessage );
                        }

                    }).fail(handlers.postError)
                }
            });
        });
        /*----- LOGIN Challenge-Response -----*/
        $(document).on( 'click', '.login', function(){

            var ok = true;
            var post = {};
            var st = $(this).parents().eq(1);
            var Super = this;
            

            //Resets errors
            $( 'small.error', st ).remove();
            $( '.error', st ).removeClass('error');

            $( 'input', st ).each(function(){
                var field = {
                    value: $(this).val(),
                    name: $(this).attr('name')
                }

                if(!field.value){
                    ok = false;
                    $(this).addClass( 'error' );
                    $(this).after( '<small class="error">' + locale.errors.client.emptyField + '</small>' );
                }

                post[field.name] = field.value;

            }).promise().done(function(){
                if(ok){
                    var animation = animate.loading(Super, 'Loading');

                    animation.start();

                    $.post(o.loginAddress, {'username': post.username}, function( challenge ){

                        var response = CryptoJS.SHA512(post.password + challenge.challenge).toString();

                        $.post( o.loginAddress, {'response': response}, function( status ){
                            animation.stop();

                            if(status.authorized === true){
                                animation.update('Success');
                            }else{
                                animation.update('Failed');
                            }

                            setTimeout(function(){
                                animation.reset();
                                if(status.authorized){
                                    $( o.login ).foundation('reveal', 'close');

                                }
                            }, 1500);

                        }).fail(handlers.postError)
                    }).fail(handlers.postError)
                }
            });
        });
        /*----------HANDLERS ENDS----------*/

        $( o.datepicker ).fdatepicker({
            onRender: function (date) {
                // console.log(date);
                if( Date.parse(date) <= Date.now()
                ||  Date.parse(date) >= Date.now() + 30*24*60*60*1000 ){
                     return 'disabled';
                }
            },
            format: 'yyyy-mm-dd'
        });

        $(document).foundation({
            reveal: {
                close_on_background_click: false
            }
        });

        $(document).on('closed.fndtn.reveal', '[data-reveal]', function () {
            var modal = $(this);
            $( 'small.error', modal ).remove();
            $( 'input, select, textarea', modal ).each(function(){
                $(this).val('');
                $(this).removeClass('error');
            });
        });
        
         $(document).on('click', '.lang', function () {

            var newLang = $(this).data('lang');

            if(o.locale.available[newLang]){
                
                o.locale.selected = newLang;
                localStorage.setItem('lang', newLang);
            }
            location.reload();
            
        });
        
    }
})(jQuery)