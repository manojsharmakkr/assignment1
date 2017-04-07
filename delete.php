<?php

session_start();
if (empty($_SESSION['username'])) {
    header("Location: login.htm");
}
/*
 * GET ID form query  string
 * Load file XML
 * Query get Items
 */
$id = $_GET['id'];
$xmlFile = simplexml_load_file("db/auction.xml");
$item = $xmlFile->xpath('//item[id="' . $id . '"]');
$key = 0;
/*
 * Delete item by ID
 */
foreach ($xmlFile->item as $value) {
    if ($value->id == $id) {
        unset($xmlFile->item[$key]);
        break;
    }
    $key++;
}
$xmlFile->asXML("db/auction.xml");
header("Location: maintenance.htm");
