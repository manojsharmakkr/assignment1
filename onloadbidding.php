<?php
/*
 * Load XML file
 * get Item using Xpath
 * Render Item to HTML
 */
$xmlFile = simplexml_load_file("db/auction.xml");
$xmlLocalCopy = new SimpleXMLElement($xmlFile->asXML());
$items = $xmlLocalCopy->xpath('//item');
?>
<?php foreach ($items as $key => $value) { ?>
    <fieldset class="user">
        <form id="form">
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
                    <td><?php
                        echo substr($value->description, 0, 30);
                        echo strlen($value->description) > 30 ? " ..." : "";
                        ?></td>
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

                <?php if ($value->status != "sold" && ($interval->d > 0 || $interval->h > 0 || $interval->i > 0)) { ?>
                    <tr>
                        <td></td>
                        <td>
                            <a onclick="showPopup('<?php echo $value->id; ?>')" title="Place Bid" href="javascript:void(0)" class="place_bid">Place Bid</a>
                            <a onclick="buyitnow('<?php echo $value->id; ?>')" title="Buy It Now" href="javascript:void(0)" class="buyit_now">Buy It Now</a>
                        </td>
                    </tr>
                <?php } ?>                                
            </table>
        </form>
    </fieldset>
    <?php
}?>