<?php

namespace Drupal\map_block\geometry;

/**
 * Class GeoJsonFeature
 *
 * @package Drupal\map_block\geometry
 */
class GeoJsonFeature implements  \JsonSerializable {

    private $type = 'Feature';
    private $properties;
    private $geometry;

    /**
     * @return mixed
     */
    public function getGeometry()
    {
        return $this->geometry;
    }

    /**
     * @param mixed $geometry
     */
    public function setGeometry($geometry)
    {
        $this->geometry = $geometry;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param mixed $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return array
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);

        return $vars;
    }
}