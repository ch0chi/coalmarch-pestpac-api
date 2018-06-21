<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 6/20/18
 * Time: 4:40 PM
 */

namespace PestPac;


class PestPac {

  protected $wwidUser;
  protected $wwidPass;
  protected $clientId;
  protected $secret;

  function __construct($wwidUser,$wwidPass,$clientId,$secret){
    $this->wwidUser = $wwidUser;
    $this->wwidPass = $wwidPass;
    $this->clientId = $clientId;
    $this->secret   = $secret;

  }

  function getUser(){
    return $this->wwidUser;
  }

  function getPass(){
    return $this->wwidPass;
  }

  function getClientId(){
    return $this->clientId;
  }

  function getSecret(){
    return $this->secret;
  }

  function test(){
    return $this->wwidUser;
  }
  function test2(){
    return $this->wwidPass;
  }

  function checkCookie(){
    if(isset($_COOKIE['pp_token'])){
      return $_COOKIE['pp_token'];
    }
    return false;
  }


  function curl($url, $data = array(), $headers = array(), $method = 'get', $debug = false){
    if(!empty($data)) {
      $param_string = http_build_query($data, null, '&');
    }
    else {
      $param_string = '';
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 500);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if(!empty($headers)) {
      $headersStringArray = array();
      foreach($headers as $k => $v) {
        $headersStringArray[] = "$k: $v";
      }
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headersStringArray);
    }

    if($debug) {
      curl_setopt($ch, CURLOPT_COOKIE, 'XDEBUG_SESSION=PHPSTORM');
    }
    switch($method) {
      case 'post':
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param_string);
        break;
      case 'put':
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param_string);
        break;
      case 'delete':
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param_string);
        break;
      default:
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    }


    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return array(
      'code' => $httpcode,
      'response' => $result
    );
  }




}