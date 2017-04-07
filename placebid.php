<?php

session_start();
if (empty($_SESSION['username'])) {
    header("Location: login.php");
}
$id = $_GET['id'];
$xmlFile = simplexml_load_file("db/auction.xml");
$item = $xmlFile->xpath('//item[id="' . $id . '"]');
if (is_numeric($_GET['bid_price'])) {
    $current_bid = isset($item[0]->current_bid_price) ? $item[0]->current_bid_price : 0;
    if ($_GET['bid_price'] <= $current_bid) {
        echo "Sorry, your bid can not less than current bid price.";
        die;
    }
    $item[0]->current_bid_price = $_GET['bid_price'];
    $item[0]->customerID = $_SESSION['userid'];
    $xmlFile->asXML("db/auction.xml");
    echo "Thank you! Your bid is recorded in ShopOnline.";
} else {
    echo "Sorry, yourbid is not valid";
}
?>