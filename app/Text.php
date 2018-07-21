<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Text extends Model
{
    use SoftDeletes;

    protected $table = 'texts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'image', 'title', 'description','url'
    ];

    /**
     * Get the user that own the ad
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
