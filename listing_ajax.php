<?php

// Check Validate GET data
session_start();
$errors = array();
if ($_GET) {
    if (empty($_GET['item_name'])) {
        $errors[] = "Item is not empty";
    }
    if (empty($_GET['description'])) {
        $errors[] = "Description is not empty";
    }
    if (empty($_GET['start_price'])) {
        $errors[] = "Start price is not empty";
    } else {
        if (!is_numeric($_GET['start_price'])) {
            $errors[] = "Start price is not valid";
        }
    }
    if (empty($_GET['reserve_price'])) {
        $errors[] = "Reserve price is not empty";
    } else {
        if (!is_numeric($_GET['reserve_price'])) {
            $errors[] = "Reserve price is not valid";
        }
    }
    if (empty($_GET['buy_it_now_price'])) {
        $errors[] = "Buy it now price is not empty";
    } else {
        if (!is_numeric($_GET['buy_it_now_price'])) {
            $errors[] = "Buy it now price is not valid";
        }
    }
    if (empty($_GET['day']) && empty($_GET['hour']) && empty($_GET['min'])) {
        $errors[] = "Duration is required";
    }
    if (!empty($_GET['start_price']) && !empty($_GET['reserve_price']) && !empty($_GET['buy_it_now_price'])) {
        if ($_GET['start_price'] > $_GET['reserve_price']) {
            $errors[] = "The start price must no more than the reserve price";
        }
        if ($_GET['reserve_price'] > $_GET['buy_it_now_price']) {
            $errors[] = "The reserve price must be less than the buy-it-now price.";
        }
    }
    if (count($errors) == 0) {
        /*
         * Load XML file
         * Query get ItemID using xpath
         * Add item into XML file
         */
        $xmlFile = simplexml_load_file("db/auction.xml");
        $xmlLocalCopy = new SimpleXMLElement($xmlFile->asXML());
        $ids = $xmlLocalCopy->xpath("//item/id"); // select all ids
        $newid = max(array_map("intval", $ids)) + 1; // change objects to `int`, get `max()`, + 1
        $newItem = $xmlLocalCopy->addChild("item");
        /*
         * Add Chidld in XML file
         */
        $newItem->addChild('id', $newid);
        $newItem->addChild('item_name', $_GET['item_name']);
        $newItem->addChild('category', $_GET['category']);
        $newItem->addChild('description', $_GET['description']);
        $newItem->addChild('start_price', $_GET['start_price']);
        $newItem->addChild('reserve_price', $_GET['reserve_price']);
        $newItem->addChild('buy_it_now_price', $_GET['buy_it_now_price']);
        $newItem->addChild('current_bid_price', 0);
        $start_date = date('d-m-Y');
        $start_time = date('H:i:s');
        $end_time = date("d-m-Y H:i:s", time() + $_GET['day'] * 86400 + $_GET['hour'] * 3600 + $_GET['min'] * 60);
        $newItem->addChild('startDate', $start_date);
        $newItem->addChild('endDate', $end_time);
        $newItem->addChild('startTime', $start_time);
        $newItem->addChild('customerID', $_SESSION['userid']);
        $newItem->addChild('status', 'in_progress');
        /*
         * Save data
         */
        $dom = new DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xmlLocalCopy->asXML());
        $dom->save("db/auction.xml");
        echo "successfull";die;
    } else {
        echo "<ul>";
        foreach ($errors as $key => $value) {
            echo $value . "<br/>";
        }
        echo "</ul>";
    }
}
?>