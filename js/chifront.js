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
      const $serviceGraphContent = $('#service-graph-content')
      $serviceGraph.imageMap()

      $($serviceGraph.attr('usemap')).find('area').on('click', function (e) {
        e.preventDefault()
        const $this = $(this)
        const targetId = $this.attr('href')
        const $targetContent = $(targetId)
        const $targetImg = $(targetId + '-img')
        $serviceGraphContent.html($targetImg + ' ' + $target.html())
      })
    }
  })

})(jQuery)
