<?php

namespace Drupal\map_block\geometry;

/**
 * Class Geometry
 *
 * @package Drupal\map_block\geometry
 */
class Geometry implements  \JsonSerializable{

    private $type;
    private $coordinates;

    public function __construct($type, $coordinates) {
        $this->type = $type;
        if ($this->type == 'Polygon'){
            $this->coordinates = [$coordinates];
        }
        else{
            $this->coordinates = $coordinates;
        }
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
     * @return an array of coordinates in loglat format
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @param mixed $coordinates
     */
    public function setCoordinates(array $coordinates)
    {

        $this->coordinates = $coordinates;
    }
    /**
     * @return array
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);

        return $vars;
    }
}