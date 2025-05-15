<?php
require_once('function/callPage.php');
callPage('header');
callPage('navbar');
if (isset($_GET['page'])) {
    callPage($_GET['page']);
}
else {
    callPage('home');
}
callPage('footer');

?>