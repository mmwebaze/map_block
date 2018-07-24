# map_block
Use Map Block to add a Leaflet based Map as a block. The module supports the following 
features:
1. Points
2. Polygons
3. Lines (LineString)

##Usage
Co-ordinates are added to the 'Json Data to be mapped' text area in the map_block
configuration. The format of data is <b>longitude, latitude</b> and followed by <b>'|' </b>
for multiple points.<br>
<u>For example:</u>
* for single point:  -0.08,51.509
* for multi-points:  -0.08,51.509|-0.06,51.503|-0.047,51.51


## Installation

* with drush: drush en map_block -y
* with drupal console: drupal module:install map_block

## Still to be done
1. Add text area to set map position
2. If 1 above is not set, use one of the supplied data points
to set the position
3. Add select to set default zoom level 
4. use composer to download leaflet js
5. include support for Highmaps 
