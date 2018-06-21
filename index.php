<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pest Pac API</title>
    <link href="./public/css/app.css" rel="stylesheet">
</head>
<body>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 6/20/18
 * Time: 4:40 PM
 */

require_once('app/PestPac.php');
require_once('app/PestPacOauth.php');
use PestPac\PestPac;
use PestPac\PestPacOauth;


$wwid_user = '';
$wwid_pass = '';
$id = '';
$secret = '';
$tokenUrl = "https://is.workwave.com/oauth2/token?scope=openid";
$url = "https://is.workwave.com/oauth2/token?scope=openid";
$grantType = 'password';

$pp = new PestPac($wwid_user,$wwid_pass,$id,$secret);
$ppc = new PestPacOauth($pp,'password');
$ppc->authenticate($url);
print_r($pp->checkCookie());


?>

<div class="container">
    <div class="card">
        <div class="card-content">
            <form class="control" action="/index.php">
                <button type="submit" class="button is-block is-info is-large">Submit</button>
            </form>
        </div>
    </div>

</div>

</body>
</html>
