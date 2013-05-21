$('a.rate.remove').live('click', function() {
	$(this).parent().remove();
	return false;
});

$('a.rate.add').live('click', function() {
	var $this = $(this),
		$counter = {},
		$type = null,
		$count = 1;

	$type = $(this).data('type');
	$counter = $type == 'insurance' ? $('#ShopShippingMethodValueInsuranceCounter') : $('#ShopShippingMethodValueRatesCounter');
	$count = $counter.val();

	var $html = '<div class="tiny">' +
		'<input name="data[ShopShippingMethodValue][' + $type + '][' + $count.toString() + '][limit]" placeholder="Limit ($)" type="text" id="ShopShippingMethodValueLimit">' +
		'<input name="data[ShopShippingMethodValue][' + $type + '][' + $count.toString()  + '][rate]" placeholder="Rate ($)" type="text" id="ShopShippingMethodValueRate">' +
		'<a href="#" class="remove"><i class="icon-minus"></i></a>' +
	'</div>';
	$('a:last', $this.parent()).before($html);
	$counter.val(parseInt($count) + 1);
	return false;
});

$('div.stock-value, div.price, div.markup').hover(function() {
	$('span', this).toggle();
}, function() {
	$('span', this).toggle();
});

$('.imageSelector').imageSelector({

});

$('.attributes a.attribute').on('click', function() {
	var $this = $(this),
		li = $this.parent(),
		checkbox = $($('div.attribute input[type="checkbox"]', li)[0]);

	checkbox.attr('checked', !checkbox.attr('checked'));

	li.removeClass('active');
	if (checkbox.attr('checked')) {
		li.addClass('active');
	}
	
	return false;
});