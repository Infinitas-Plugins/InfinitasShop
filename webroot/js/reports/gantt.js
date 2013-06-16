(function(){
    var canvas_left_edge = $('#chart-canvas').offset().left;
    var canvas_width = $('#chart-canvas').width();
    var amountScale;


    d3.json('/admin/shop/shop_orders/report_data/orders.json', function(orders){
        var data = [];
        $.each(orders, function(k, v) {
			//var start = v.date.split(/[- :]/);
			//var date = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
			//return date.toISOString().split('T')[0];
        	data.push({
        		'name': v.invoice_number,
        		'amount': v.value,
        		'start_date': v.date,
        		'end_date': v.end_date,
        	});
        });

        // Compute the height our canvas needs to be once we get the data
        var number_of_bars = data.length
        var bar_height = 20;
        var bar_margin_bottom = 10;
        var container_top_padding = 30;
        var container_bottom_padding = 40;
        var canvas_height = number_of_bars * (bar_height + bar_margin_bottom) + container_top_padding + container_bottom_padding;

        $('#chart-canvas').css('height',canvas_height)


        function getDate(date) {
            return new Date(date);
        }

        function accessStartDate(d) { return getDate(d['start_date']); }
        function accessEndDate(d) { return getDate(d['end_date']); }

        // Find min/max of our dates
        var min = d3.min(data, accessStartDate);
        var max = d3.max(data, accessEndDate);

        var xScale = d3.time.scale()
            .domain([min,max])
            .range([125, canvas_width]);

        // This creates an axis. You can see that it assign's the scale we made up above
        var xAxis = d3.svg.axis()
            .scale(xScale)
            .orient("bottom");

        // Create svg container
        var svg = d3.select("#svg-canvas")
                .append("svg")
                .attr("width", canvas_width)
                .attr("height", canvas_height);


        // Bottom Axis
        var btmAxis = svg.append("g")
            .attr("transform", "translate(0,"+(canvas_height - 25)+")")
            .attr("class", "axis")
            .call(xAxis);

        // Top Axis
        var topAxis = svg.append("g")
            .attr("transform", "translate(0,0)")
            .attr("class", "axis")
            .call(xAxis);

        // Lines
        var line = svg.append("g")
            .selectAll("line")
                .data(xScale.ticks(10))
          .enter().append("line")
            .attr("x1", xScale)
            .attr("x2", xScale)
            .attr("y1", 30)
            .attr("y2", canvas_height-50)
            .style("stroke", "#ccc");

        $.each(data, function(index, value){
            var start_pixels = xScale(getDate(value['start_date']))
            var bar_width = xScale(getDate(value['end_date'])) - start_pixels

            var new_bar = '<div class="bar-wrapper '+value['sex']+'" data-name="'+value['name']+'" data-start_date="'+getDate(value['start_date']).getTime()+'" data-end_date="'+getDate(value['end_date']).getTime()+'" data-amount="'+value['amount']+'">\
                <div class="bar" style="margin-left:'+start_pixels+'px;width:'+bar_width+'px;">\
                    <div class="bar-name">'+value['name']+'</div>\
                </div>\
            </div>'
            $('#gantt-bar-container').append(new_bar)

        })

        $container = $('#gantt-bar-container');
        $container.isotope({
          itemSelector : '.bar-wrapper',
          getSortData : {
              name : function ( $elem ) {
                  return $elem.attr('data-name')
              },
              start_date : function ( $elem ) {
                  return parseInt($elem.attr('data-start_date'))
              },
              end_date : function ( $elem ) {
                  return parseInt($elem.attr('data-end_date'))
              },
              amount: function ( $elem ) {
                  return parseInt($elem.attr('data-amount'))
              }
          }
        });

        var amount_extent = d3.extent(data, function(d){return Number(d['amount'])})

        // Make the scale
        amountScale = d3.scale.log()
            .domain(amount_extent)
            .range([0,5]);


    });

    // Sorting buttons
    // So let's make a simple sort_ascending boolean variable and set it to true
    var sort_ascending = true;

    $('#sorter li a').click(function(){
        // Set it to what it ain't
        sort_ascending = !sort_ascending

        var sorter_selector = $(this).attr('data-sorter');
        // When we update the isotope layout, it has a property called sortAscending that will then get our value
        $('#gantt-bar-container').isotope({ sortBy : sorter_selector, sortAscending: sort_ascending });


    });

    // Filter buttons
    $('#filter li a').click(function(){
      var filter_selector = $(this).attr('data-filter');
      $('#gantt-bar-container').isotope({ filter: filter_selector });
      return false;
    });

    var GREENS = ["#edf8e9","#c7e9c0","#a1d99b","#74c476","#31a354","#006d2c"]

    // Color buttons
    $('#color li a').click(function(){
      var color_selector = $(this).attr('data-color');
      // Get all the bars
      var $bar_wrappers = $('.bar-wrapper');

      if (color_selector == 'amount'){
        $.each($bar_wrappers, function(index, bar_wrapper){
            // Find each div's data amount
            var this_amount = $(bar_wrapper).attr('data-amount')
            // Run this through our color scale
            var new_color_at_index = Math.floor(amountScale(this_amount))
            $(bar_wrapper).find('.bar').css({'background-color':GREENS[new_color_at_index]})

        });
      }else{
        $.each($bar_wrappers, function(index, bar_wrapper){
            // Reset to the default background color
            $(bar_wrapper).find('.bar').css({'background-color':''})
        });
      }

    });

}).call(this)