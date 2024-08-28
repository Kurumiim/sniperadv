
function chartCircle() {
	// ______________Chart-circle
	if ($('.chart-circle').length) {
		$('.chart-circle').each(function() {
			let $this = $(this);
			$this.circleProgress({
				fill: {
					color:  myVarVal || "#38cab3",
				},
				size: $this.height(),
				startAngle: -Math.PI / 4 * 2,
				emptyFill: 'transparent',
				lineCap: 'round'
			});
		});
	}	
}



//Visitors chart
function viewers() {
	setTimeout(()=>{
		var options2 = {
			series: [{
				name: 'Male',
				data: [51, 44, 55, 42, 58,50, 62],
			},{
				name: 'Female',
				data: [56, 58, 38, 50, 64,45, 55]
			}],
			chart: {
			height: 315,
			type: 'line',
			toolbar: {
				show: false,
				},
				background: 'none',
				fill:"#fff",
			},
			grid: {
			borderColor: '#f2f6f7',
			},
			colors: [ myVarVal || "#38cab3", "#e4e7ed"],
			background: 'transparent',
			dataLabels: {
			enabled: false
			},
			stroke: {
			curve: 'smooth',
			width:2
			},
			xaxis: {
			type: 'day',
			categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]
			},
			dataLabels: {
			enabled: false,
			},
			legend: {
			show: true,
			position:'top',
			},
		xaxis: {
			show:false,
			axisBorder: {
						show: false,
						color: 'rgba(119, 119, 142, 0.05)',
						offsetX: 0,
						offsetY: 0,
					},
					axisTicks: {
						show: false,
						borderType: 'solid',
						color: 'rgba(119, 119, 142, 0.05)',
						width: 6,
						offsetX: 0,
						offsetY: 0
					},
			labels: {
				rotate: -90,
			}
		},
		yaxis: {
			show:false,
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			}
		},
			tooltip: {
			x: {
				format: 'dd/MM/yy HH:mm'
			},
			},
		};
		document.getElementById('Viewers').innerHTML = ''
		var chart2 = new ApexCharts(document.querySelector("#Viewers"), options2);
		chart2.render();
	}, 300);
}

$(function() {	
	$('#example1').DataTable({
		language: {
			searchPlaceholder: 'Search...',
			sSearch: '',
			lengthMenu: '_MENU_',
		}
	});
});


  $(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  });