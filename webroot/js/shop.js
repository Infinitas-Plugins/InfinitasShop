$(document).ready(function() {
	$('.add-to-cart').on('click', function() {
		var options = $('[name*="data[ShopOption]"]');
		if(options.length == 0) {
			return true;
		}

		var error = false;
		$.each(options, function(k, v) {
			var option = $(v);
			if(option.hasClass('required') && !option.val()) {
				option.addClass('error');
				error = true;
			}
		});

		if(error) {
			$('.options .alert').show();
			return false;
		}

		return true;
	});

	$('[name*="data[ShopOption]"]').on('change', function() {
		var $this = $(this);
		if($this.val()) {
			$('.options .alert').hide();
			$this.removeClass('error');
		}
	});
});