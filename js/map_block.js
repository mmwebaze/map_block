(function ($) {
    'use strict';

    Drupal.behaviors.map_block = {
        attach: function (context, settings) {

            $('.map_block_maps').once().each(function(index, value) {
             if ($(this).attr('data-map')) {
                 var id = $(this).attr('id');
                 var map_info = $(this).attr('data-map');
                 console.log(JSON.parse(map_info));
                 var geoType = $(this).attr('geotype');

                 var map = L.map(id).setView([51.508, -0.11], 13);

                 if (geoType == 'Point'){
                     L.geoJSON(JSON.parse(map_info)).addTo(map);
                 }else{
                     L.geoJSON([JSON.parse(map_info)]).addTo(map);
                 }

                 L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                     attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                 }).addTo(map);
             }
            });
        }
    };
}(jQuery));