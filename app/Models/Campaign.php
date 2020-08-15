<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    /**
     * @var string
     */
    protected $table = 'campaigns';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'campaign_name',
        'url'
    ];

    protected $casts = [
        'user_id' => 'int',
        'campaign_name' => 'string',
        'url' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::Class);
    }

}
