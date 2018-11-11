(function ($) {
  // Init global DOM elements, functions and arrays
  window.app = {el : {}, fn : {}};
  app.el['window'] = $(window);

  app.el['window'].on('load', function () {
	  // Preloader
	  // app.el['loader'].delay(0).fadeOut();
    // app.el['mask'].delay(500).fadeOut("slow");

    const $serviceGraph = $('#service-graph')
    if ($serviceGraph.length > 0) {
      // initialize image map
      $serviceGraph.imageMap()

      // initialize default showed target
      const defaultShowingTargetId = '#regulatory-and-compliance'
      showTargetInCenterServiceBox(defaultShowingTargetId)

      $($serviceGraph.attr('usemap')).find('area').on('hover', function (e) {
        e.preventDefault()
        const $this = $(this)
        const targetId = $this.attr('href')
        showTargetInCenterServiceBox(targetId)
      })
    }

    const serviceChartCtx = document.getElementById('ServicesChart');
    const $chartData = $('.chart-data');
    const labels = $chartData.map(function (index, element) {
      return $(element).find('h3').text();
    }).toArray()

    const descriptions = $chartData.map(function (index, element) {
      return $(element).find('p').text();
    }).toArray()

    const serviceChart = new Chart(serviceChartCtx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets:[
          {
            label: "My First Dataset",
            data: labels.map(() => (360 / labels.length)),
            backgroundColor: labels.map((_, index) => (index >= (labels.length / 2) ? '#B32E2D' : '#2B458A')),
            borderColor: labels.map((_, index) => ('rgba(255, 255, 255, 0)')),
            hoverBorderColor: labels.map((_, index) => ('rgba(255, 255, 255, 0)')),
            borderWidth: labels.map(() => (1)),
          }
        ]
      },
      options: {
        cutoutPercentage: 50,
        rotation: -1 * Math.PI,
        tooltips: {
          enabled: false,
        },
        legend: {
          display: false,
        },
        plugins: {
          labels: {
            render: function (args) {
              return args.label.split(/((?:\w+ ){3})/g).filter(Boolean).join('\n');
            },
            fontSize: 14,
            fontColor: '#fff',
            // arc: true,
          }
        }
      }
    });

    $(serviceChartCtx).click( 
      function(evt){
          var activePoints = serviceChart.getElementsAtEvent(evt);    
          var index = activePoints[0]._index;
          console.debug('CHART CLICKED', labels[index], descriptions[index]);
          serviceChart.data.datasets[0].borderWidth = labels.map((_, labelIndex) => (labelIndex === index ? 1 : 20)),
          serviceChart.options.cutoutPercentage = 75;
          serviceChart.options.plugins.labels.arc = true;
          serviceChart.update();
          /* do something */
      }
    );
  })

  
  function showTargetInCenterServiceBox (targetId) {
    const $serviceGraphContent = $('#service-graph-content')
    const $targetContent = $(targetId)
    const $targetImg = $(targetId + '-img')
    $serviceGraphContent.html($targetImg.html() + ' ' + $targetContent.html())
  }

})(jQuery)
