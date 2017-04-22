<?php

namespace KS\Mng;
use KS\Mng\MngException;
use SoapClient;
use SOAPHeader;

class Mng {
  private $url = 'http://service.mngkargo.com.tr/musterikargosiparis/musterikargosiparis.asmx?op=SiparisGirisiDetayliV2&wsdl';
  private $client;
  private $conf;
  function __construct($conf){
    if(!isset($conf['username']) || !isset($conf['password'])) {
      throw new MngException("Mng Kargo Ayarları Girilmedi");
    }

    $this->conf = $conf;

    $this->client = new SoapClient($this->url);

  }


  function CreateShipment($params){

    try {

      $data = array('parameters' => array_merge($params, array("pKullaniciAdi" => $this->conf['username'],
            "pSifre" => $this->conf['password'])));
      $CreateShipmentData = $this->client->SiparisGirisiDetayliV2($data);

      $response = $CreateShipmentData->SiparisGirisiDetayliV2Result
      if(!empty($response)){
        if(count(explode(':', $response)) <= 0){
          return $data['pChIrsaliyeNo'];
        } else {
          throw new MngException("Kargo Bilgileri Aktarımı Yapılamadı!". $response);
        }
      } else {
        throw new MngException("Gönderdiğiniz parametreleri kontrol ediniz!");
      }

    } catch (SoapFault $sf) {
      throw new MngException($sf);
    }
  }
}
