<?php

namespace App\Architecture\Traits;

trait FileManager
{
    public function upload($requestAttributeName = null, $folder = '', $disk = 'public'){
        $path = null;
        if(request()->hasFile($requestAttributeName) && request()->file($requestAttributeName)->isValid()){
            $path = 'storage/'.request()->file($requestAttributeName)->store($folder, $disk);
        }
        return $path;
    }

    public function updateFile($requestAttributeName = null, $folder = '',$oldPath){
        $path = null;
        if(request()->hasFile($requestAttributeName) && request()->file($requestAttributeName)->isValid()){
            $path = $this->upload($requestAttributeName,$folder);
            if(file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        return $path;
    }

    public function deleteFile($oldPath){
        if(file_exists($oldPath)) {
            unlink($oldPath);
        }
    }
}
