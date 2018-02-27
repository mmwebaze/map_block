(function ($) {
    'use strict';

    Drupal.behaviors.map_block = {
        attach: function (context, settings) {

            $('.map_block_maps').once().each(function(index, value) {
             if ($(this).attr('data-map')) {
                 var id = $(this).attr('id');
                 var map_info = $(this).attr('data-map');
                 console.log('map-info: '+map_info.split(','));
                 var points = map_info.split('|');
                 var mymap = L.map(id).setView([51.505, -0.09], 13);
                 for (var i = 0; i < points.length; i++){
                     var point = points[i].split(',');
                     console.log('point: '+point);
                     var marker = new L.marker(point);
                     marker.addTo(mymap);
                 }

                 var circle = L.circle([51.508, -0.11], {
                     color: 'red',
                     fillColor: '#f03',
                     fillOpacity: 0.5,
                     radius: 500
                 }).addTo(mymap);

                 L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                     attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                 }).addTo(mymap);
             }


                /*if ($(this).attr('data-chart')) {
                    var highcharts = $(this).attr('data-chart');
                    var hc = JSON.parse(highcharts);
                    $(this).highcharts(hc);
                }*/
            });
        }
    };
}(jQuery));