<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    public $timestamps = false;

    public function patient() {
        return $this->belongsTo(Person::class);
    }
}
