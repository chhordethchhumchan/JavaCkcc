<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Video extends Model
{
    use SoftDeletes;
    
    protected $table = 'videos';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'user_id', 'video_url', 'title', 'description'
                          ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the user that own the ad
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
