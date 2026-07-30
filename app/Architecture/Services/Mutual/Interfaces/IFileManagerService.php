<?php

namespace App\Architecture\Services\Mutual\Interfaces;

interface IFileManagerService
{

    public function handle($requestAttributeName, $folderName,$target = null);
}
