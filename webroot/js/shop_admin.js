$('a .rate.remove').live('click', function() {
	$(this).parent().parent().remove();
	return false;
});

$('a .rate.add').live('click', function() {
	var $this = $(this),
		$tab = {},
		$counter = {},
		$image = {},
		$type = null,
		$count = 1;

	$image = $(this).parent();
	$tab = $(this).parent().parent();
	$type = $(this).data('type');
	$counter = $type == 'insurance' ? $('#ShopShippingMethodValueInsuranceCounter') : $('#ShopShippingMethodValueRatesCounter');
	$count = $counter.val();

	var $html = '<div class="tiny">' + 
		'<input name="data[ShopShippingMethodValue][' + $type + '][' + $count.toString() + '][limit]" placeholder="Limit ($)" type="text" id="ShopShippingMethodValueLimit">' + 
		'<input name="data[ShopShippingMethodValue][' + $type + '][' + $count.toString()  + '][rate]" placeholder="Rate ($)" type="text" id="ShopShippingMethodValueRate">' + 
		'<a href="#"><img src="/img/core/icons/actions/remove.png" width="20px" class="rate remove" alt=""></a>' +
	'</div>';
	$tab.append($html);
	$image.appendTo($image.parent());
	$counter.val(parseInt($count) + 1);
	return false;
});

$('div.stock-value, div.price, div.markup').hover(function() {
	$('span', this).toggle();
}, function() {
	$('span', this).toggle();
});