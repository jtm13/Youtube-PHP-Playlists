<?php
require_once('vendor/autoload.php');
$client = new Google_Client();
$client->setAuthConfig('client_secret_603224032718-33g1eseo3ekbdv2i8187m552ftrch2fg.apps.googleusercontent.com.json');
$client->addScope(Google\Service\Youtube::YOUTUBE_READONLY);
$client->setRedirectUri('http://' . $_SERVER["HTTP_HOST"] . '/mine/APITest/oauth2callback.php');
// offline access will give you both an access and refresh token so that
// your app can refresh the access token without user interaction.
$client->setAccessType('offline');
// Using "consent" ensures that your application always receives a refresh token.
// If you are not using offline access, you can omit this.
$client->setApprovalPrompt("auto");
$client->setLoginHint('jtm88754@gmail.com');
$client->setIncludeGrantedScopes(true);   // incremental auth

if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit();
} else {
    $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $access_token = $client->getAccessToken();
    $client->setAccessToken($access_token);
    $youtube = new Google\Service\Youtube($client);
    $playlists = $youtube->playlists->listPlaylists('snippet, status, contentDetails', array('mine' => true, 'maxResults' => 50));
    echo "<ul>
        <li>PlayLists:</li>";
    echo "<li>Total Playlists: " . $playlists->getPageInfo()->getTotalResults() . "</li>";
    $sum = 0;
    foreach ($playlists->getItems() as $playlist) {
        echo '<ul type="square">';
        echo "<li>Title: " . $playlist->getSnippet()->getTitle() . "</li>";
        echo "<li>Description: " . $playlist->getSnippet()->getDescription() . "</li>";
        echo "<li>Status: " . $playlist->getStatus()->getPrivacyStatus() . "</li>";
        $count = intval($playlist->getContentDetails()->getItemCount()); 
        echo "<li>Video Count: " . $count . "</li>";
        $sum += $count;
        echo "</ul>";
    }
    echo "<li>Total Videos: " . $sum . "</li>";
    echo "</ul>";
}
?>