var unflr = unflr || {};

unflr.root = (function() {

	var my = {};
	
// init
// ------------------------------------
	my.ready = function(url) {

		// ouibounce
		// if (window.sharerOpen !== true) {
		setTimeout(function() {
			ouibounce(false, {
				aggressive: app.config.debug,
				callback: function() { 
					$('#unbounceModal').modal('show');
				}
			});
		}, 2000);
		// }


		// appear
		$('footer').appear().on('appear', function(e) {
			$('.email:visible', '.step4').focus();
		});

		// validation
		$('form').each(function() {
			$(this).bootstrapValidator({
				live: 'disabled',
		
			}).on('error.field.bv', function(e, field) {
				$('p.help-block').remove();
			})
		});


		// mailcheck
		$('.email').on('blur', function() {
			$this = $(this);
			$this.mailcheck({
				suggested: function(element, suggestion) {
					$this.parent().find('.help-block').remove();
					$this.after(sprintf(
						'<p class="help-block">Did you mean<b><i> %s </b></i>?</p>',
						suggestion.full
					));
				},
				empty: function() {
					$this.parent().find('.help-block').remove();
				}
			});
		});

	};


// public API
// ------------------------------------
	return {
		ready : my.ready,
	};

})();

