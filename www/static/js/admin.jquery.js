(function($){
    $.fn.admin = function( orguments ){
        var o = $.extend({
                datepicker: '.endDatePicker',
                modal: '#newAdvert',
                login: '#loginModal',
                alert: '.alert-div',
                locale: {
                    selected: localStorage.getItem('lang') || 'ua',
                    class: '.translateMe',
                    available: {
                        'ru': 'Русский',
                        'ua': 'Українська',
                        'en': 'English'
                    }
                },
                debug: false,
                bureau: 'bureau',
                user: 'user'
            }, orguments),

            _uploadImage = '';
            locked = false;
            todo = this,
            
            locale = {},
            cache = {
                adverts: {},
                categories: {},
                search: {}
            },
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

            models = {
                table : {
                    advert : function(item){
                        return '<tr id=\"' + item.id + '\" class=\"advertItem\">'
                                 + '<td>' + item.title   + '</td>'
                                 + '<td>' + item.endDate + '</td>'
                                 + '<td>' + item.email   + '</td>'
                                 + '<td>' + item.phone   + '</td>'
                                 + '<td><a href=\"#' + item.id + '\" class=\"medium expand success button editBtn adv translateMe\" data-id=\"' + item.id + '\" data-tid=\"edit\">Edit</a></td>'
                                 + '<td><a href=\"#' + item.id + '\" class=\"medium expand alert button deleteBtn adv translateMe\" data-id=\"' + item.id + '\" data-tid=\"delete\">Delete</a></td>'
                                 + '<td><a href=\"#' + item.id + '\" class=\"medium expand button view adv translateMe\" data-id=\"' + item.id + '\" data-tid=\"view\">Preview</a></td>'
                             + '</tr>';
                    },
                    user : function(item){
                        return '<tr id=\"' + item.id + '\">'
                                    + '<td>'  + item.username + '</td>'
                                    + '<td><a href=\"#' + item.id + '\" class=\"medium expand success button changePass user translateMe\" data-username=\"$username\" data-tid=\"changePass\">Edit</a></td>'
                                    + '<td><a href=\"#' + item.id + '\" class=\"medium expand alert button deleteBtn user translateMe\" data-id=\"' + item.id + '\" data-tid=\"delete\">Delete</a></td>'
                                + '</tr>';
                    }
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

            render = {
                modal: function( data ){
                    var img = data.image ? 'uploads/' + data.image : '/img/placeholder.png';
                    return  '<div id="myModal" class="reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">' +
                                '<div class="large-4 columns">' +
                                    '<div class="thumb" style="background-image: url(\'' + img + '\')"></div>' +
                                '</div>' +
                                '<div class="large-8 columns">' +
                                    '<small>' + locale.frontend['publishedOn'] + ': ' + data.startDate + ' | ' + locale.frontend['endingDate'] + ': ' + data.endDate + '</small><br/>' +
                                    '<h1>' + data.title + '</h1><br/>' +
                                    '<p>' + data.text + '<br/>'+
                                    locale.frontend['email'] + ' : ' + data.email + '<br/>'+
                                    locale.frontend['phone'] + ': ' + data.phone + '</p>' +
                                '</div>' +
                                '<a class="close-reveal-modal" aria-label="Close">&#215;</a>' +
                            '</div>';
                },

                categories: function( data ){

                    for (var i = 0, f; category = data[i]; i++)
                        $( 'select').append('<option value="' + category.id + '">' + category.name + '</option>');

                },
                locale: function(){
                    $(o.locale.class).each(function(){
                        var tid = $(this).data('tid');
                        if( $(this).is( 'input' ) ){
                            $(this).attr('placeholder', locale.admin[tid]);
                        }else{
                            $(this).text(locale.admin[tid]);
                        }
                    })
                    $('.loading').remove();
                }
            };

        $.getJSON( '/locale/' + o.locale.selected + '.locale.json' ).done(function( l ){

            locale = l;
            cache.categories = locale.categories;
            render.categories(locale.categories);

            render.locale();
        }).fail(handlers.getError);
       
        $.post( o.bureau, { 'method' : 'all' }, function( data ){
            if( data.status === 200 ){
                var advertsTable = '';
                for( var i = 0, advert; advert = data.adverts[i]; i++ ){
                    /*
                     * Caching adverts
                     */
                    cache.adverts[advert.id] = advert;

                    /*
                     * Creating search strings
                     */
                    cache.search[advert.id] = (function(advert){
                        var string = '';
                        var keys = Object.keys(advert);
                        for(var i = 0; i < keys.length; i++)
                            string = string + ' ' + advert[keys[i]];

                        return string;
                    })(advert)

                    advertsTable += models.table['advert'](advert);
                }

                $('#adb').find('tbody').html(advertsTable)

            }
        })

         $.post( o.user, { 'method' : 'all' }, function( data ){
            if( data.status === 200 ){
                var userTable = '';
                for( var i = 0, user; user = data.users[i]; i++ ){
                    userTable += models.table['user'](user);
                }
                
                $('#users').find('tbody').html(userTable)

            }
        })


        //Event handler for searching
        $('input[name=search]').on('input', function(){
            //Get input value
            var input = $(this).val();
            if( input === '' ){
                $('.advertItem').show();
            }else{
                //Open search results tab
                $('.advertItem').hide();

                //Perform search
                var keys = Object.keys( cache.adverts );

                //Clean search space
                $('#search').html('')
                var patt = new RegExp( input, 'ig' );

                keys.forEach(function( item, i ){
                    if (patt.test( cache.search[item] )){
                        $('#' + item).show();
                    }

                });
            }
        });
    /*---------------ADVERTS---------------*/

        /*-----------View button.-----------*/ 

        $('.view.adv').on('click', function(){
            var _id = $(this).data('id');
            $.post( o.bureau, { 'method' : 'get', 'id': _id }, function( data ){
                if( data.status === 200 )
                    $(render.modal(data.data)).foundation('reveal', 'open');
                else
                    m.alert(data.errorMessage);

            }).fail(handlers.postError)
        })
        /*------------View ends.------------*/ 

        /*----------Delete button.----------*/ 
        $('.deleteBtn.adv').on('click', function(){
            $('.submitYes.adv').data('id', $(this).data('id'));
            $('.confirm.adv').foundation('reveal', 'open');
        })

        //SAY NO TO Delete
        $('.submitNo.adv').on('click', function(){
            $('.confirm.adv').foundation('reveal', 'close');
        })

        //DELETE
        $('.submitYes.adv').on('click', function(){
            $(this).foundation('reveal', 'close');
            var _id = $(this).data('id');
            $.post(o.bureau, { 'method': 'delete', 'id': _id }, function( reply ){
                if( reply.status === 200 ){
                    m.success(locale.errors.client['successDelete']);
                    $( '#' + _id ).remove();
                }else
                    m.alert(locale.errors.client['failedDelete']);

            }).fail(handlers.postError)
        })
        /*----------Delete button ends.----------*/ 


        /*----------Edit.----------*/ 
        $('.editBtn.adv').on('click', function(){

            var _id = $(this).data('id');
            $('#newAdvert').data('post', { 'method' : 'update', 'id': _id });
            $.post( o.bureau, { 'method' : 'get', 'id': _id }, function( data ){
                if( data.status === 200 ){
                    var items = Object.keys(data.data);

                    items.forEach( function( key ){
                        $('*[data-sid="' + key + '"]').val(data.data[key])                            
                    })

                    $('#drop_zone').data('original', data.data.image);
                    
                    if( data.data.image !== null )
                        $('#drop_zone').css('background-image', 'url("/uploads/' + data.data.image + ')');

                    $('#newAdvert').foundation('reveal', 'open');
                }
            }).fail(handlers.postError)
        })

        $('.addAdv').on('click', function(){
            $('#newAdvert').data('post', { 'method' : 'add' });
            $('#newAdvert').foundation('reveal', 'open');
        })

        //Form validation form
        $(document).on( 'click', '.sbmt', function(){

            var  ok = true
               , post = {}
               , st = $(this).parents().eq(2)
               , method = $('#newAdvert').data('post');

            //Resets errors
            $( 'small.error', st ).remove();
            $( '.error', st ).removeClass('error');

            $( 'input, select, textarea', st ).each(function(){
                var field = {
                    value:      $(this).val()
                  , type:       $(this).data('type')
                  , name:       $(this).attr('name')
                  , validate:   $(this).data('eval')
                  , sid:        $(this).data('sid')
                }

                if(field.validate !== false){
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
                }
                
                
            }).promise().done(function(){
                if(ok){
                    post['method'] = method['method'];
                    if(method['method'] === 'update')
                        post['id'] = method['id'];

                    if( _uploadImage !== '' )
                        post['image'] = _uploadImage;
                    else
                        post['image'] = $('#drop_zone').data('original');
                    
                    $( o.modal ).foundation('reveal', 'close');

                    $.post( o.bureau, post, function( data ){
                        var msg = '';

                        if(o.debug){
                            msg = '<br>' + data;
                            console.log('POST SUCCESS: ', data);
                        }

                        if(data.status === 200){
                            if(method['method'] === 'update')
                                m.success( locale.errors.client['successUpdate'] + msg );
                            else
                                m.success( locale.errors.client['successAdded'] + msg );
                           
                            setTimeout(function(){
                                location.reload();
                            }, 1500);

                        }else{

                            m.alert( locale.errors.server[data.status] + msg );
                        }

                    }).fail(handlers.postError)
                }
            });
        });

        /*----------Edit ends.----------*/ 

    /*-------------ADVERTS END-------------*/

    /*-------------USERS-------------------*/

        /*----------Delete button.----------*/ 
        $('.deleteBtn.user').on('click', function(){
            $('.submitYes.user').data('id', $(this).data('id'));
            $('.confirm.user').foundation('reveal', 'open');
        })

        //SAY NO TO Delete
        $('.submitNo.user').on('click', function(){
            $('.confirm.user').foundation('reveal', 'close');
        })

        //DELETE
        $('.submitYes.user').on('click', function(){
            $(this).foundation('reveal', 'close');
            var _id = $(this).data('id');
            $.post(o.user, { 'method': 'delete', 'id': _id }, function( reply ){
                if( reply.status === 200 ){
                    m.success(locale.errors.client['successDeletedUser'])
                    $( '#' + _id ).remove();
                }else{
                    m.alert(locale.errors.client['failedDeleteUser'])
                }
            }).fail(handlers.postError)
        })
        /*----------Delete button ends.----------*/ 

        $('.addUser').on('click', function(){
            $('#addUser').foundation('reveal', 'open');
        })

        $(document).on( 'click', '.register', function(){
            if(!locked){
                locked = true;
                var Super = $(this);
                var post = {
                    'username'      :   $('*[name="username"]')
                  , 'password'      :   $('*[name="password"]')
                  , 'passwordRe'    :   $('*[name="passwordRe"]')
                };
               
                $('.pass, *[name="username"]').removeClass( 'error' );
                $('.error').remove();
                if( post.username.val() !== '' ){
                    $.post(o.user, {'method': 'exist','username': post.username.val() }, function( reply ){
                        if( !reply.exist ){
                            if( post['password'].val() === post['passwordRe'].val() && post['passwordRe'].val() !== '' ){

                                var animation = animate.loading(Super, locale.admin['loading']);

                                animation.start();

                                $.post(o.user, {'method': 'register','username': post.username.val() }, function( challenge ){

                                    var response = CryptoJS.SHA512(post['password'].val() + challenge.challenge).toString();

                                    $.post( o.user, {'method': 'register', 'response': response}, function( status ){
                                        animation.stop();

                                        if(status.status === 200){
                                            animation.update(locale.admin['success']);
                                        }else{
                                            animation.update(locale.admin['failed']);
                                        }

                                        setTimeout(function(){
                                            animation.reset();
                                            if(status.status === 200){
                                                
                                                $('.addUser').foundation('reveal', 'close');

                                                location.reload();
                                                locked = false;

                                            }
                                        }, 1500);

                                    }).fail(handlers.postError)
                                }).fail(handlers.postError)

                            }else{
                                $('.pass').addClass( 'error' );
                                $('.pass').after( '<small class="error">' + locale.errors.client['passwordNotMatch'] + '</small>' );
                                locked = false;
                            }
                        }else{
                            $( post.username ).addClass( 'error' );
                            $( post.username ).after( '<small class="error">' + locale.errors.client['userExist'] + '</small>' );
                            locked = false;
                        }
                    })
                }else{
                    $( post.username ).addClass( 'error' );
                    $( post.username ).after( '<small class="error">' + locale.errors.client['emptyField'] + '</small>' );
                    locked = false;
                }
            }
        });
    
        /*----------Delete button ends.----------*/ 

        $('.changePass').on('click', function(){
            $('#changePass').data('username', $(this).data('username'));
            $('#changePass').foundation('reveal', 'open');
            locked = false;
        })

        $(document).on( 'click', '.submitChangePass', function(){
            if(!locked){
                locked = true;
                var Super = $(this);
                var post = {
                    'username'      :   $('#changePass').data('username')
                  , 'password'      :   $('*[name="DeltaPassword"]')
                  , 'passwordRe'    :   $('*[name="DeltaPasswordRe"]')
                };
               
                $('.pass').removeClass( 'error' );
                $('.error').remove();
                if( post.username !== '' ){
                    $.post(o.user, {'method': 'exist','username': post.username }, function( reply ){
                        if( reply.exist ){
                            if( post['password'].val() === post['passwordRe'].val() && post['passwordRe'].val() !== '' ){

                                var animation = animate.loading(Super, locale.admin['loading']);

                                animation.start();

                                $.post(o.user, {'method': 'update','username': post.username }, function( challenge ){

                                    var response = CryptoJS.SHA512( post['password'].val() + challenge.challenge ).toString();

                                    $.post( o.user, {'method': 'update', 'response': response}, function( status ){
                                        animation.stop();

                                        if(status.status === 200){
                                            animation.update(locale.admin['success']);
                                        }else{
                                            animation.update(locale.admin['failed']);
                                        }

                                        setTimeout(function(){
                                            animation.reset();
                                            if(status.status === 200){
                                                
                                                $('#changePass').foundation('reveal', 'close');
                                                locked = false;

                                            }
                                        }, 1500);

                                    }).fail(handlers.postError)
                                }).fail(handlers.postError)

                            }else{
                                $('.pass').addClass( 'error' );
                                $('.pass').after( '<small class="error">' + locale.errors.client['passwordNotMatch'] + '</small>' );
                                locked = false;
                            }
                        }else{
                            $( post.username ).addClass( 'error' );
                            $( post.username ).after( '<small class="error">' + locale.errors.client['userExist'] + '</small>' );
                            locked = false;
                        }
                    })
                }
            }
        });

        /*----------Utilities----------*/


        $(document).on('closed.fndtn.reveal', '[data-reveal]', function () {
            var modal = $(this);
            $('.dropzone.parent', modal).css('background-image', '');
            $( 'small.error', modal ).remove();
            $( 'input, select, textarea', modal ).each(function(){
                $(this).val('');
                $(this).removeClass('error');
            });
            $('.submitYes').data('id', '');
            $('#newAdvert').data('post', '');
        });
        

        /*----------Drag'n'Drop/File select----------*/
        var handleFileSelect = function(evt) {
            evt.stopPropagation();
            evt.preventDefault();

            var files = evt.dataTransfer ? evt.dataTransfer.files : evt.target.files; //Tweak for filedrop and click;
            // files is a FileList of File objects. List some properties.

            var output = [];
            var reader = new FileReader();
            for (var i = 0, f; f = files[i]; i++) {
                if (!f.type.match('image.*')) {
                    m.alert(locale.errors.client.imageOnly);
                    continue;
                }
                reader.onload = (function(theFile) {
                    return function(e) {
                        _uploadImage = e.target.result;
                        $('.dropzone.parent').css('background-image', 'url(' + e.target.result + ')');
                    };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }

           
        }

        var handleDragOver = function(evt) {
            evt.stopPropagation();
            evt.preventDefault();
            evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
        }

        // Setup the dnd listeners.
        var dropZone = document.getElementById('drop_zone');
        dropZone.addEventListener('dragover', handleDragOver, false);
        dropZone.addEventListener('drop', handleFileSelect, false);
        document.getElementById('files').addEventListener('change', handleFileSelect, false);
        
        $("#drop_zone").click(function(e){
            e.preventDefault();
            $("#files").trigger('click');
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
    }
})(jQuery)