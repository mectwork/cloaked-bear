<?php

namespace HatueySoft\SecurityBundle\Manager;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SecurityManager
 *
 * @package HatueySoft\SecurityBundle\Manager
 */
class SecurityManager
{
    /**
     * @var
     */
    protected $security_config;


    /**
     * SecurityManager constructor.
     *
     * @param $security_config
     */
    public function __construct($security_config)
    {
      $this->security_config = $security_config;
    }

    /**
     * @return array
     */
    public function fileAsArray()
    {
     $data = Yaml::parse(file_get_contents($this->security_config));
     return $data;
    }

    /**
     * @param $array
     *
     * @return int
     */
    public function arrayAsFile($array)
    {
      $dump = Yaml::dump($array, 3);
      return file_put_contents($this->security_config,$dump);
    }
}
