<div class="gantt">
	<div id="button-container">
		<div class="button-block">
			<h4>Sort by</h4>
			<ul id="sorter">
				<li><a href="#" data-sorter="name">Invoice number</a></li>
				<li><a href="#" data-sorter="start_date">Order date</a></li>
				<li><a href="#" data-sorter="end_date">Complete date</a></li>
				<li><a href="#" data-sorter="amount">Order Amount</a></li>
			</ul>
		</div>
		<div class="button-block">
			<h4>Color by</h4>
			<ul id="color">
				<li><a href="#" data-color="">None</a></li>
				<li><a href="#" data-color="amount">Order Amount</a></li>
			</ul>
		</div>
	</div>
	<div id="chart-canvas" style="width:100%;position:relative;float:left;">
		<div id="svg-canvas" style="position:absolute;top:0;bottom:0;left:0;right:0;"></div>
		<div id="gantt-bar-container" style="position:absolute;top:0;bottom:0;left:0;right:0;padding-top:30px;"></div>
	</div>
</div>