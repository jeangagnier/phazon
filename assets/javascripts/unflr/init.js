var unflr = unflr || {};

unflr.init = (function() {

	var my = {};

// init
// -----------------------------------------------------------------
	my.ready = function(url) {
		$('.textInputSelectable').on('click', function() { 
			this.select();
		});

		$('#removeModal').on('click', function() {
			$('.modal').modal('hide').removeClass('show');
			$('.modal-backdrop').remove();
		});
	};

// public API
// -----------------------------------------------------------------
	return {
		ready : my.ready,
	};

})();

