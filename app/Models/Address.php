<?php

namespace App\Models;

class Address
{
    public string $street;
    public string $city;
    public string $country;
    public string $postalCode;

    public function __construct()
    {
        
    }
}