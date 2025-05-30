"use strict";

!function (NioApp, $) {
  "User Balance"; //////// for developer - User Balance //////// 
  // Avilable options to pass from outside 
  // labels: array,
  // legend: false - boolean,
  // dataUnit: string, (Used in tooltip or other section for display) 
  // datasets: [{label : string, color: string (color code with # or other format), data: array}]

  // Membuat objek Date yang merepresentasikan waktu saat ini
  var tanggalSaatIni = new Date();

  // Mendapatkan informasi bulan dan tahun saat ini
  var bulanIni = tanggalSaatIni.getMonth();
  var tahunIni = tanggalSaatIni.getFullYear();

  // Mendapatkan jumlah hari dalam bulan ini
  var jumlahHari = new Date(tahunIni, bulanIni + 1, 0).getDate();

  // Membuat array untuk menampung tanggal
  var tanggalArray = Array.from({ length: jumlahHari }, (_, i) => (i + 1).toString().padStart(2, '0'));
  var chart_data = [];
  
  function salesLineChart(selector, set_data) {
    var $selector = selector ? $(selector) : $('.sales-bar-chart');
    $selector.each(function () {
      var $self = $(this),
          _self_id = $self.attr('id'),
          _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
          _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

      var selectCanvas = document.getElementById(_self_id).getContext("2d");

      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          label: _get_data.datasets[i].label,
          data: _get_data.datasets[i].data,
          // Styles
          backgroundColor: _get_data.datasets[i].color,
          borderWidth: 2,
          borderColor: 'transparent',
          hoverBorderColor: 'transparent',
          borderSkipped: 'bottom',
          barPercentage: .7,
          categoryPercentage: .7
        });
      }
    });
  } // init chart

  NioApp.coms.docReady.push(function () {
    salesLineChart();
  });
  var salesOverview = {
    labels: tanggalArray,
    dataUnit: 'Sales',
    lineTension: 0.1,
    datasets: [{
      label: "Sales Overview",
      color: "#798bff",
      background: NioApp.hexRGB('#798bff', .3),
      data: chart_data
    }]
  };

  function lineSalesOverview(selector, set_data) {
    var $selector = selector ? $(selector) : $('.sales-overview-chart');
    $selector.each(function () {
      var $self = $(this),
          _self_id = $self.attr('id'),
          _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;

      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];

      for (var i = 0; i < _get_data.datasets.length; i++) {
        var currentData = [];
        var fixData = [];
        
        tanggalArray.forEach(tanggal => {
          currentData.push({tanggal: tanggal.toString(), total: 0});
        });
        
        // Mendapatkan URL saat ini
        var currentURL = window.location.href;
        
        // Mendapatkan id_pelanggan dari URL
        var id_pelanggan = currentURL.substring(currentURL.lastIndexOf('/') + 1);

        // Membuat URL untuk fetch
        var fetchURL = '/pelanggan/saleschart/' + id_pelanggan+'?start_date=' + start_date_range + '&end_date=' + end_date_range;

        // Fetch data from server
        fetch(fetchURL)
        .then(response => response.json())
        .then(data => {

          // Update chart_data with fetched data
          data.forEach(element => {
            var date_from_db = element.tanggal.slice(-2);
						currentData.forEach((element2, index) => {
							if(element2.tanggal === date_from_db){
								delete currentData[index]
								currentData.push({tanggal: date_from_db.toString(), total: parseInt(element.total_keluar)});
							}
						});
          });

					let sortedArr = currentData.sort((a, b) => a.tanggal - b.tanggal)
					for(var x=0;x<sortedArr.length;x++){
						if(sortedArr[x] != undefined){
							fixData.push(sortedArr[x].total);
						}
					}
        });


        chart_data.push({
          label: _get_data.datasets[i].label,
          tension: _get_data.lineTension,
          backgroundColor: _get_data.datasets[i].background,
          borderWidth: 2,
          borderColor: _get_data.datasets[i].color,
          pointBorderColor: "transparent",
          pointBackgroundColor: "transparent",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: _get_data.datasets[i].color,
          pointBorderWidth: 2,
          pointHoverRadius: 3,
          pointHoverBorderWidth: 2,
          pointRadius: 3,
          pointHitRadius: 3,
          data: fixData
        });
      }

      var chart = new Chart(selectCanvas, {
        type: 'line',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          legend: {
            display: _get_data.legend ? _get_data.legend : false,
            labels: {
              boxWidth: 30,
              padding: 20,
              fontColor: '#6783b8'
            }
          },
          maintainAspectRatio: false,
          tooltips: {
            enabled: true,
            rtl: NioApp.State.isRTL,
            callbacks: {
              title: function title(tooltipItem, data) {
                return data['labels'][tooltipItem[0]['index']];
              },
              label: function label(tooltipItem, data) {
                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
              }
            },
            backgroundColor: '#eff6ff',
            titleFontSize: 13,
            titleFontColor: '#6783b8',
            titleMarginBottom: 6,
            bodyFontColor: '#9eaecf',
            bodyFontSize: 12,
            bodySpacing: 4,
            yPadding: 10,
            xPadding: 10,
            footerMarginTop: 0,
            displayColors: false
          },
          scales: {
            yAxes: [{
              display: true,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              position: NioApp.State.isRTL ? "right" : "left",
              ticks: {
                beginAtZero: true,
                fontSize: 11,
                fontColor: '#9eaecf',
                padding: 10,
                callback: function callback(value, index, values) {
                  return value;
                },
                min: 0,
                stepSize: 3000
              },
              gridLines: {
                color: NioApp.hexRGB("#526484", .2),
                tickMarkLength: 0,
                zeroLineColor: NioApp.hexRGB("#526484", .2)
              }
            }],
            xAxes: [{
              display: true,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                fontSize: 9,
                fontColor: '#9eaecf',
                source: 'auto',
                padding: 10,
                reverse: NioApp.State.isRTL,
                callback: function callback(value, index, values) {
                  return value;
                },
              },
              gridLines: {
                color: "transparent",
                tickMarkLength: 0,
                zeroLineColor: 'transparent'
              }
            }]
          }
        }
      });

			setTimeout(function() {
				chart.update();
		},1000);
    });
  } // init chart


  NioApp.coms.docReady.push(function () {
    lineSalesOverview();
  });
}(NioApp, jQuery);
