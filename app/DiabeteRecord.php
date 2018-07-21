<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiabeteRecord extends Model
{
    use SoftDeletes;
    
    protected $table = 'diabete_records';
    protected $primaryKey = 'id';
    protected $fillable = [	
                            'user_id', 'blood', 'date_times', 'ill_type', 'comment', 'type'
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
