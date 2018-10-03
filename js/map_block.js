(function ($) {
    'use strict';

    Drupal.behaviors.map_block = {
        attach: function (context, settings) {

            $('.map_block_maps').once().each(function(index, value) {
             if ($(this).attr('data-map')) {
                 var id = $(this).attr('id');
                 var map_info = $(this).attr('data-map');

                 var geoType = $(this).attr('geotype');
                 var coordinatesObj = JSON.parse(map_info);

                 if (geoType === 'Point'){
                   var pointObj = coordinatesObj[0]['geometry']['coordinates'];
                   var map = L.map(id).setView([pointObj[1], pointObj[0]], $(this).attr('zoom'));
                   L.geoJSON(coordinatesObj).addTo(map);

                 }else{
                   var obj = coordinatesObj.coordinates[0][0];
                   var map = L.map(id).setView([obj[1], obj[0]], $(this).attr('zoom'));
                   L.geoJSON([coordinatesObj]).addTo(map);
                 }
               L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                 attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
               }).addTo(map);

             }
            });
        }
    };
}(jQuery));