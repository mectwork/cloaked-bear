<?php

namespace Buseta\BodegaBundle\Interfaces;


interface DateTimeAwareInterface
{
    /**
     * Set created date & time
     *
     * @param \DateTime $datetime
     */
    public function setCreated(\DateTime $datetime);

    /**
     * Set updated date & time
     *
     * @param \DateTime $datetime
     */
    public function setUpdated(\DateTime $datetime);
}
