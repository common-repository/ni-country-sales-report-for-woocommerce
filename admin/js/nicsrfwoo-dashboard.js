"use strict";
jQuery(document).ready(function($) {
	
	am4core.ready(function() {
		// Themes begin
		am4core.useTheme(am4themes_animated);
		// Themes end
		// Create map instance
		var chart = am4core.create("chartdiv", am4maps.MapChart);
		// Set map definition
		chart.geodata = am4geodata_worldHigh;
		// Set projection
		chart.projection = new am4maps.projections.Mercator();
		// Export
		chart.exporting.menu = new am4core.ExportMenu();
		// Zoom control
		chart.zoomControl = new am4maps.ZoomControl();
		var homeButton = new am4core.Button();
		homeButton.events.on("hit", function() {
			chart.goHome();
		});
		homeButton.icon = new am4core.Sprite();
		homeButton.padding(7, 5, 7, 5);
		homeButton.width = 30;
		homeButton.icon.path = "M16,8 L14,8 L14,16 L10,16 L10,10 L6,10 L6,16 L2,16 L2,8 L0,8 L8,0 L16,8 Z M16,8";
		homeButton.marginBottom = 10;
		homeButton.parent = chart.zoomControl;
		homeButton.insertBefore(chart.zoomControl.plusButton);
		// Center on the groups by default
		chart.homeZoomLevel = 1;
		chart.homeGeoPoint = {
			longitude: 10,
			latitude: 52
		};
		
	
		jQuery.each(JSONMap, function(key, value) {
			var country_color = mapData.filter(d => d.id === value.billing_country);
			//console.log(mapData);
			//console.log(country_color);
			//console.log(country_color1[0].color["_value"]);
			//var  country_color = mapData.filter(d => d.id ==="IN");
			//console.log(country_color);
			//console.log(value);
			//console.log(value.color);
			var tmpColor = "#ff5050";
			if(typeof country_color[0] !== 'undefined') {
				var tmpColor = country_color[0].color["_value"];
			}
			JSONMap[key].color = tmpColor;
			//console.log(value.color);
		});
		var groupData = JSONMap;
		/*
		var  country_color1 = mapData.filter(d => d.id ==='IN');
		console.log(country_color1[0].color["_value"]);
		*/
		//console.log(JSON.stringify(groupData));
		//console.log(JSON.stringify(jData));
		// This array will be populated with country IDs to exclude from the world series
		var excludedCountries = ["AQ"];
		// Create a series for each group, and populate the above array
		groupData.forEach(function(group) {
			var series = chart.series.push(new am4maps.MapPolygonSeries());
			series.name = group.name;
			series.useGeodata = true;
			var includedCountries = [];
			group.data.forEach(function(country) {
				includedCountries.push(country.id);
				excludedCountries.push(country.id);
			});
			series.include = includedCountries;
			series.fill = am4core.color(group.color);
			// By creating a hover state and setting setStateOnChildren to true, when we
			// hover over the series itself, it will trigger the hover SpriteState of all
			// its countries (provided those countries have a hover SpriteState, too!).
			series.setStateOnChildren = true;
			series.calculateVisualCenter = true;
			// Country shape properties & behaviors
			var mapPolygonTemplate = series.mapPolygons.template;
			// Instead of our custom title, we could also use {name} which comes from geodata  
			mapPolygonTemplate.fill = am4core.color(group.color);
			mapPolygonTemplate.fillOpacity = 0.8;
			mapPolygonTemplate.nonScalingStroke = true;
			mapPolygonTemplate.tooltipPosition = "fixed"
			mapPolygonTemplate.events.on("over", function(event) {
				series.mapPolygons.each(function(mapPolygon) {
					mapPolygon.isHover = true;
				})
				event.target.isHover = false;
				event.target.isHover = true;
			})
			mapPolygonTemplate.events.on("out", function(event) {
					series.mapPolygons.each(function(mapPolygon) {
						mapPolygon.isHover = false;
					})
				})
				// States  
			var hoverState = mapPolygonTemplate.states.create("hover");
			hoverState.properties.fill = am4core.color("#CC0000");
			// Tooltip
			mapPolygonTemplate.tooltipText = "Country: {title}\n  Order Total:    {order_total}\n Order Count: {order_count}"; // enables tooltip
			// series.tooltip.getFillFromObject = false; // prevents default colorization, which would make all tooltips red on hover
			// series.tooltip.background.fill = am4core.color(group.color);
			// MapPolygonSeries will mutate the data assigned to it, 
			// we make and provide a copy of the original data array to leave it untouched.
			// (This method of copying works only for simple objects, e.g. it will not work
			//  as predictably for deep copying custom Classes.)
			series.data = JSON.parse(JSON.stringify(group.data));
		});
		// The rest of the world.
		var worldSeries = chart.series.push(new am4maps.MapPolygonSeries());
		var worldSeriesName = "world";
		worldSeries.name = worldSeriesName;
		worldSeries.useGeodata = true;
		worldSeries.exclude = excludedCountries;
		worldSeries.fillOpacity = 0.8;
		worldSeries.hiddenInLegend = true;
		worldSeries.mapPolygons.template.nonScalingStroke = true;
		// This auto-generates a legend according to each series' name and fill
		chart.legend = new am4maps.Legend();
		// Legend styles
		chart.legend.paddingLeft = 27;
		chart.legend.paddingRight = 27;
		chart.legend.marginBottom = 15;
		chart.legend.width = am4core.percent(10);
		chart.legend.valign = "bottom";
		chart.legend.contentAlign = "left";
		chart.legend.maxHeight = am4core.percent(90);
		chart.legend.scrollable = true;
		chart.legend.maxWidth = 100;
		// Legend items
		chart.legend.itemContainers.template.interactionsEnabled = false;
		
		
	}); // end am4core.ready()
	
	
	
	
	/*Call Dashboard function*/
	 // custom formatting example
	  $('.count-number').data('countToOptions', {
		formatter: function (value, options) {
		  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
		}
	  });
	  
	  // start all the timers
	  $('.timer').each(count);  
	  
	  function count(options) {
		var $this = $(this);
		options = $.extend({}, options || {}, $this.data('countToOptions') || {});
		$this.countTo(options);
	  }
	
	//$( element ).css( "backgroundColor", "yellow" );
	// var place = $(this).attr("data-place");
 	/*
	 $.each("#country_box   ._country" ,function( index ) {
			console.log(1);
	 });
	*/
	/*End Dashbaord function*/
	
	
	
});
/*=============================================================Dashboard Count=============================================================================*/
(function ($) {
	$.fn.countTo = function (options) {
		options = options || {};
		
		return $(this).each(function () {
			// set options for current element
			var settings = $.extend({}, $.fn.countTo.defaults, {
				from:            $(this).data('from'),
				to:              $(this).data('to'),
				speed:           $(this).data('speed'),
				refreshInterval: $(this).data('refresh-interval'),
				decimals:        $(this).data('decimals')
			}, options);
			
			// how many times to update the value, and how much to increment the value on each update
			var loops = Math.ceil(settings.speed / settings.refreshInterval),
				increment = (settings.to - settings.from) / loops;
			
			// references & variables that will change with each update
			var self = this,
				$self = $(this),
				loopCount = 0,
				value = settings.from,
				data = $self.data('countTo') || {};
			
			$self.data('countTo', data);
			
			// if an existing interval can be found, clear it first
			if (data.interval) {
				clearInterval(data.interval);
			}
			data.interval = setInterval(updateTimer, settings.refreshInterval);
			
			// initialize the element with the starting value
			render(value);
			
			function updateTimer() {
				value += increment;
				loopCount++;
				
				render(value);
				
				if (typeof(settings.onUpdate) == 'function') {
					settings.onUpdate.call(self, value);
				}
				
				if (loopCount >= loops) {
					// remove the interval
					$self.removeData('countTo');
					clearInterval(data.interval);
					value = settings.to;
					
					if (typeof(settings.onComplete) == 'function') {
						settings.onComplete.call(self, value);
					}
				}
			}
			
			function render(value) {
				var formattedValue = settings.formatter.call(self, value, settings);
				
				
				if (nicsrfwoo_ajax_object.currency_position==='left'){
					formattedValue = nicsrfwoo_ajax_object.currency_symbol + formattedValue;
				}
				if (nicsrfwoo_ajax_object.currency_position==='right'){
					formattedValue = formattedValue +  nicsrfwoo_ajax_object.currency_symbol;
				}
				if (nicsrfwoo_ajax_object.currency_position==='left_space'){
					formattedValue = nicsrfwoo_ajax_object.currency_symbol +' '+ formattedValue;
				}
				if (nicsrfwoo_ajax_object.currency_position==='right_space'){
					formattedValue = formattedValue +' '+  nicsrfwoo_ajax_object.currency_symbol;
				}
				
				
				
				$self.html(formattedValue);
			}
		});
	};
	
	$.fn.countTo.defaults = {
		from: 0,               // the number the element should start at
		to: 0,                 // the number the element should end at
		speed: 1000,           // how long it should take to count between the target numbers
		refreshInterval: 100,  // how often the element should be updated
		decimals: 2,           // the number of decimal places to show
		formatter: formatter,  // handler for formatting the value before rendering
		onUpdate: null,        // callback method for every time the element is updated
		onComplete: null       // callback method for when the element finishes updating
	};
	
	function formatter(value, settings) {
		return value.toFixed(settings.decimals) + $;
	}
}(jQuery));
/*=============================================================End Dashboard Count=============================================================================*/