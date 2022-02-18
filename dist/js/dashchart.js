$(document).ready(function(){

	const d = new Date();

	const date = d.getDate() + "/" + (d.getMonth() +1) + "/" + d.getFullYear();

	const year = d.getFullYear();

	const datereq = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate();

	$('#current_year').html(year);

	$('#current_date').html(date);

	$.ajax({
		type: 'post',
		url: 'internal_data',
		dataType: 'json',
		data: 'get_dash_chart=&date='+datereq
	}).done(function(data){

		/******************* top box content *******************/

		$('#total_bqj').html(data.totals.casos.bqj);
		$('#total_bsg').html(data.totals.casos.bsg);
		$('#total_bfl').html(data.totals.casos.bfl);
		$('#total_denuncias').html(data.totals.casos.tdenuncias);

		/******************* Chart *******************/

		var salesChartCanvas = $('#dashChart').get(0).getContext('2d')

		var salesChartData = {
			labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			datasets: [
				{
					label: 'Pendientes',
					backgroundColor: 'rgba(207,66,65,0.8)',
					borderColor: 'rgba(60,141,188,0.8)',
					pointRadius: false,
					pointColor: '#3b8bba',
					pointStrokeColor: 'rgba(60,141,188,1)',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(60,141,188,1)',
					data: [
						data.chart.pendientes[0],
						data.chart.pendientes[1],
						data.chart.pendientes[2],
						data.chart.pendientes[3],
						data.chart.pendientes[4],
						data.chart.pendientes[5],
						data.chart.pendientes[6],
						data.chart.pendientes[7],
						data.chart.pendientes[8],
						data.chart.pendientes[9],
						data.chart.pendientes[10],
						data.chart.pendientes[11]
					]
				},
				{
					label: 'En proceso',
					backgroundColor: 'rgba(225,162,14,0.8)',
					borderColor: 'rgba(210, 214, 222, 1)',
					pointRadius: false,
					pointColor: 'rgba(210, 214, 222, 1)',
					pointStrokeColor: '#c1c7d1',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(220,220,220,1)',
					data: [
						data.chart.abiertos[0],
						data.chart.abiertos[1],
						data.chart.abiertos[2],
						data.chart.abiertos[3],
						data.chart.abiertos[4],
						data.chart.abiertos[5],
						data.chart.abiertos[6],
						data.chart.abiertos[7],
						data.chart.abiertos[8],
						data.chart.abiertos[9],
						data.chart.abiertos[10],
						data.chart.abiertos[11]
					]
				},
				{
					label: 'Finalizados',
					backgroundColor: 'rgba(17,125,90,0.8)',
					borderColor: 'rgba(60,141,188,0.8)',
					pointRadius: false,
					pointColor: '#3b8bba',
					pointStrokeColor: 'rgba(60,141,188,1)',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(60,141,188,1)',
					data: [
						data.chart.cerrados[0],
						data.chart.cerrados[1],
						data.chart.cerrados[2],
						data.chart.cerrados[3],
						data.chart.cerrados[4],
						data.chart.cerrados[5],
						data.chart.cerrados[6],
						data.chart.cerrados[7],
						data.chart.cerrados[8],
						data.chart.cerrados[9],
						data.chart.cerrados[10],
						data.chart.cerrados[11]
					]
				}
			]
		}

		var salesChartOptions = {
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: false
			},
			scales: {
				xAxes: [{
					gridLines: {
				  	display: false
				}
				}],
				yAxes: [{
					gridLines: {
					  	display: false
					}
				}]
			}
		}

		// This will get the first returned node in the jQuery collection.
		// eslint-disable-next-line no-unused-vars
		var salesChart = new Chart(salesChartCanvas, {
			type: 'bar',
			data: salesChartData,
			options: salesChartOptions
		});

		/******************* Porcentajes *******************/

		$('#total_registros').html('<strong>'+data.totals.total_general+'</strong>');

		$('#total_pendientes').html('<strong>'+data.totals.estados.pndt+'</strong>');
		$('#porc_pendientes').css('width', data.totals.porc_pendientes);

		$('#total_abiertos').html('<strong>'+data.totals.estados.open+'</strong>');
		$('#porc_abiertos').css('width', data.totals.porc_abiertos);

		$('#total_cerrados').html('<strong>'+data.totals.estados.close+'</strong>');
		$('#porc_cerrados').css('width', data.totals.porc_cerrados);
	});

});