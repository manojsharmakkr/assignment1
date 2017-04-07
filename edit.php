<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location: login.htm");
}
/*
 * GET ID form query  string
 * Load file XML
 * Query get Item
 * 
 */
$id = $_GET['id'];
$xmlFile = simplexml_load_file("db/auction.xml");
$item = $xmlFile->xpath('//item[id="' . $id . '"]');
?>
<?php
$errors = array();
/*
 * Validate POST data
 */
if ($_POST) {
    if (empty($_POST['item_name'])) {
        $errors[] = "Item is not empty";
    }
    if (empty($_POST['status'])) {
        $errors[] = "Status is not empty";
    }
    if (empty($_POST['description'])) {
        $errors[] = "Description is not empty";
    }
    if (empty($_POST['start_price'])) {
        $errors[] = "Start price is not empty";
    } else {
        if (!is_numeric($_POST['start_price'])) {
            $errors[] = "Start price is not valid";
        }
    }
    if (empty($_POST['reserve_price'])) {
        $errors[] = "Reserve price is not empty";
    } else {
        if (!is_numeric($_POST['reserve_price'])) {
            $errors[] = "Reserve price is not valid";
        }
    }
    if (empty($_POST['buy_it_now_price'])) {
        $errors[] = "Buy it now price is not empty";
    } else {
        if (!is_numeric($_POST['buy_it_now_price'])) {
            $errors[] = "Buy it now price is not valid";
        }
    }
    if (!empty($_POST['start_price']) && !empty($_POST['reserve_price']) && !empty($_POST['buy_it_now_price'])) {
        if ($_POST['start_price'] > $_POST['reserve_price']) {
            $errors[] = "The start price must no more than the reserve price";
        }
        if ($_POST['reserve_price'] > $_POST['buy_it_now_price']) {
            $errors[] = "The reserve price must be less than the buy-it-now price.";
        }
    }
    /*
     * Update to file XML
     */
    if (count($errors) == 0) {
        $item[0]->item_name = $_POST['item_name'];
        $item[0]->category = $_POST['category'];
        $item[0]->description = $_POST['description'];
        $item[0]->start_price = $_POST['start_price'];
        $item[0]->reserve_price = $_POST['reserve_price'];
        $item[0]->buy_it_now_price = $_POST['buy_it_now_price'];
        $item[0]->status = $_POST['status'];
        $xmlFile->asXML("db/auction.xml");
        header("Location: maintenance.htm");
    }
}
?>
<html>
    <head>
        <title>ShopOnline ListingPage</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="main_page">
            <div class="head_body">
                <?php
                require_once __DIR__ . '/navigation.php';
                ?>
            </div>
            <div class="main_body">
                <fieldset class="user">
                    <legend>Edit Item</legend>
                    <h4 class="required">* Required Field</h4>         
                    <?php
                    if (count($errors)) {
                        echo "<ul>";
                        foreach ($errors as $key => $value) {
                            echo $value . "<br/>";
                        }
                        echo "</ul>";
                    }
                    ?>               
                    <form action="" method="post">
                        <table>                           
                            <tr>
                                <td>Item Name*</td>
                                <td><input type="text" name="item_name" id="item_name" value="<?php echo $item[0]->item_name; ?>"/></td>
                            </tr>
                            <tr>
                                <td>Category*</td>
                                <td>
                                    <select name="category">
                                        <option value="Camera" <?php echo $item[0]->category == "Camera" ? "selected='selected'" : ""; ?>>Camera</option>
                                        <option value="Phone" <?php echo $item[0]->category == "Phone" ? "selected='selected'" : ""; ?>>Phone</option>
                                        <option value="Other" <?php echo $item[0]->category == "Other" ? "selected='selected'" : ""; ?>>Other</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Description*</td>
                                <td><input type="text" name="description" id="description" value="<?php echo $item[0]->description; ?>"/></td>
                            </tr>
                            <tr>
                                <td>Start Price*</td>
                                <td><input type="text" name="start_price" id="start_price" value="<?php echo $item[0]->start_price; ?>"/></td>
                            </tr>
                            <tr>
                                <td>Reserve Price*</td>
                                <td><input type="text" name="reserve_price" id="reserve_price" value="<?php echo $item[0]->reserve_price; ?>"/></td>
                            </tr>
                            <tr>
                                <td>Buy It Now Price*</td>
                                <td><input type="text" name="buy_it_now_price" id="buy_it_now_price" value="<?php echo $item[0]->buy_it_now_price; ?>"/></td>
                            </tr>
                            <tr>
                                <td>Status*</td>
                                <td>
                                    <select name="status">
                                        <option value="in_progress" <?php echo $item[0]->status == "in_progress" ? "selected='selected'" : ""; ?>>in_progress</option>
                                        <option value="sold" <?php echo $item[0]->status == "sold" ? "selected='selected'" : ""; ?>>sold</option>
                                        <option value="failed" <?php echo $item[0]->status == "failed" ? "selected='selected'" : ""; ?>>failed</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" value="OK"/>
                                    <input type="reset" value="Reset"/>
                                </td>
                            </tr>
                        </table>    
                    </form>
                </fieldset>
            </div>
        </div>
    </body>

</html>