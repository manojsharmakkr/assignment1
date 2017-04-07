<?php
// start session
session_start();
// check user login
if (empty($_SESSION['username'])) {
    header("Location: login.htm");
}
// get ID
$id = $_GET['id'];
/*
 * Load file XML
 * Query get Item
 * Update status to "sold"
 */
$xmlFile = simplexml_load_file("db/auction.xml");
$item = $xmlFile->xpath('//item[id="' . $id . '"]');
$item[0]->status = "sold";
$item[0]->customerID = $_SESSION['userid'];
$xmlFile->asXML("db/auction.xml");
echo "successfull";
die;
?>