<?php
/*
 * Loading XML file
 * query item based status (in_progess,sold,failed)
 * Render to HTML with case status
 */
$xmlFile = simplexml_load_file("db/auction.xml");
$xmlLocalCopy = new SimpleXMLElement($xmlFile->asXML());
/*
 * Load item with status: in_progress, sold, failed
 */
$items_progress = $xmlLocalCopy->xpath('//item[status="in_progress"]');
$items_sold = $xmlLocalCopy->xpath('//item[status="sold"]');
$items_failed = $xmlLocalCopy->xpath('//item[status="failed"]');
$revenue_sold = 0;
$revenue_failed = 0;
/*
 * Calculate revenue based sold or failed
 */
foreach ($items_sold as $key => $value) {
    $revenue_sold +=$value->current_bid_price * 0.03;
}
foreach ($items_failed as $key => $value) {
    $revenue_failed +=$value->reserve_price * 0.01;
}
?>
<?php if ($_GET['id'] == "process") { ?>
    <?php foreach ($items_progress as $key => $value) { ?>
        <fieldset class="user">
            <form>
                <table>
                    <tr>
                        <td>Item No:</td>
                        <td><?php echo $value->id ?></td>
                    </tr>
                    <tr>
                        <td>Item Name:</td>
                        <td><?php echo $value->item_name ?></td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td><?php echo $value->category ?></td>
                    </tr>                               
                    <tr>
                        <td>Description:</td>
                        <td>
                            <?php
                            echo substr($value->description, 0, 30);
                            echo strlen($value->description) > 30 ? " ..." : "";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Buy it Now Price:</td>
                        <td><?php echo $value->buy_it_now_price ?></td>
                    </tr>
                    <tr>
                        <td>Bid Price:</td>
                        <td><?php echo $value->current_bid_price ?></td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td><?php echo $value->status ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php
                            $now = new DateTime();
                            $future_date = new DateTime($value->endDate);
                            $interval = $future_date->diff($now);
                            echo $interval->format("%d days, %h hours, %i minutes");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>                                            
                            <a title="Edit" href="edit.php?id=<?php echo $value->id; ?>" class="place_bid">Edit</a>
                            <a title="Delete" href="delete.php?id=<?php echo $value->id; ?>" class="buyit_now">Delete</a>
                        </td>
                    </tr>
                </table>                                
            </form>
        </fieldset>
    <?php }
    ?>
<?php } else { ?>
    <div>
        <table>
            <tr>
                <td>Total Items Sold:</td>
                <td><?php echo count($items_sold) ?></td>
            </tr>
            <tr>
                <td>Total Items Failed:</td>
                <td><?php echo count($items_failed) ?></td>
            </tr>
            <tr>
                <td>Revenue:</td>
                <td><?php echo $revenue_sold - $revenue_failed ?></td>
            </tr>
        </table>
    </div>                    
    <h3>Sold Items</h3>
    <hr/>
    <?php foreach ($items_sold as $key => $value) { ?>
        <fieldset class="user">
            <form>
                <table>
                    <tr>
                        <td>Item No:</td>
                        <td><?php echo $value->id ?></td>
                    </tr>
                    <tr>
                        <td>Item Name:</td>
                        <td><?php echo $value->item_name ?></td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td><?php echo $value->category ?></td>
                    </tr>                                                                 
                    <tr>
                        <td>Buy it Now Price:</td>
                        <td><?php echo $value->buy_it_now_price ?></td>
                    </tr>
                    <tr>
                        <td>Bid Price:</td>
                        <td><?php echo $value->current_bid_price ?></td>
                    </tr>                                                                               
                </table>                                
            </form>
        </fieldset>
    <?php }
    ?>
    <h3>Failed Items</h3>
    <hr/>
    <?php foreach ($items_failed as $key => $value) { ?>
        <fieldset class="user">
            <form>
                <table>
                    <tr>
                        <td>Item No:</td>
                        <td><?php echo $value->id ?></td>
                    </tr>
                    <tr>
                        <td>Item Name:</td>
                        <td><?php echo $value->item_name ?></td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td><?php echo $value->category ?></td>
                    </tr>                              

                    <tr>
                        <td>Buy it Now Price:</td>
                        <td><?php echo $value->buy_it_now_price ?></td>
                    </tr>
                    <tr>
                        <td>Bid Price:</td>
                        <td><?php echo $value->current_bid_price ?></td>
                    </tr>                                                                                    
                </table>                                
            </form>
        </fieldset>
    <?php }
    ?>
    <?php
}?>