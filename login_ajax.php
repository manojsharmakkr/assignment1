<?php

/*
 * Proccesing data login
 */
session_start();
$errors = "";
if ($_GET) {
    /*
     * get username form request
     * hash password
     */
    $username = preg_replace('/[^A-Za-z][0-9]/', '', $_GET['email']);
    $password = md5($_GET['password']);
    /*
     * Load XML file
     */
    $xmlFile = simplexml_load_file("db/customers.xml");
    $xmlLocalCopy = new SimpleXMLElement($xmlFile->asXML());
    /*
     * check user match with database
     */
    foreach ($xmlLocalCopy as $account) {
        $name = $account->email;
        $pass = $account->password;
        $id = $account->id;
        if ($username = $name && $password == $pass) {
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = (String) $id;
            echo "successfull";
            exit();
        }
    }
    $errors = "Email or password is not valid";
}
echo $errors;
?>