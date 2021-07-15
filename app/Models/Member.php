<?php

namespace App\Models;

use App\Traits\StoreImage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jamesh\Uuid\HasUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Member extends Authenticatable
{
    use SoftDeletes, HasUuid, StoreImage;

    protected $guard = 'member';

    protected $redirectTo = '/';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
        'email',
        'dob',
        'religion',
        'mother_tongue_id',
        'blood_id',
        'gender',
        'phone_no',
        'email_verified_at',
        'member_code'
    ];

    protected $dates = [
        'dob'
    ];

    protected $hidden = [
        'password'
    ];

    //protected $primaryKey = 'username';

    protected $fileParamName = 'profile_photo';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'profile_photo';

    protected $imageFieldName = 'profile_photo';

    protected $resize = true;

    public $addWaterMark = true;

    protected $casts = ['dob' => 'date'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });

        static::addGlobalScope('active_account_only', function (Builder $builder) {
            $builder->where('account_status', '=', MEMBER_ACCOUNT_STATUS_ACTIVE);
        });

    }

    public function blood()
    {
        return $this->belongsTo(Blood::class, 'blood_id', 'id');
    }

    public function mother_tongue()
    {
        return $this->belongsTo(MotherTongue::class, 'mother_tongue_id', 'id');
    }

    public function educations()
    {
        return $this->hasMany(MemberEducation::class, 'member_id', 'id');
    }

    public function occupation()
    {
        return $this->hasOne(MemberOccupation::class, 'member_id', 'id');
    }

    public function family()
    {
        return $this->hasOne(MemberFamily::class, 'member_id', 'id');
    }

    public function location()
    {
        return $this->hasOne(MemberLocation::class, 'member_id', 'id');
    }

    public function horoscope()
    {
        return $this->hasOne(MemberHoroscope::class, 'member_id', 'id');
    }

    public function marital_status()
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_status_id', 'id');
    }

    public function dhosam()
    {
        return $this->belongsTo(Dhosam::class, 'dhosam_id', 'id');
    }


    public function interest_received()
    {
        return $this->hasMany(MemberInterestedProfile::class, 'profile_member_id', 'id');
    }

    public function interest_sent_profiles()
    {
        return $this->hasMany(MemberInterestedProfile::class, 'profile_member_id', 'id')->where('member_id', auth()->user()->id);
    }

    public function interested_profiles()
    {
        return $this->hasMany(MemberInterestedProfile::class, 'member_id', 'id')->where('profile_status', PROFILE_INTEREST);
    }

    public function shortlisted_profiles()
    {
        return $this->hasMany(MemberInterestedProfile::class, 'member_id', 'id')->where('profile_status', PROFILE_SHORTLIST);
    }

    public function ignored_profiles()
    {
        return $this->hasMany(MemberInterestedProfile::class, 'member_id', 'id')->where('profile_status', PROFILE_IGNORED);
    }

    public function member_viewed_profiles()
    {
        return $this->hasMany(MemberViewedProfile::class, 'member_id', 'id');
    }

    public function member_profile_viewed()
    {
        return $this->hasMany(MemberViewedProfile::class, 'profile_member_id', 'id');
    }

    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getDobAttribute($value)
    {
        return date("d-m-Y", strtotime($value));
    }

    public function getFullNameAttribute()
    {
        $name = $this->first_name . " " . $this->last_name;
        return ucfirst($name);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['dob'])->age;
    }

    public function getGenderNameAttribute()
    {
        return $this->attributes['gender'] == MALE ? 'Male' : 'Female';
    }

    public function getCreatedAtAttribute()
    {
        return date("d-m-Y", strtotime($this->attributes['created_at']));
    }

    public function secureProfilePhoto()
    {
        if ($this->attributes['profile_photo']) {
            return asset('site/images/profile_photo/thumbnails/' . $this->profile_photo);
        } else {
            return $this->getDefaultProfilePhoto();
        }
    }

    public function getDefaultProfilePhoto()
    {
        if ($this->gender == MALE) {
            return asset('site/images/site_images/male_default.jpg');
        } else {
            return asset('site/images/site_images/female_default.jpg');
        }
    }

    public function getPaymentStatusTextAttribute()
    {
        if ($this->attributes['payment_status'] == PAYMENT_STATUS_PAID) {
            return 'Paid';
        } elseif($this->attributes['payment_status'] == PAYMENT_STATUS_NOT_PAID) {
            return 'Not Paid';
        }
    }

    public function getAccountStatusTextAttribute()
    {
        if ($this->attributes['account_status'] == MEMBER_ACCOUNT_STATUS_ACTIVE) {
            return 'Active';
        } elseif($this->attributes['account_status'] == MEMBER_ACCOUNT_STATUS_DEACTIVATE) {
            return '<b class="text-danger">DeActivated</b>';
        }
    }


    public function checkIsUserCompletedIsProfileEntry()
    {

        $needed_information = [];
        if ($this->phone_no == null) {
            $needed_information['basic'][] = 'phone_no';
        }

        if ($this->email == null) {
            $needed_information['basic'][] = 'email';
        }

        if ($this->profile_photo == null) {
            $needed_information['basic'][] = 'profile_photo';
        }

        if ($this->educations == null) {
            $needed_information['education'][] = 'all';
        }

        if ($this->occupation == null) {
            $needed_information['occupation'][0] = 'all';
        } elseif ($this->occupation) {
            if ($this->occupation->role == null) {
                $needed_information['occupation'][1] = 'role';
            }
            if ($this->occupation->organisation_details == null) {
                $needed_information['occupation'][2] = 'organisation_details';
            }
            if ($this->occupation->job_location == null) {
                $needed_information['occupation'][3] = 'job_location';
            }
        }

        if ($this->family == null) {
            $needed_information['family'][0] = 'all';
        } elseif ($this->family) {
            if ($this->family->parents == null) {
                $needed_information['family'][1] = 'parents';
            }
        }

        if ($this->location == null) {
            $needed_information['location'][0] = 'all';
        } else if ($this->location) {
            if ($this->location->address == null) {
                $needed_information['location'][1] = 'address';
            }
            if ($this->location->city_id == null) {
                $needed_information['location'][] = 'city';
            }
            if ($this->location->state_id == null) {
                $needed_information['location'][] = 'state';
            }
            if ($this->location->pincode == null) {
                $needed_information['location'][] = 'pincode';
            }
        }

        if ($this->horoscope == null) {
            $needed_information['horoscope'][] = 'all';
        } elseif ($this->horoscope) {
            if ($this->horoscope->rasi_id == null) {
                $needed_information['horoscope'][] = 'rasi';
            }
            if ($this->horoscope->star_id == null) {
                $needed_information['horoscope'][] = 'rasi';
            }
            if ($this->horoscope->horoscope_image == null) {
                $needed_information['horoscope'][] = 'horoscope_image';
            }
        }

        if ($needed_information == null) {
            $this->profile_completed = 1;
            $this->save();
        }
    }

    public function scopeWhereMemberCode($query, $code)
    {
        return $query->where('member_code', $code);
    }

    public function viewProfileLocation()
    {
        return false;
    }


    public function current_user_interest_received()
    {
        return $this->hasOne(MemberInterestedProfile::class, 'member_id', 'id')
        ->where('profile_member_id', auth()->user()->id)
        ->where('profile_status', PROFILE_INTEREST)
        ;
    }

    public function current_user_interested_profiles()
    {
        return $this->hasOne(MemberInterestedProfile::class, 'profile_member_id', 'id')
        ->where('member_id', auth()->user()->id);
    }


}
