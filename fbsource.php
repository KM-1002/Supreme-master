<?php
include './Facebook/autoload.php';
include('./fbconfig.php'); 
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://localhost/Supreme-master//fb-callback.php', $permissions);
?>