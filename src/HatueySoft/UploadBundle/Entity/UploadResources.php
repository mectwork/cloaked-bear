<?php

namespace HatueySoft\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HatueySoft\UploadBundle\Model\DocumentModel;

/**
 * UploadResources
 *
 * @ORM\Table(name="hatueysoft_upload_resources")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class UploadResources extends DocumentModel
{

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        parent::__preUpload();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        parent::__upload();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        parent::__removeUpload();
    }
}
