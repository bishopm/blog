<?php

namespace Bishopm\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use Plank\Mediable\Mediable;
use Actuallymab\LaravelComment\Contracts\Commentable;
use Actuallymab\LaravelComment\HasComments;

class Blog extends Model implements TaggableInterface, Commentable
{
    use Mediable;
    use TaggableTrait;
    use HasComments;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');
    protected $mustBeApproved = false;

    public function user()
    {
        return $this->belongsTo('Bishopm\Blog\Models\User');
    }
}
