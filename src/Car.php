<?php
    class Car
    {
        private $make_model;
        private $picture;
        private $price;
        private $miles;

    //why are the default values not being applied to the cars i add to the lot via the form on homepage?
        function __construct($car_kind, $photo = 'unavailable', $price_tag, $miles_onit = 120000)
        {
            $this->make_model = $car_kind;
            $this->picture = $photo;
            $this->price = $price_tag;
            $this->miles = $miles_onit;
        }

        function worthBuying($max_price, $max_miles)
        {
            return ($max_price > $this->price && $max_miles > $this->miles);
        }


        function setModel($new_model)
        {
            $this->model = $new_model;
        }

        function getModel()
        {
            return $this->make_model;
        }

        function setPicture($new_picture)
        {
            $this->picture = $new_picture;
        }

        function getPicture()
        {
            return $this->picture;
        }

        function setPrice($new_price)
        {
            $this->price = $new_price;
        }

        function getPrice()
        {
            return $this->price;
        }

        function setMiles($new_miles)
        {
            $this->miles = $new_miles;
        }

        function getMiles()
        {
            return $this->miles;
        }

        function save()
        {
            array_push($_SESSION['da_carz'], $this);
        }

        static function getAll()
        {
            return $_SESSION['da_carz'];
        }

        static function deleteAll()
        {
            $_SESSION['da_carz'] = array();
        }
    }
 ?>
