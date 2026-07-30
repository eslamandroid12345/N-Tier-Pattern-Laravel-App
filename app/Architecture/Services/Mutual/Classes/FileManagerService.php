<?php

namespace App\Architecture\Services\Mutual\Classes;

use App\Architecture\Services\Mutual\Interfaces\IFileManagerService;
use App\Architecture\Traits\FileManager;

class FileManagerService implements IFileManagerService
{
    use FileManager;
    public function handle($requestAttributeName, $folderName, $target = null) {
        $path = $this->upload($requestAttributeName, $folderName);
        if (!is_null($target)) {
            $this->deleteFile($target);
        }
        return $path;
    }

}
