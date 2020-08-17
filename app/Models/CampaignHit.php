<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignHit extends Model
{
    /**
     * @var string
     */
    protected $table = 'campaign_hits';

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'latitude',
        'longitude',
        'browser',
        'location'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'campaign_id' => 'int',
        'latitude' => 'string',
        'longitude' => 'string',
        'browser' => 'string',
        'location' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::Class);
    }
}
