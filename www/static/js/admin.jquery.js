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
                bureau: 'bureau'
            }, orguments),

            _uploadImage = '';

            todo = this,
            
            locale = {},
            cache = {
                categories : {}
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
       


        /*----------Delete button.----------*/ 
        $('.deleteBtn').on('click', function(){
            $('.submitYes').data('id', $(this).data('id'));
            $('#confirm').foundation('reveal', 'open');
        })

        //SAY NO TO Delete
        $('.submitNo').on('click', function(){
            $('#confirm').foundation('reveal', 'close');
        })

        //DELETE
        $('.submitYes').on('click', function(){
            $(this).foundation('reveal', 'close');
            var _id = $(this).data('id');
            $.post(o.bureau, { 'method': 'delete', 'id': _id }, function( reply ){
                if( reply.status === 200 ){
                    m.success(locale.errors.client['successDelete'])
                    $( '#' + _id ).remove();
                }else{
                    m.alert(locale.errors.client['failedDelete'])
                }
            }).fail(handlers.postError)
        })
        /*----------Delete button ends.----------*/ 


        /*----------Edit.----------*/ 
        $('.editBtn').on('click', function(){

            var _id = $(this).data('id');
            $('#newAdvert').data('post', { 'method' : 'update', 'id': _id });
            $.post( o.bureau, { 'method' : 'get', 'id': _id }, function( data ){
                if( data.status === 200 ){
                    var items = Object.keys(data.data);
                    items.forEach( function( key ){
                        var field = $('*[data-sid="' + key + '"]');
                        // if( $(field).is( 'input' ) || $(field).is( 'textarea' ) )
                            $(field).val(data.data[key])
                        // else if( $(field).is( 'select' ) )


                            
                    })
                    $('#newAdvert').foundation('reveal', 'open');
                }
            }).fail(handlers.postError)

        })

        /*----------Edit ends.----------*/ 

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

            var  ok = true
               , post = {}
               , st = $(this).parents().eq(2)
               , method = $('#newAdvert').data('post');

            //Resets errors
            $( 'small.error', st ).remove();
            $( '.error', st ).removeClass('error');

            $( 'input, select, textarea', st ).each(function(){
                var field = {
                    value: $(this).val(),
                    type: $(this).data('type'),
                    name: $(this).attr('name'),
                    validate: $(this).data('eval'),
                    sid: $(this).data('sid')
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

                    $( o.modal ).foundation('reveal', 'close');

                    $.post( o.bureau, post, function( data ){
                        var msg = '';

                        if(o.debug){
                            msg = '<br>' + data;
                            console.log('POST SUCCESS: ', data);
                        }

                        if(data.status === 200){

                            m.success( locale.errors.client.successAdded + msg );
                           
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
                                    window.location.replace('server/admin');

                                }
                            }, 1500);

                        }).fail(handlers.postError)
                    }).fail(handlers.postError)
                }
            });
        });


        $(document).on('closed.fndtn.reveal', '[data-reveal]', function () {
            var modal = $(this);
            $('.dropzone.parent', modal).css('background-image', '');
            $( 'small.error', modal ).remove();
            $( 'input, select, textarea', modal ).each(function(){
                $(this).val('');
                $(this).removeClass('error');
            });
            $('.CdeleteBtn').data('id', '');
            $('#newAdvert').data('post', '');

        });
        

        /*----------Drag'n'Drop/File select----------*/
        function handleFileSelect(evt) {
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

        function handleDragOver(evt) {
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

        // $( o.datepicker ).fdatepicker({
        //     onRender: function (date) {
        //         // console.log(date);
        //         if( Date.parse(date) <= Date.now()
        //         ||  Date.parse(date) >= Date.now() + 30*24*60*60*1000 ){
        //              return 'disabled';
        //         }
        //     },
        //     format: 'yyyy-mm-dd'
        // });        
    }
})(jQuery)