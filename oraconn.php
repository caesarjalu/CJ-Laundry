<?php
$user = 'laundry';
$password = 'q1w2e3r4';
$dbname = 'database';
$connstring = 'localhost/' . $dbname;
$conn = oci_connect($user, $password, $connstring);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
?>