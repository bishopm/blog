<?php

namespace Bishopm\Blog\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Actuallymab\LaravelComment\CanComment;
use Illuminate\Database\Eloquent\SoftDeletes;
use Bishopm\Blog\Models\Setting;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use CanComment;
    use SoftDeletes;
    use HasRoles;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');
    
    public function blogs()
    {
        return $this->hasMany('Bishopm\Blog\Models\Blog');
    }
}
