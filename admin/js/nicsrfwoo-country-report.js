var CountryJSON = {};
// JavaScript Document
jQuery(function($){
	

	$( "#frm_country_report" ).submit(function( event ) {
		
		event.preventDefault();
		$.ajax({
			url:nicsrfwoo_ajax_object.nicsrfwoo_ajaxurl,
			data: $(this).serialize(),
			success:function(response) {
				
				//alert(JSON.stringify(response));
				$("._ajax_content").html(response);
				show_country_pie_chart_js();
				show_country_bar_chart_js();
			
			},
			error: function(errorThrown){
				console.log(errorThrown);
				//alert("e");
			}
		
		});
		
	});
	$("#frm_country_report").trigger("submit");
	
	
	
	
	$( document).on("click","._show_detail",function( event ) {
		 event.preventDefault();	
		 var country_code =  $(this).attr("data-country-code");
		 var country_name =  $(this).attr("data-country-name");
		 var order_days =   $("#order_days").val();
		 
		 
		  var ajaxData = {};
		  ajaxData["action"] = "nicsrfwoo_ajax";
		  ajaxData["sub_action"] = "country_report";
		  ajaxData["call"] = "get_detail_report";
		  ajaxData["country_code"] = country_code;
		  
		  ajaxData["order_days"] = order_days;
		 
		 $.ajax({
			url:nicsrfwoo_ajax_object.nicsrfwoo_ajaxurl,
			data: ajaxData,
			beforeSend: function(response){
				$("._show_country_detail").html("Please wait..");
				$("#staticBackdropLabel").html(country_name);
				$( "#btn_show_detail" ).trigger( "click" );
			},
			success:function(response) {
					
				//alert(JSON.stringify(response));
				$("._show_country_detail").html(response);
			},
			error: function(errorThrown){
				console.log(errorThrown);
				//alert("e");
			}
		
		});
		 
	});
	
});



function show_country_pie_chart_js(){
	jQuery("canvas#myChart_pie").remove();
	jQuery("div.chartreport_pie").append('<canvas id="myChart_pie" class="animated fadeIn" height="500"></canvas>');

	try{
		
		var graphTarget;
		var data_lable = [];
		var data_value = [];
		
		CountryJSON.map((item) => {
		data_lable.push(item.country_name);
		data_value.push(item.order_total);
		});
		
		
		var chartdata = {
		labels: data_lable,
		datasets: [
			{
				label: 'Country Sales',
				backgroundColor: [
				  'rgba(103, 183, 220)',
				  'rgba(255, 99, 132)',
				  'rgba(54, 162, 235)',
				  'rgba(255, 206, 86)',
				  'rgba(75, 192, 192)',
				  'rgba(153, 102, 255)',
				  'rgba(255, 159, 64)'
				],
				borderColor: [
				 'rgba(103, 183, 220, 1)',
				  'rgba(255, 99, 132, 1)',
				  'rgba(54, 162, 235, 1)',
				  'rgba(255, 206, 86, 1)',
				  'rgba(75, 192, 192, 1)',
				  'rgba(153, 102, 255, 1)',
				  'rgba(255, 159, 64, 1)'
				],
				hoverBackgroundColor: '#CCCCCC',
				hoverBorderColor: '#666666',
				data: data_value
			}
		]
		};
		
		var graphTarget = jQuery("#myChart_pie");
		barGraph = new Chart(graphTarget, {
		 type: 'pie',
		 data: chartdata,
		 showTooltips: false,
		 options: {  
			responsive: true,
			maintainAspectRatio: false,
			
		}
		});
		jQuery("#myChart_pie").css("height","500px");
		
		barGraph.render();
		barGraph = null;
		
	}catch(e){
		alert(e.message);
	}
}
function show_country_bar_chart_js()
{
	jQuery("canvas#myChart").remove();
	jQuery("div.chartreport").append('<canvas id="myChart" class="animated fadeIn" height="500"></canvas>');

	try{
		
		var graphTarget;
		var data_lable = [];
		var data_value = [];
		
		CountryJSON.map((item) => {
		data_lable.push(item.country_name);
		data_value.push(item.order_total);
		});
		
		
		var chartdata = {
		labels: data_lable,
		datasets: [
			{
				label: 'Country Sales',
				backgroundColor: [
				  'rgba(103, 183, 220)',
				  'rgba(255, 99, 132)',
				  'rgba(54, 162, 235)',
				  'rgba(255, 206, 86)',
				  'rgba(75, 192, 192)',
				  'rgba(153, 102, 255)',
				  'rgba(255, 159, 64)'
				],
				borderColor: [
				 'rgba(103, 183, 220, 1)',
				  'rgba(255, 99, 132, 1)',
				  'rgba(54, 162, 235, 1)',
				  'rgba(255, 206, 86, 1)',
				  'rgba(75, 192, 192, 1)',
				  'rgba(153, 102, 255, 1)',
				  'rgba(255, 159, 64, 1)'
				],
				hoverBackgroundColor: '#CCCCCC',
				hoverBorderColor: '#666666',
				data: data_value
			}
		]
		};
		
		var graphTarget = jQuery("#myChart");
		barGraph = new Chart(graphTarget, {
		 type: 'bar',
		 data: chartdata,
		 showTooltips: false,
		 options: {  
			responsive: true,
			maintainAspectRatio: false,
			
		}
		});
		jQuery("#myChart").css("height","500px");
		
		barGraph.render();
		barGraph = null;
		
	}catch(e){
		alert(e.message);
	}
	
}
function show_country_bar_chart(){
	try{
		
		/*Start Chart*/
		am4core.ready(function() {
		
		// Themes begin
		am4core.useTheme(am4themes_animated);
		// Themes end
		
		var chart = am4core.create("chartdiv", am4charts.XYChart);
		
		chart.data = CountryJSON
		
		chart.padding(40, 40, 40, 40);
		
		var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
		categoryAxis.renderer.grid.template.location = 0;
		categoryAxis.dataFields.category = "country_name";
		categoryAxis.renderer.minGridDistance = 60;
		categoryAxis.renderer.inversed = true;
		categoryAxis.renderer.grid.template.disabled = true;
		
		var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
		valueAxis.min = 0;
		valueAxis.extraMax = 0.1;
		//valueAxis.rangeChangeEasing = am4core.ease.linear;
		//valueAxis.rangeChangeDuration = 1500;
		
		var series = chart.series.push(new am4charts.ColumnSeries());
		series.dataFields.categoryX = "country_name";
		series.dataFields.valueY = "order_total";
		series.tooltipText = "{valueY.value}"
		series.columns.template.strokeOpacity = 0;
		series.columns.template.column.cornerRadiusTopRight = 10;
		series.columns.template.column.cornerRadiusTopLeft = 10;
		//series.interpolationDuration = 1500;
		//series.interpolationEasing = am4core.ease.linear;
		var labelBullet = series.bullets.push(new am4charts.LabelBullet());
		labelBullet.label.verticalCenter = "bottom";
		labelBullet.label.dy = -10;
		
		switch(nicsrfwoo_ajax_object.currency_position){
			case "left":
				labelBullet.label.text = nicsrfwoo_ajax_object.currency_symbol + "{values.valueY.workingValue.formatNumber('#.')}";
			break;
			case "right":
				labelBullet.label.text = nicsrfwoo_ajax_object.currency_symbol + "{values.valueY.workingValue.formatNumber('#.')}" +nicsrfwoo_ajax_object.currency_symbol ;
			break;
			case "left_space":
				labelBullet.label.text = nicsrfwoo_ajax_object.currency_symbol + "  {values.valueY.workingValue.formatNumber('#.')}";
			break;
			case "right_space":
			labelBullet.label.text = nicsrfwoo_ajax_object.currency_symbol + "{values.valueY.workingValue.formatNumber('#.')} " +nicsrfwoo_ajax_object.currency_symbol ;
			break;
			  default:
			  labelBullet.label.text = nicsrfwoo_ajax_object.currency_symbol + "{values.valueY.workingValue.formatNumber('#.')}";
		}	
		
		
		
		chart.zoomOutButton.disabled = true;
		
		// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
		series.columns.template.adapter.add("fill", function (fill, target) {
		 return chart.colors.getIndex(target.dataItem.index);
		});
		
		
		
		categoryAxis.sortBySeries = series;
		
		}); // end am4core.ready()
	/*End Chart*/
		
	}catch(e){
	alert(e.message);	
	}
}
function show_country_pie_chart(){
	try{
		
	am4core.ready(function() {

	// Themes begin
	am4core.useTheme(am4themes_animated);
	// Themes end
	
	// Create chart instance
	var chart = am4core.create("chartdiv_pie_chart", am4charts.PieChart);
	
	chart.data = CountryJSON;
	
	// Add and configure Series
	var pieSeries = chart.series.push(new am4charts.PieSeries());
	pieSeries.dataFields.value = "order_total";
	pieSeries.dataFields.category = "country_name";
	pieSeries.slices.template.stroke = am4core.color("#fff");
	pieSeries.slices.template.strokeOpacity = 1;
	
	// This creates initial animation
	pieSeries.hiddenState.properties.opacity = 1;
	pieSeries.hiddenState.properties.endAngle = -90;
	pieSeries.hiddenState.properties.startAngle = -90;
	
	chart.hiddenState.properties.radius = am4core.percent(0);
	
	
	}); // end am4core.ready()
		
	}catch(e){
	alert(e.message);	
	}
}
