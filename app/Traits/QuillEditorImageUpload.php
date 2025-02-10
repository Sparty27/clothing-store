<?php
namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

trait QuillEditorImageUpload 
{
    public function uploadImage($base64Data)
    {
        try {
            $data = explode(',', $base64Data);
    
            $content = base64_decode($data[1]);
    
            $fileFormat = $this->getStringBetween($data[0], '/', ';');

            $path = 'editor-images/'.Uuid::uuid4().'.'.$fileFormat;
    
            if (!$fileFormat) {
                return;
            }

            Storage::disk('public')->put($path, $content);

            $this->dispatch('imageUploaded', Storage::url($path));

        } catch (Exception $ex) {
            Log::error('File error. Message: '.$ex->getMessage());
        }
    }

    public function deleteImage($imagePath) 
    {
        $storagePosition = strpos($imagePath, '/storage/');

        $relativePath = substr($imagePath, $storagePosition + 9);

        if (Storage::disk('public')->exists($relativePath)) {  
            Storage::disk('public')->delete($relativePath);
        }
    }

    private function getStringBetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);

        if ($ini == 0) {
            return '';
        }

        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        
        return substr($string, $ini, $len);
    }
}