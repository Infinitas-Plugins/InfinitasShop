$(document).ready(function() {
	$('.cart-total').popover({
		trigger: 'manual',
		html: true,
		placement: 'bottom'
	}).on('mouseover', function() {
		var $this = $(this);
		$this.popover('show');

		var popoverContent = $('.popover-content p', $this.parent());
		popoverContent.html('Loading');
		$.get('/shop/shop_list_products/index', function(data) {
			popoverContent.html(data);
		});
	});

	$('.shipping-breakdown').popover();

	$('.cart-total-close').live('click', function() {
		$('.cart-total').popover('hide');
	});

	$('.add-to-cart').on('click', function() {
		var options = $('[name*="data[ShopOption]"]');
		if(options.length == 0) {
			return true;
		}

		var error = false;
		$.each(options, function(k, v) {
			var option = $(v);
			if(!option.val()) {
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
			highlightOption();
		}
	});

	$('table.options a').on('click', function() {
		var $this = $(this),
			optionSelect = $('#' + $this.data('option-id')),
			optionValue = $this.data('value-id');

		optionSelect.val(optionValue);
		$('html, body').animate({
			scrollTop: optionSelect.parent().parent().offset().top - 50
		}, 500);
		highlightOption();
		return false;
	});

	$('.background-change').on('click', function() {
		var $this = $(this);

		$('.modal-body img', $this.parent().parent()).css('background-color', $this.data('colour'));
		return false;
	});

	productFilter();
});

function productFilter() {
	var priceSlider = $('.price-slider'),
		priceMin = $('#ShopProductPriceMin'),
		priceMax = $('#ShopProductPriceMax');

	var min = parseInt(priceMin.val()),
		max = parseInt(priceMax.val());

	priceSlider.slider({
		range: true,
		min: min,
		max: max,
		values: [min, max],
		slide: function(event, ui) {
			debug(ui.values);
			priceMin.val(ui.values[0]);
			priceMax.val(ui.values[1]);
		}
	});
}

function highlightOption() {
	var rowClass = 'info',
	$options = $('[name*="data[ShopOption]"]');
	if(!$options.length) {
		return;
	}

	$('.options tr').removeClass(rowClass);
	$.each($options, function(k, v) {
		var value = $(v).val();
		if(value) {
			$('tr.' + value).addClass(rowClass);
		}
	});
}