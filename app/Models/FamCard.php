<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamCard extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $table = 'fam_card';

    
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
