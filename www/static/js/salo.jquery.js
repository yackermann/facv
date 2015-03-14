(function($){
	$.fn.salo = function(orguments){
		var options = $.extend({}, orguments);
		var todo = this;
		var models = {
			advert: function(data){
				return '<div class="large-3 columns item" data-id="' + data.id + '">' +
							'<img src="http://placehold.it/1000x1000&amp;text=Thumbnail">' +
							'<div class="panel">' +
								'<h5>' + data.title  + '</h5>' +
								'<p>' + data.text + '</p>' +
							'</div>' +
						'</div>';
			}, 
			category: function(id, name){
				return {
					link: '<li class="tab-title" role="presentational" ><a href="#cat-' + id + '" role="tab" tabindex="0"aria-selected="false" controls="cat-' + id + '">' + name + '</a></li>',
					tab: '  <section role="tabpanel" aria-hidden="false" class="content" id="cat-' + id + '"><div class="large-12 columns items"></div></section>'
				}
			}
		};

		$.getJSON('http://192.168.55.55/adverts.php').done(function(data){
				

			// console.log(todo);
			todo.each(function(){
				for(category of data.categories){
					var catappend = models.category(category.id, category.loc_ru);
					$(this).append(catappend.tab);
					$(options.links).append(catappend.link);
				}
				for(advert of data.adverts){
					$('section#cat-' + advert.id + ' > .items', this).append(models.advert(advert));
				}

			})

		}).fail(function(e){
			console.log("ERROR: " + e);
		})
	}
})(jQuery)