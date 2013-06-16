/**
 * grouped data report
 */
(function($) {
	$.widget("shop.groupedReport", {
		/**
		 * Option defalts
		 */
		options: {
			padding: 30,
			width: 960,
			height: 250,
			offset: 130,
			fade: .4,
			n: 4,
			m: 64,
			x: null,
			y: null,
			z: null,
			url: null,
			svg: null,
			data: []
		},

		/**
		 * The _create method is where you set up the widget
		 *
		 * If no custom callback has been specified the default is used
		 */
		_create: function() {
			Number.prototype.formatMoney = function(c, d, t){
				var n = this, 
				c = isNaN(c = Math.abs(c)) ? 2 : c, 
				d = d == undefined ? "." : d, 
				t = t == undefined ? "," : t, 
				s = n < 0 ? "-" : "", 
				i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
				j = (j = i.length) > 3 ? j % 3 : 0;
				return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
			};

			var element = $(this.element),
				id = 'Calendar-' + String(Math.floor(Math.random() * 99999)),
				$this = this;

			element.attr('id', id);

			$this.options.url = $('.charts', this.element).data('url');
			this._fetchData($this);
		},

		_fetchData: function(_this) {
			d3.json(_this.options.url, function(data) {
				_this.options.data = data;
				_this.draw();
			});
		},

		/**
		 * Draw the chart
		 */
		draw: function() {
			if (this.options.data.lenth < 1) {
				return;
			}

			var $this = this,
				element = $(this.element);
			$.each(this.options.data, function(type, values) {
				$('.charts', element).append('<h3>' + type + '</h3><div class="chart chart-' + type +'"/>');
				$this._chart(type, values);
			});
		},

		_chart: function(type, data) {
			var $this = this,
				series = [],
				labels = [],
				format = null,
				xAxis = d3.svg.axis(),
				dataPoints = data.length,
				minDate, maxDate = null,
				formatTime = formatTime = d3.time.format("%e %B");

			switch (type) {
				case 'years':
					formatTime = d3.time.format("%Y");
					minDate = new Date(data[0].year, 1, 1);
					maxDate = new Date(data[dataPoints - 1].year, 12, 31, 23, 59, 59);
					break;

				case 'months':
					formatTime = d3.time.format("%B %Y");
					minDate = new Date(data[0].year, data[0].month, 0);
					maxDate = new Date(data[dataPoints - 1].year, data[dataPoints - 1].month + 1, 0, 23, 59, 59);
					break;

				case 'weeks':
					var t = data[0]._start.split(/[- :]/);
					minDate = new Date(t[0], t[1]-1, t[2]);

					var t = data[dataPoints - 1]._start.split(/[- :]/);
					maxDate = new Date(t[0], t[1]-1, t[2] + 7, 23, 59, 59);
					break;

				case 'days':
					minDate = new Date(data[0].year, data[0].month, 0);
					maxDate = new Date(data[dataPoints - 1].year, data[dataPoints - 1].month, data[dataPoints - 1].day, 23, 59, 59);
					break;
			}
			var today = new Date();
			maxDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
			var max = Math.max.apply(null, data.map(function(item){
					return item['total'];
				})),
				salesMax = Math.max.apply(null, data.map(function(item){
					return item['sales'];
				})),
				productsMax = Math.max.apply(null, data.map(function(item){
					return item['products'];
				}));

			var yScale = d3.scale.linear()
					.domain([0, max + (max * .1)])
					.range([this.options.height, 0]),
				salesYScale = d3.scale.linear()
					.domain([0, salesMax + (salesMax * .1)])
					.range([this.options.height, 0]),
				productsYScale = d3.scale.linear()
					.domain([0, productsMax + (productsMax * .1)])
					.range([this.options.height, 0]),
				xScale = d3.time.scale()
					.domain([minDate, maxDate])
					.range([this.options.offset, this.options.width]),
				salesSet = [], 
				ordersSet = [], 
				productsSet = []; 

			$.each(data, function(k, v) {
				if (v.total == 0) {
					v.sales = 0;
					v.products = 0;
				}
				series.push({
					value: v.total,
					date: new Date(v.year, v.month, v.day),
					sales: v.sales,
					products: v.products
				});
				if (v.total > 0) {
					salesSet.push(v.sales);
					ordersSet.push(v.total);
					productsSet.push(v.products);
				}
			});

			var selector = '.chart.chart-' + type,
				svg = d3.select(selector).append("svg:svg")
					.data([series])
					.attr("width", this.options.width + this.options.padding * 2)
					.attr("height", this.options.height + this.options.padding * 2)
					.attr("transform", "translate(" + this.options.padding + "," + this.options.padding + ")");

			/**
			 * draw median lines
			 */
			 var _salesMedian = median(salesSet),
				_ordersMedian = median(ordersSet),
				_productsMedian = median(productsSet);
			svg.append('svg:line')
				.attr('class', 'median orders')
				.attr('x1', this.options.offset)
				.attr('x2', this.options.width)
				.attr('y1', yScale(_ordersMedian))
				.attr('y2', yScale(_ordersMedian));
			svg.append('svg:line')
				.attr('class', 'median sales')
				.attr('x1', this.options.offset)
				.attr('x2', this.options.width)
				.attr('y1', salesYScale(_salesMedian))
				.attr('y2', salesYScale(_salesMedian));
			svg.append('svg:line')
				.attr('class', 'median products')
				.attr('x1', this.options.offset)
				.attr('x2', this.options.width)
				.attr('y1', salesYScale(_productsMedian))
				.attr('y2', salesYScale(_productsMedian));

			var rules = svg.selectAll("g.rule")
				.data(xScale.ticks(10))
				.enter()
					.append("svg:g")
					.attr("class", "rule");

			/*rules.append("svg:line")
				.attr("x1", xScale)
				.attr("x2", xScale)
				.attr("y1", 0)
				.attr("y2", this.options.height - 1);

			rules.append("svg:line")
				.attr("class", function(d) { 
					return d ? null : "axis"; 
				})
				.attr("y1", yScale)
				.attr("y2", yScale)
				.attr("x1", 0)
				.attr("x2", this.options.width + 1);*/

			rules.append("svg:text")
				.attr("x", xScale)
				.attr("y", this.options.height + 3)
				.attr("dy", ".71em")
				.attr("text-anchor", "middle")
				.text(xScale.tickFormat(20));

			/*rules.append("svg:text")
				.attr("y", yScale)
				.attr("x", -3)
				.attr("dy", ".35em")
				.attr("text-anchor", "end")
				.text(yScale.tickFormat(20));*/

			/**
			 * draw grid
			 */
			svg.selectAll("line.x")
				.data(xScale.ticks(40))
				.enter().append("line")
				.attr("class", "x")
				.attr("x1", xScale)
				.attr("x2", xScale)
				.attr("y1", 0)
				.attr("y2", this.options.height)
				.style("stroke", "#ccc");

			svg.selectAll("line.y")
				.data(yScale.ticks(10))
				.enter().append("line")
				.attr("class", "y")
				.attr("x1", this.options.offset)
				.attr("x2", this.options.width)
				.attr("y1", yScale)
				.attr("y2", yScale)
				.style("stroke", "#ccc");

			/**
			 * draw scale markers
			 */
			svg.append('g')
				.attr("class", "y axis orders")
				.attr("transform", "translate(" + 80 + ", 0)")
				.call(d3.svg.axis().scale(yScale).orient('right'));

			svg.append('g')
				.attr("class", "y axis sales")
				.attr("transform", "translate(" + 40 + ", 0)")
				.style("opacity", this.options.fade)
				.call(d3.svg.axis().scale(salesYScale).orient('right'));

			svg.append('g')
				.attr("class", "y axis products")
				.style("opacity", this.options.fade)
				.call(d3.svg.axis().scale(productsYScale).orient('right'));

			var last = 0;
			/**
			 * render key
			 */
			svg.append("text")
				.attr("class", "x label orders")
				.attr("text-anchor", "end")
				.attr("x", this.options.width - 5)
				.attr("y", 12)
				.text('Order Value (£' + _ordersMedian + ')');
			svg.append("text")
				.attr("class", "x label sales")
				.attr("text-anchor", "end")
				.attr("x", this.options.width - 5)
				.attr("y", 24)
				.style("opacity", this.options.fade)
				.text('Sales (' + _salesMedian + ')');
			svg.append("text")
				.attr("class", "x label products")
				.attr("text-anchor", "end")
				.attr("x", this.options.width - 5)
				.attr("y", 36)
				.style("opacity", this.options.fade)
				.text('Products sold (' + _productsMedian + ')');

			/**
			 * render data lines
			 */
			svg.append("svg:path")
				.attr("class", "line orders")
				.attr("d", d3.svg.line()
					.x(function(d) { return xScale(d.date); })
					.y(function(d) { return yScale(d.value); })
					.interpolate("cardinal")
				);

			svg.append("svg:path")
				.attr("class", "line sales")
				.style("opacity", this.options.fade)
				.attr("d", d3.svg.line()
					.x(function(d) { return xScale(d.date); })
					.y(function(d) { return salesYScale(d.sales); })
					.interpolate("cardinal")
				);

			svg.append("svg:path")
				.attr("class", "line products")
				.style("opacity", this.options.fade)
				.attr("d", d3.svg.line()
					.x(function(d) { return xScale(d.date); })
					.y(function(d) { return productsYScale(d.products); })
					.interpolate("cardinal")
				);

			var div = d3.select("body").append("div")   
					.attr("class", "tooltip")
					.style("opacity", 0);

			/**
			 * draw points
			 */
			svg.selectAll("circle.line")
				.data(series)
				.enter()
					.append("svg:circle")
				.attr("class", "line")
				.attr("cx", function(d) { 
					return xScale(d.date); 
				})
				.attr("cy", function(d) { 
					if (d.value == 0) {
						return null;
					}
					return yScale(d.value); })
				.attr("r", function(d) {  
					if (d.value == 0) {
						return null;
					}
					
					return (d.value / max) * 5 + 2; 
				})
				.on("mouseover", function(d) {
					div.transition()
						.duration(200)
						.style("opacity", .8);
					div .html([
							'<strong>' + formatTime(d.date) + '</strong>',
							"£ "  + parseFloat(d.value).formatMoney(2),
							d.sales + ' orders',
							d.products + ' products'
						].join('<br/>'))
						.style("left", (d3.event.pageX + 10) + "px")
						.style("top", (d3.event.pageY - 50) + "px");
					})
				.on("mouseout", function(d) {
					div.transition()
						.duration(500)
						.style("opacity", 0);
				});
		},

		/**
		 * Use the _setOption method to respond to changes to options
		 */
		_setOption: function(key, value) {
			switch(key) {
				case 'length':
					break;
			}
			$.Widget.prototype._setOption.apply(this, arguments)
		},

		/**
		 * Use the destroy method to reverse everything your plugin has applied
		 */
		destroy: function() {
			$.Widget.prototype.destroy.call(this);
		}
	});
})(jQuery);

$('.grouped').groupedReport();

function median(values) {
	values.sort(function(a,b) {
		return a - b;
	});
	var half = Math.floor(values.length / 2);
	if(values.length % 2) {
		return parseFloat(values[half]);
	} 
	return (parseFloat(values[half - 1]) + parseFloat(values[half])) / 2.0;
}