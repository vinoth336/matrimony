<?php

namespace App\Models;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class MemberProfilePhoto extends Model
{
    use HasUuid, StoreImage;

    protected $profilePhotoPath = '';
    protected $profileThumbnailSmall = '';
    protected $profileThumbnailMedium = '';


    protected $fileParamName = 'profile_photos';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'profile_photos';

    protected $imageFieldName = 'profile_photo';

    protected $resize = true;

    public $addWaterMark = true;

    public function getAttributeProfilePhoto()
    {

    }

    public function getAttributeThumbnail()
    {

    }

    public function secureProfilePhoto()
    {
        if ($this->attributes['profile_photo']) {
            return asset('site/images/profile_photos/thumbnails') . "/" . rawurlencode($this->profile_photo);
        } else {
            return $this->getDefaultProfilePhoto();
        }
    }

    public function secureFullSizeProfilePhoto()
    {
        if ($this->attributes['profile_photo']) {
            return asset('site/images/profile_photos') . "/" . rawurlencode($this->profile_photo);
        } else {
            return null;
        }
    }

    public function securePhoto()
    {
        if ($this->attributes['profile_photo']) {
            return asset('site/images/profile_photos/' . $this->profile_photo);
        } else {
            return null;
        }
    }
}
