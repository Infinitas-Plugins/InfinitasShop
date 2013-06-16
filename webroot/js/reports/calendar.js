/**
 * Calendar report widget
 */
(function($) {
	$.widget("shop.calendarReport", {
		/**
		 * Option defalts
		 */
		options: {
			width: 960,
			height: 136,
			cellSize: 17,
			day: null,
			week: null,
			percent: null,
			format: null,
			color: null,
			field: 'product_count'
		},

		/**
		 * The _create method is where you set up the widget
		 *
		 * If no custom callback has been specified the default is used
		 */
		_create: function() {
			this.options.day = d3.time.format("%w");
			this.options.week = d3.time.format("%U");
			this.options.percent = d3.format(".1%");
			this.options.format = d3.time.format("%Y-%m-%d");
			this.options.color = d3.scale.quantize()
				.domain([0, 20])
				.range(d3.range(11).map(function(d) { return "q" + d + "-11"; }));

			this.options.url = url = $(this.element).data('url');

			var field = $(this.element).data('field');
			if (field) {
				this.options.field = field;
			}

			$(this.element).attr('id', 'Calendar-' + String(Math.floor(Math.random() * 99999)));

			this._initSvg();
		},

		/**
		 * Init the SVG elements
		 */
		_initSvg: function() {
			var id = $(this.element).attr('id'),
				$this = this;
			this.options.svg = d3.select("#" + id).selectAll("svg")
				.data(d3.range($(this.element).data('start'), $(this.element).data('stop') + 1))
			  .enter().append("svg")
				.attr("width", this.options.width)
				.attr("height", this.options.height)
				.attr("class", "RdYlGn")
			  .append("g")
				.attr("transform", "translate(" + ((this.options.width - this.options.cellSize * 53) / 2) + "," + (this.options.height - this.options.cellSize * 7 - 1) + ")")

			this.options.svg.append("text")
				.attr("transform", "translate(-6," + this.options.cellSize * 3.5 + ")rotate(-90)")
				.style("text-anchor", "middle")
				.text(function(d) { return d; });

			this.options.rect = this.options.svg.selectAll(".day")
				.data(function(d) { return d3.time.days(new Date(d, 0, 1), new Date(d + 1, 0, 1)); })
				.enter().append("rect")
				.attr("class", "day")
				.attr("width", this.options.cellSize)
				.attr("height", this.options.cellSize)
				.attr("x", function(d) { return $this.options.week(d) * $this.options.cellSize; })
				.attr("y", function(d) { return $this.options.day(d) * $this.options.cellSize; })
				.datum(this.options.format);

			this.options.rect.append("title").text(function(d) { return d; });

			this.options.svg.selectAll(".month")
				.data(function(d) { return d3.time.months(new Date(d, 0, 1), new Date(d + 1, 0, 1)); })
				.enter().append("path")
				.attr("class", "month")
				.attr("d", function(t0) {
					return $this._monthPath($this, t0)
				});
			this.draw();
		},

		/**
		 * Draw the chart
		 */
		draw: function() {
			var $this = this;
			d3.json(this.options.url, function(error, orders) {
				$.each(orders, function(k, v) {
					orders[k]['user_type'] = v.user_id > 0 ? 1 : 100;
				});
		  		var data = d3.nest()
				.key(function(d) { 
					var t = d.date.split(/[- :]/);
					var date = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
					return date.toISOString().split('T')[0];
				})
				.rollup(function(d) {
  					return d[0][$this.options.field]; 
				})
				.map(orders);

			  	$this.options.rect.filter(function(d) { return d in data; })
				  	.attr("class", function(d) { return "day " + $this.options.color(data[d]); })
					.select("title")
				  	.text(function(d) { return $this._toolTip(data, d); });
			});
			d3.select(self.frameElement).style("height", "2910px");
		},

		/**
		 * Generate the tool tip for the data point
		 */
		_toolTip: function(data, d) {
			if (this.options.field == 'value') {
				return d + ": £" + ' ' + Math.round(data[d] * 100) / 100;
			}

			if (this.options.field == 'user_type') {
				if (data[d] == 100) {
					return d + ': Guest';
				}
				return d + ': Registered';
			}
			return d + ': ' + data[d];
		},

		/**
		 * Get the month path for the data point
		 */
		_monthPath: function(_this, t0) {
			var t1 = new Date(t0.getFullYear(), t0.getMonth() + 1, 0),
				d0 = +_this.options.day(t0), w0 = +_this.options.week(t0),
				d1 = +_this.options.day(t1), w1 = +_this.options.week(t1);

			return "M" + (w0 + 1) * _this.options.cellSize + "," + d0 * _this.options.cellSize
				+ "H" + w0 * _this.options.cellSize + "V" + 7 * _this.options.cellSize
				+ "H" + w1 * _this.options.cellSize + "V" + (d1 + 1) * _this.options.cellSize
				+ "H" + (w1 + 1) * _this.options.cellSize + "V" + 0
				+ "H" + (w0 + 1) * _this.options.cellSize + "Z";
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

$('.calendar').calendarReport();