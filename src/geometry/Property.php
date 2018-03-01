<?php
namespace Drupal\map_block\geometry;

class Property implements  \JsonSerializable {

    private $name;
    private $amenity;
    private $popupContent;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAmenity()
    {
        return $this->amenity;
    }

    /**
     * @param mixed $amenity
     */
    public function setAmenity($amenity)
    {
        $this->amenity = $amenity;
    }

    /**
     * @return mixed
     */
    public function getPopupContent()
    {
        return $this->popupContent;
    }

    /**
     * @param mixed $popupContent
     */
    public function setPopupContent($popupContent)
    {
        $this->popupContent = $popupContent;
    }
    /**
     * @return array
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);

        return $vars;
    }
}