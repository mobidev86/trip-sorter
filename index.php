<?php

// Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

$ts   = new TS\TripSorter();
$response = $ts->createSort();

echo "<pre>" . $response . "</pre>";