(function ($) {
    'use strict';

    Drupal.behaviors.map_block = {
        attach: function (context, settings) {

            $('.map_block_maps').once().each(function(index, value) {
             if ($(this).attr('data-map')) {
                 var id = $(this).attr('id');
                 var map_info = $(this).attr('data-map');
                 var geoType = $(this).attr('geotype');

                 var points = map_info.split('|');
                 console.log(points);
                 var map = L.map(id).setView(points[0].split(','), 13);
                 if (geoType == 'point'){
                     console.log('points');
                     for (var i = 0; i < points.length; i++){
                         var point = points[i].split(',');

                         var marker = new L.marker(point);
                         marker.addTo(map);
                     }
                 }
                 else{
                     var polygonPoints = new Array();

                     for (var i = 0; i < points.length; i++){
                         var point = points[i].split(',');
                         polygonPoints.push(point);

                     }
                     console.log(polygonPoints);
                     var polygon = L.polygon(polygonPoints).addTo(map);
                 }


                 var circle = L.circle([51.508, -0.11], {
                     color: 'red',
                     fillColor: '#f03',
                     fillOpacity: 0.5,
                     radius: 500
                 }).addTo(map);

                 L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                     attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                 }).addTo(map);
             }
            });
        }
    };
}(jQuery));