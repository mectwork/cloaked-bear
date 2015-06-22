<?php

namespace Buseta\UploadBundle\Model;


interface UploadAwareInterface
{
    public function preUpload();
    public function upload();
    public function removeUpload();
}
