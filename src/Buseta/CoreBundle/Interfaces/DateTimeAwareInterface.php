<?php

namespace Buseta\CoreBundle\Interfaces;


interface DateTimeAwareInterface
{
    /**
     * Set created date & time
     *
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created = null);

    /**
     * Set updated date & time
     *
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated = null);
}
