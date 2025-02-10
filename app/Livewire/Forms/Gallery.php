<?php

namespace App\Livewire\Forms;

use App\Models\Interfaces\Photoable;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Ramsey\Uuid\Uuid;

class Gallery extends Form
{
    public $photos = [];
    public $uploadedPhotos = [];
    public $deletedPhotos = [];

    public function setPhotos(?Photoable $model)
    {
        if ($model !== null) {
            $this->photos = $model->photos()->orderPriority()->get()->toArray();
        } else {
            $this->photos = [];
        }

        foreach($this->photos as &$photo) {
            $photo['storage_path'] = Storage::disk('public')->url($photo['path']);
        }
    }
    
    public function updatedUploadedPhotos()
    {
        $this->resetValidation('uploadedPhotos');
        $this->validate([
            'uploadedPhotos.*' => 'image|max:10000'
        ], [
            'uploadedPhotos.*' => 'Image must be JPG, JPEG, PNG'
        ]);
        
        foreach($this->uploadedPhotos as $photo) {
            $this->photos[] = [
                'id' => Uuid::uuid4()->toString(),
                'storage_path' => $photo->temporaryUrl(),
                'temporaryPhoto' => $photo,
                'is_main' => false,
            ];
        }
    }

    public function renderPhotos($orderedIds)
    {
        $this->photos = collect($orderedIds)->map(function ($id) {
            return collect($this->photos)->where('id', $id['value'])->first();
        })->toArray();
    }
    
    public function setMain($id)
    {
        foreach($this->photos as &$photo) {
            if($photo['id'] == $id) {
                $photo['is_main'] = true;
            } else {
                $photo['is_main'] = false;
            }
        }
    }

    public function deletePhoto($id)
    {
        $collection = collect($this->photos);
        
        $deletedPhoto = $collection->first(function ($photo) use ($id) {
            return $photo['id'] == $id;
        });
        
        if (!isset($deletedPhoto['temporaryPhoto'])) {
            $this->deletedPhotos[] = $deletedPhoto;
        }

        $this->photos = array_values($collection->reject(function ($photo) use ($deletedPhoto) {
            return $photo['id'] === $deletedPhoto['id'];
        })->toArray());
    }

    public function store(Photoable $model)
    {
        if ($model === null) {
            return;
        }

        foreach ($this->deletedPhotos as $deletedPhoto) {
            Photo::destroy($deletedPhoto['id']);

            if (Storage::disk('public')->exists($deletedPhoto['path'])) {
                Storage::disk('public')->delete($deletedPhoto['path']);
            }
        }

        $hasMainPhoto = false;
        foreach ($this->photos as $photo) {
            if ($photo['is_main']) {
                $hasMainPhoto = true;
                break;
            }
        }
    
        if (!$hasMainPhoto && count($this->photos) > 0) {
            $this->photos[0]['is_main'] = true;
        }

        $p = 1;
        foreach ($this->photos as $photo) {
            if (isset($photo['temporaryPhoto'])) {
                $model->photos()->create([
                    'priority' => $p++,
                    'path' => Storage::disk('public')->put('photos/products', $photo['temporaryPhoto']),
                    'is_main' => $photo['is_main']
                ]);
            } else {
                $model->photos()->where('id', $photo['id'])->update([
                    'priority' => $p++,
                    'is_main' => $photo['is_main']
                ]);
            }
        }
    }
}