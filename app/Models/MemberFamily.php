<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class MemberFamily extends Model
{
    use HasUuid;

    protected $fillable = ['family_type_id', 'parents', 'brothers', 'sisters'];

    public function family_type()
    {
        return $this->belongsTo(FamilyType::class, 'family_type_id', 'id');
    }

}
