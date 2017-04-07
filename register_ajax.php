<?php

session_start();
/*
 * function generate password
 */

function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

$errors = array();
/*
 * check valid information
 */
if ($_GET) {
    $username = preg_replace('/[^A-Za-z][0-9]/', '', $_GET['email']);
    $tmp_pass = generatePassword();
    $password = md5($tmp_pass);
    $firtname = $_GET['firtname'];
    $surname = $_GET['surname'];
    if (empty($username)) {
        $errors[] = 'Email is not empty!';
    }
    if (empty($firtname)) {
        $errors[] = 'Firstname is not empty!';
    }
    if (empty($surname)) {
        $errors[] = 'Surname is not empty!';
    }
    if (empty($password)) {
        $errors[] = 'Password is not empty!';
    }
    if (file_exists('users/' . $username . '.xml')) {
        $errors[] = 'Email already exists';
    }
    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", strtolower($_GET["email"]))) {
        $errors[] = 'Email is invalid';
    }
    /*
     * Load file XML file
     * query item by email
     * Save info and send mail to user
     */
    $xmlFile = simplexml_load_file("db/customers.xml");
    $email = $xmlFile->xpath('//customer[email="' . (String) $_GET['email'] . '"]');
    if (count($email)) {
        $errors[] = 'Email is not available.';
    }
    if (count($errors) == 0) {
        $xmlLocalCopy = new SimpleXMLElement($xmlFile->asXML());
        $ids = $xmlFile->xpath("//customer/id"); // select all ids        
        $newid = max(array_map("intval", $ids)) + 1; // change objects to `int`, get `max()`, + 1
        $newCustomer = $xmlLocalCopy->addChild("customer");
        // Add new child in XML file
        $newCustomer->addChild('id', $newid);
        $newCustomer->addChild('email', $_GET['email']);
        $newCustomer->addChild('password', md5($password));
        $newCustomer->addChild('firstname', $firtname);
        $newCustomer->addChild('surname', $surname);

        $dom = new DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xmlLocalCopy->asXML());
        $dom->save("db/customers.xml");

        //// Send mail register
        $to = $_GET['email'];
        $subject = "Welcome to ShopOnline!";
        $message = "Dear {$firtname}, welcome to use ShopOnline! Your customer id is {$_GET['email']} and the password is {$tmp_pass}.";
        $header = "From registration@shoponline.com.au";
        mail($to, $subject, $message, $header, "-r 1234567@student.swin.edu.au");

        $_SESSION['username'] = $username;
        $_SESSION['userid'] = (String) $newid;
        echo "successfull";
        die;
    }
}
?>
<?php

if (count($errors)) {
    echo "<ul>";
    foreach ($errors as $key => $value) {
        echo $value . "<br/>";
    }
    echo "</ul>";
}
?>              