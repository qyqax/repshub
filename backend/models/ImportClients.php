<?php

namespace backend\models;

use Yii;

class ImportClients extends CSV{
	
    public $items =
        [
        'client_email' => ['content' => 'Email'],
        'client_phone' => ['content' => 'Phone'],
        'client_city' => ['content' => 'City'],
        'client_country' => ['content' => 'Country'],
        'client_address' => ['content' => 'Address'],
        'client_postal_code' => ['content' => 'Postal code'],       
        'client_gender' => ['content' => 'Sex'],
        'client_birthdate' => ['content' => 'Birthdate'],
        'NIF' => ['content' => 'NIF number'],
        'card_id_number' => ['content' => 'Id number'],
        'client_fb' => ['content' => 'Facebook'],
        'client_tw' => ['content' => 'Tweeter'],
        ];	


}