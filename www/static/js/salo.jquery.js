(function($){
	$.fn.salo = function( orguments ){
		var options = $.extend({}, orguments),
			todo = this,

			//Cache. OMG LOL
			cache = {
				adverts: {},
				categories: {}
			},

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
					// return cache.categories[ value ] !== undefined;
					return true;
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

		$.getJSON( options.source ).done(function( data ){
				
			// console.log(todo);
			todo.each(function(){

				//Iteration through the categories
				for( category of data.categories ){

					//Save category to cache
					cache.categories[category.id] = category;

					var catappend = models.category( category.id, category.loc_ru );

					//Create tab
					$(this).append( catappend.tab );

					//Create tab-link
					$( options.links ).append( catappend.link );
				};

				//Iteration through the categories
				for( advert of data.adverts ){


					// //Checks if advert is not outdated. 
					if( Date.parse(advert.endDate) > Date.now() ){

						//Save advert to cache
						cache.adverts[advert.id] = advert;

						//Add item
						$( 'section#cat-' + advert.categoryId + ' > .items', this ).append( models.advert(advert) );
					}
					
				};

			})

		}).fail(function( e ){
			console.log("ERROR: " + e);
		});


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
				var item = {
					value: $(this).val(),
					type: $(this).data('type'),
					name: $(this).attr('name'),
					sid: $(this).data('sid')
				}

				if(item.value){
					if(!validate[item.type](item.value)){
						ok = false;
						$(this).addClass( 'error' );
						$(this).after( '<small class="error">The ' + item.name + ' can not be validated</small>' );
					}else{
						post[item.sid] = item.value;
					}

				}else{
					ok = false;
					$(this).addClass( 'error' );
					$(this).after( '<small class="error">The field is empty</small>' );
				}
				
			}).promise().done(function(){
				if(ok){
					console.log(post);
					$('#newAdvert').foundation('reveal', 'close');
				}
			});
		});
		/*----------HANDLERS ENDS----------*/

		$('.endDatePicker').fdatepicker({
			onRender: function (date) {
				return date.valueOf() <= Date.now() ? 'disabled' : '';
			}
		});

		$(document).foundation({
			reveal: {
				close_on_background_click: false,
			}
		});

		$(document).on('closed.fndtn.reveal', '[data-reveal]', function () {
			var modal = $(this);
			$( 'input, select, textarea', modal ).each(function(){
				$(this).val('');
			});
		});
		

	}
})(jQuery)