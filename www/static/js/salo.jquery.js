(function($){
	$.fn.salo = function(orguments){
		var options = $.extend({}, orguments);
		var todo = this;
		var models = {
			item: function(data){
				return '<div class="large-3 small-6 columns item" data-id="' + data.id + '">' +
							'<img src="http://placehold.it/1000x1000&amp;text=Thumbnail">' +
							'<div class="panel">' +
								'<h5>' + data.title + '</h5>' +
								'<h6 class="subheader">' + data.text + '</h6>' +
							'</div>' +
						'</div>';
			}
		};

		$.getJSON('http://192.168.55.55/adverts.php').done(function(data){

			todo.each(function(){
				for(advert of data){
					$(this).append(models.item(advert));
				}
			})
		})
	}
})(jQuery)