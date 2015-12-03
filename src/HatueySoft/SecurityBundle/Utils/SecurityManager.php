<?php

namespace HatueySoft\SecurityBundle\Utils;
use Symfony\Component\Yaml\Yaml;


class SecurityManager {

      protected $security_config;

      public function __construct($security_config)
      {
          $this->security_config = $security_config;
      }


      public function fileAsArray()
      {
         $data = Yaml::parse(file_get_contents($this->security_config));
         return $data;
      }

      public function arrayAsFile($array)
      {
          $dump = Yaml::dump($array, 3);
          return file_put_contents($this->security_config,$dump);
      }

}
