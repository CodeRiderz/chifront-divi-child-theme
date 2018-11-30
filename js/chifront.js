(function ($) {
  // Init global DOM elements, functions and arrays
  window.app = {el : {}, fn : {}};
  app.el['window'] = $(window);

  app.el['window'].on('load', function () {
	  // Preloader
	  // app.el['loader'].delay(0).fadeOut();
    // app.el['mask'].delay(500).fadeOut("slow");

    // old image way
    // const $serviceGraph = $('#service-graph')
    // if ($serviceGraph.length > 0) {
    //   // initialize image map
    //   $serviceGraph.imageMap()

    //   // initialize default showed target
    //   const defaultShowingTargetId = '#regulatory-and-compliance'
    //   showTargetInCenterServiceBox(defaultShowingTargetId)

    //   $($serviceGraph.attr('usemap')).find('area').on('hover', function (e) {
    //     e.preventDefault()
    //     const $this = $(this)
    //     const targetId = $this.attr('href')
    //     showTargetInCenterServiceBox(targetId)
    //   })
    // }

    const serviceChartCtx = document.getElementById('ServicesChart');
    if (serviceChartCtx) {
      const $chartData = $('.chart-data');
      // get ids
      const chartDataCollection = $chartData.map(function (index, element) {
        var id = $(this).attr('id');
        return {
          id: id,
          title: $(element).find('h3').text(),
          description: $(element).find('h3').text(),
        }
      }).toArray()

      const labels = chartDataCollection.map((data) => (data.title))

      const serviceChart = new Chart(serviceChartCtx, {
        type: 'doughnut',
        data: {
          labels: labels,
          datasets:[
            {
              label: "My First Dataset",
              data: labels.map(() => (360 / labels.length)),
              backgroundColor: labels.map((_, index) => (index >= (labels.length / 2) ? '#B32E2D' : '#2B458A')),
              borderColor: labels.map((_, index) => ('rgba(255, 255, 255)')),
              hoverBorderColor: labels.map((_, index) => ('rgba(255, 255, 255)')),
              borderWidth: labels.map(() => (1)),
            }
          ]
        },
        options: {
          cutoutPercentage: 40,
          rotation: -1 * Math.PI,
          tooltips: {
            callbacks: {
              label: function(tooltipItem) {
                  let groupName = tooltipItem.index >= (labels.length / 2) ? 'Customer' : 'Principal';
                  return ' ' + groupName + ' - ' + labels[tooltipItem.index];
              }
            }
          },
          legend: {
            display: false,
          },
          plugins: {
            labels: {
              render: function (args) {
                return newLineCutting(20, args.label);
              },
              fontSize: 16,
              fontColor: '#fff',
              // arc: true,
            }
          }
        }
      });

      $(serviceChartCtx).click(
        function(evt){
            var activePoints = serviceChart.getElementsAtEvent(evt);    

            if (!activePoints[0]) {
              return false;
            }

            var index = activePoints[0]._index;
            var data = chartDataCollection[index];

            showTargetInCenterServiceBox('#' + data.id);

            serviceChart.data.datasets[0].borderWidth = labels.map((_, labelIndex) => (labelIndex === index ? 1 : 30)),
            serviceChart.options.cutoutPercentage = 75;
            serviceChart.options.plugins.labels.arc = true;
            serviceChart.options.plugins.labels.fontSize = 14;
            serviceChart.update();
            $('#service-graph-close').show(200);
            /* do something */
        }
      );

      $('#service-graph-close').click(function () {
        resetChart(serviceChart);
      });
    }
  })

  function resetChart (chart) {
    chart.data.datasets[0].borderWidth = chart.data.labels.map(() => (1)),
    chart.options.cutoutPercentage = 50;
    chart.options.plugins.labels.arc = false;
    chart.options.plugins.labels.fontSize = 16;
    chart.update();
    $('#service-graph-content').empty();
    $('#service-graph-close').hide(200);
  }

  function showTargetInCenterServiceBox (targetId) {
    const $serviceGraphContent = $('#service-graph-content')
    const $targetContent = $(targetId)
    const $targetImg = $(targetId + '-img')
    $serviceGraphContent.html($targetImg.html() + ' ' + $targetContent.html())
  }

  function newLineCutting (n, text) {
		  // trim the string to the maximum length
		  var trimmedString = text.substr(0, n);

		  // re-trim if we are in the middle of a word
      trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))
      // combine with new line and the rest of the text
      return trimmedString + '\n' + text.substr(trimmedString.length);
    };

})(jQuery)
