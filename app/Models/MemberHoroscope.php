<?php

namespace App\Models;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class MemberHoroscope extends Model
{
    use HasUuid, StoreImage;

    protected $fillable = ['star_id' , 'rasi_id', 'lagnam'];

    protected $fileParamName = 'horoscope_image';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'horoscope';

    protected $imageFieldName = 'horoscope_image';

    public $resize = true;

    public $addWaterMark = true;

    public function star()
    {
        return $this->belongsTo(Star::class, 'star_id', 'id');
    }

    public function rasi()
    {
        return $this->belongsTo(Zodiac::class, 'rasi_id', 'id');
    }

    public function lagnam_rasi()
    {
        return $this->belongsTo(Zodiac::class, 'lagnam', 'id');
    }
}
