<?php
require_once('vendor/autoload.php');

session_start();

$client = new Google_Client();
$client->setAuthConfig('client_secret_603224032718-33g1eseo3ekbdv2i8187m552ftrch2fg.apps.googleusercontent.com.json');
$client->setRedirectUri('http://'  . $_SERVER["HTTP_HOST"] . '/mine/APITest/oauth2callback.php');
$client->addScope(Google\Service\Youtube::YOUTUBE_FORCE_SSL);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>