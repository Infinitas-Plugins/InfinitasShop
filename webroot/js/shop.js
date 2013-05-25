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

	$('.help').popover();

	$('.add-to-cart').on('click', function() {
		var options = $('[name*="data[ShopOption]"]');
		if (options.length == 0) {
			return true;
		}

		var error = false;
		$.each(options, function(k, v) {
			var option = $(v);
			if (!option.val()) {
				option.addClass('error');
				error = true;
			}
		});

		if (error) {
			$('.options .alert').show();
			return false;
		}

		return true;
	});

	$('[name*="data[ShopOption]"]').on('change', function() {
		var $this = $(this);
		if ($this.val()) {
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

	$('a.attribute-group').on('click', function() {
		var $this = $(this),
			type = $this.data('attribute-group'),
			active = 0,
			total = 0,
			items = $('li.' + type, $this.parent().parent());

		$.each(items, function(k, v) {
			total += 1;
			if ($(v).is(':visible')) {
				active += 1;
			}
		});
		if (active > 0 && active != total) {
			items.show();
		} else {
			items.toggle();
		}

		return false;
	});

	$('ul.small a').on('mouseover', function() {
		var $this = $(this),
			href = $this.attr('href');
		$('img', $this).css('height', $('img.main').clientHeight);
		
		$('img.main').attr('src', href);
	});

	$('ul.small a').on('click', function() {
		return false;
	});

	$('#AddressOption').on('change', function() {
		$('.address-details').hide();
		$('#details-' + $(this).val()).show();
	});

	$('#BillingAddressCheck').on('change', function() {
		var billing = $('.billing-adddress');
		$('input', billing.toggle()).val('');
		if ($(this).attr('checked') === 'checked') {
			billing.show();
		}
	});

	$('.options.shipping a, .options.payment a').on('click', function() {
		var $this = $(this);
		$.get($this.attr('href') + '.json', function(data) {
			$('a', $this.parent()).removeClass('active');
			$this.addClass('active');
		});
		return false;
	})
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
	if (!$options.length) {
		return;
	}

	$('.options tr').removeClass(rowClass);
	$.each($options, function(k, v) {
		var value = $(v).val();
		if (value) {
			$('tr.' + value).addClass(rowClass);
		}
	});
}