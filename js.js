/*
 * Function maintance
 * execute when click button Process Auction Items or Generate Report
 */

function maintaince(id) {
    /*
     * check id = process or generate correspond with two buttons Process Auction Items or Generate Report
     * set style display or visible when click two buttons
     */
    if (id == 'process') {
        document.getElementById(id).style.display = "block";
        document.getElementById("generate").style.display = "none";
    } else {
        document.getElementById(id).style.display = "block";
        document.getElementById("process").style.display = "none";
    }
    /*
     *   Ajax Section
     */
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    /*
     * Check readyState and Status response  data
     * Check response data and operate with this data
     */
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById(id).innerHTML = xmlhttp.responseText;
        }
    }
    /*
     * Send request URL
     * with method POST or GET
     */
    xmlhttp.open("GET", "maintaince_process.php?&id=" + id, true);
    xmlhttp.send();

}
/*
 * Function show popup
 * get Element popup using getElementById
 * Set style to show popup
 */
function showPopup(id) {
    document.getElementById("popup").style.display = "block";
    document.getElementById("bid_id").value = id;
    document.getElementById("overlay").style.display = "block";
}
/*
 * Function BidItem when click Bid
 */
function BidItem() {
    var xmlhttp;
    /*
     * get ID of item
     * get bid price want to update
     */
    var id = document.getElementById("bid_id").value;
    var bid_price = document.getElementById("bid_price").value;
    /*
     * Ajax section
     */
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    /*
     * Check readyState and Status response  data
     * Check response data and operate with this data
     */
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (confirm(xmlhttp.responseText)) {
                location.reload();
            }
        }
    }
    /*
     * Send request URL
     * with method POST or GET
     */
    xmlhttp.open("GET", "placebid.php?bid_price=" + bid_price + "&id=" + id, true);
    xmlhttp.send();
}
/*
 * Function close popup
 * Set style to show popup
 */
function closePopup() {
    document.getElementById("popup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}
/*
 * function to load item 5's
 */
function onloadBidding() {
    loadbid();
    setInterval(function() {
        loadbid();
    }, 5000);
}
function loadbid() {
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    /*
     * Check readyState and Status response  data
     * Check response data and operate with this data
     */
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("showitem").innerHTML = xmlhttp.responseText;

        }
    }
    /*
     * Send request URL
     * with method POST or GET
     */
    xmlhttp.open("GET", "onloadbidding.php", true);
    xmlhttp.send();
}
/*
 * function login
 */
function login() {
    var xmlhttp;
    /*
     * get email of item
     * get password of item
     */
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    /*
     * Ajax Section
     */
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    /*
     * Check readyState and Status response  data
     * Check response data and operate with this data
     */
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "successfull") {
                sessionStorage.username = "loged";
                location.href = "index.php";
            } else {
                document.getElementById("error").innerHTML = xmlhttp.responseText;
            }
        }
    }
    /*
     * Send request URL
     * with method POST or GET
     */
    xmlhttp.open("POST", "login_ajax.php?email=" + email + "&password=" + password, true);
    xmlhttp.send();
}
/*
 * function register
 */
function register() {
    var xmlhttp;
    /*
     * get email of item
     * get firtname of item
     * get surname of item
     */
    var email = document.getElementById("email").value;
    var firtname = document.getElementById("firtname").value;
    var surname = document.getElementById("surname").value;
    /*
     * Ajax Section
     */
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    /*
     * Check readyState and Status response  data
     * Check response data and operate with this data
     */
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "successfull") {
                location.href = "index.php";
            } else {
                document.getElementById("error").innerHTML = xmlhttp.responseText;
            }
        }
    }
    /*
     * Send request URL
     * with method POST or GET
     * Send request with: email, first, surname
     */
    xmlhttp.open("POST", "register_ajax.php?email=" + email + "&firtname=" + firtname + "&surname=" + surname, true);
    xmlhttp.send();
}
/*
 * function buy it now
 * with argument Item ID
 */
function buyitnow(id) {
    /*
     * Ajax Section
     */
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    /*
     * Check readyState and Status response  data
     * Check response data and operate with this data
     */
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "successfull") {
                if (confirm('Thank you for purchasing this item.')) {
                    location.reload();
                }

            }
        }
    }
    /*
     * Send request URL
     * with method POST or GET
     * Send request with: ID
     */
    xmlhttp.open("GET", "buyitnow.php?id=" + id, true);
    xmlhttp.send();
}
/*
 * function edit
 * with argument Item ID
 */
function edit(id) {
    /*
     * Ajax Section
     */
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    /*
     * Check readyState and Status response  data
     * Check response data and operate with this data
     */
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "successfull") {
                location.reload();
            }
        }
    }
    /*
     * Send request URL
     * with method POST or GET
     * Send request with: ID
     */
    xmlhttp.open("GET", "buyitnow.php?id=" + id, true);
    xmlhttp.send();
}
/*
 * funtion listing
 */
function listing() {
    var xmlhttp;
    /*
     * get item_name of item
     * get category of item
     * get description of item
     * get start_price of item
     * get reserve_price of item
     * get buy_it_now_price of item
     * get day of item
     * get hour of item
     * get min of item
     */
    var item_name = document.getElementById("item_name").value;
    var category = document.getElementById("category").value;
    var description = document.getElementById("description").value;
    var start_price = document.getElementById("start_price").value;
    var reserve_price = document.getElementById("reserve_price").value;
    var buy_it_now_price = document.getElementById("buy_it_now_price").value;
    var day = document.getElementById("day").value;
    var hour = document.getElementById("hour").value;
    var min = document.getElementById("min").value;
    /*
     * Ajax Section
     */
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    /*
     * Check readyState and Status response  data
     * Check response data and operate with this data
     */
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "successfull") {
                alert("Listing is successfull!")
                location.href = "listing.htm";
            } else {
                document.getElementById("error").innerHTML = xmlhttp.responseText;
            }
        }
    }
    /*
     * Send request URL
     * with method POST or GET
     * Send request with: item_name, category, description,start_price,reserve_price,buy_it_now_price, day,hour, min
     */
    xmlhttp.open("GET", "listing_ajax.php?item_name=" + item_name + "&category=" + category + "&description=" + description + "&start_price=" + start_price + "&start_price=" + start_price + "&reserve_price=" + reserve_price + "&buy_it_now_price=" + buy_it_now_price + "&day=" + day + "&hour=" + hour + "&min=" + min, true);
    xmlhttp.send();
}