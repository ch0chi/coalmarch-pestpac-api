<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 6/20/18
 * Time: 4:53 PM
 */

namespace PestPac;

class PestPacOauth{

  protected $pp;
  protected $grantType;
  protected $user;
  protected $pass;
  protected $clientId;
  protected $secret;
  protected $cookie_name='pp_token';

  public function __construct(PestPac $pestPac,$grantType){
    $this->pp = $pestPac;
    $this->user = $pestPac->getUser();
    $this->pass = $pestPac->getPass();
    $this->clientId = $pestPac->getClientId();
    $this->secret = $pestPac->getSecret();
    $this->grantType = $grantType;
  }

  function encodeToken(){
    $clientId = $this->clientId;
    $secret = $this->secret;
    return base64_encode("$clientId:$secret");
  }

  function getGrantType(){
    return $this->grantType;
  }

  function getData(){
    return
      $data = array(
      'grant_type' => $this->getGrantType(),
      'username' => $this->user,
      'password' => $this->pass
    );
  }

  function authenticate($url){

    $headers = array(
      'Content-Type' =>  'application/x-www-form-urlencoded; charset=utf-8',
      'Authorization' => 'Bearer ' . $this->encodeToken()
    );

    $response = $this->pp->curl($url,$this->getData(),$headers,'post');
    if($response['code'] === 200){
      $jsonOutput = json_decode($response['response'],true);
      $token = $jsonOutput["access_token"];
      setcookie($this->cookie_name, $token, time() + (86400 * 30), "/");
      return true; //authenticated
    }

    return false;
  }


}