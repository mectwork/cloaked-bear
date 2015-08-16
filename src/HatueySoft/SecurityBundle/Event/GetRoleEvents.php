<?php
/**
 * Created by PhpStorm.
 * User: firomero
 * Date: 10/10/14
 * Time: 12:13
 */

namespace HatueySoft\SecurityBundle\Event;
use Symfony\Component\EventDispatcher\Event;


class GetRoleEvents extends Event{
    protected $command;
    public function __construct($command="")
    {
        $this->command = $command;
    }

    public function getCommand()
    {
        return $this->command;
    }

} 