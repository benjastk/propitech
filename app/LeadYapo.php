<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadYapo extends Model
{
    protected $table = 'leads_yapo';
    protected $fillable = [
        'external_id',
        'name',
        'email',
        'phone',
        'message',
        'ad_title',
        'price',
        'created_at_source'
    ];
}
