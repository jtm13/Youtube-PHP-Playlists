<?php
require_once('vendor/autoload.php');

session_start();

$client = new Google_Client();
$client->setAuthConfig('client_secret_603224032718-33g1eseo3ekbdv2i8187m552ftrch2fg.apps.googleusercontent.com.json');
$client->addScope(Google\Service\Youtube::YOUTUBE_FORCE_SSL);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $youtube = new Google\Service\Youtube($client);
  $channel = $youtube->channels->listChannels('snippet', array('mine' => true));
  echo json_encode($channel);
} else {
  $redirect_uri = 'http://' . $_SERVER["HTTP_HOST"] . '/mine/APITest/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>