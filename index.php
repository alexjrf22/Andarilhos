<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/routers.php';

use App\Models\ContactModel as Contact;

$contact = new Contact();
$contacts = $contact->readAll();

dump($contacts);

