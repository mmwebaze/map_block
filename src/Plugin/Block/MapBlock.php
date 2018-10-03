<?php
namespace Drupal\map_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\map_block\geometry\GeoJsonFeature;
use Drupal\map_block\geometry\Geometry;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Uuid\Php;

/**
 * Provides a 'map' block.
 *
 * @Block(
 *   id = "map_block",
 *   admin_label = @Translation("Map block"),
 *   category = @Translation("Custom map block based on Leaflet")
 * )
 */
class MapBlock extends BlockBase implements BlockPluginInterface, ContainerFactoryPluginInterface {

    protected $uuidGenerator;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, Php $uuidGenerator){
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->uuidGenerator = $uuidGenerator;
    }
   /**
    * {@inheritdoc}
    */
    public function build(){
        $config = $this->getConfiguration();
        $coordinates = explode('|',$this->cleanString($config['map_json']));
        $geoJsonCoordinates = array();
        foreach ($coordinates as $coordinate){
            $temp = explode(',',str_replace('"', '',$coordinate));
            array_push($geoJsonCoordinates, $temp);
        }

        $mapData = null;
        if ($config['geo_type'] == 'Point'){
            foreach ($geoJsonCoordinates as $key => $geoJsonCoordinate){
                $geometry = new Geometry($config['geo_type'], $geoJsonCoordinate);
                $geoJsonFeature = new GeoJsonFeature();
                $geoJsonFeature->setGeometry($geometry);
                $mapData[$key] = $geoJsonFeature;
            }
        }else{
            $geometry = new Geometry($config['geo_type'], $geoJsonCoordinates);
            $geoJsonFeature = new GeoJsonFeature();
            $geoJsonFeature->setGeometry($geometry);
            $mapData = $geometry;
        }

        return array(
            '#type' => 'markup',
            '#theme' => 'map_block_maps',
            '#map_data' => ['uuid' => $config['uuid'], 'map' => json_encode($mapData),
                'geotype' => $config['geo_type'], 'zoom' => $config['zoom']],
            '#attached' => array(
                'library' => array('map_block/map_block'),
            )
        );
    }
   /**
    * {@inheritdoc}
    */
    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();

        $uuid = $this->uuidGenerator->generate();

        $zoomLevels = array();

        for($zoom = 5; $zoom <= 30; $zoom++){
          $zoomLevels[$zoom] = $zoom;
        }

        $form['uuid'] = array(
            '#type' => 'hidden',
            '#value' => isset($config['uuid'])? $config['uuid']: $uuid,
        );
        $form['map_json'] = array(
            '#title' => $this->t('Json Data to be mapped'),
            '#type' => 'textarea',
            '#default_value' => isset($config['map_json']) ? $config['map_json'] : '',
            '#required' => TRUE,
        );
        $form['geo_type'] = array(
            '#type' => 'radios',
            '#title' => t('Geometry Types'),
            '#description' => $this->t('format is long, lat ex: -2.464459,36.83711|-5.464459,36.83711'),
            '#default_value' => isset($config['geo_type'])? $config['geo_type'] : 'Point',
            '#options' => [
              'Point' => $this->t('Point'),
              'LineString'=> $this->t('LineString'),
              'Polygon' => $this->t('Polygon')
            ],
        );
        $form['zoom'] = array(
          '#type' => 'select',
          '#title' => $this->t('Zoom level'),
          '#options' => $zoomLevels,
          '#default_value' => isset($config['zoom']) ? $config['zoom']:'0',
        );
        return $form;
    }
    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->setConfigurationValue('uuid', $form_state->getValue('uuid'));
        $this->setConfigurationValue('map_json', $form_state->getValue('map_json'));
        $this->setConfigurationValue('geo_type', $form_state->getValue('geo_type'));
        $this->setConfigurationValue('zoom', $form_state->getValue('zoom'));
    }
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition){
        return new static($configuration, $plugin_id, $plugin_definition,
            $container->get('uuid')
        );
    }

  /**
   * Removes any spaces from added coordinates
   *
   * @param $stringToClean
   *
   * @return string
   */
    private function cleanString($stringToClean){
        return $strWithoutSpave = preg_replace('/\s+/','',$stringToClean);
    }
}