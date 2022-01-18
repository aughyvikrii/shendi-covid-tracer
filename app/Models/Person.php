<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    public $timestamps = false;

    public function scopeNik($query, $nik, $match = true) {
        return $match ? $query->where('nik', (int) $nik) : $query->whereRaw('nik LIKE ?', "%". (int) $nik ."%");
    }

    public function scopeKK($query, $kk, $match = true) {
        return $match ? $query->where('kk', (int) $kk) : $query->whereRaw('kk LIKE ?', "%". (int) $kk ."%");
    }

    public static function findByNik($nik, $match = true) {
        return self::nik($nik, $match)->first();
    }

    public static function findByKk($kk, $match = true) {
        return self::kk($kk, $match)->first();
    }

    public static function getByKk($kk, $match = true) {
        return self::kk($kk, $match)->get();
    }

    public function setFirstNameAttribute($value) {
        $this->attributes['first_name'] = ucwords($value);
        $this->attributes['name'] = ucwords($value) . ( !empty(@$this->attributes['last_name']) ? " " . ucwords($this->attributes['last_name']) : "" );
    }

    public function setLastNameAttribute($value) {
        $this->attributes['last_name'] = ucwords($value);
        $this->attributes['name'] = $this->attributes['first_name'] . ( !empty($value) ? " " . ucwords($value) : "" );
    }

    public function religion() {
        return $this->hasOne(Religion::class, 'id', 'religion_id');
    }

    public function marital_status() {
        return $this->hasOne(MaritalStatus::class, 'id', 'marital_status_id');
    }

    public function gender() {
        return $this->hasOne(Gender::class, 'id', 'gender_id');
    }

    public function blood_type() {
        return $this->hasOne(BloodType::class, 'id', 'blood_type_id');
    }

    public function registrations() {
        return $this->hasMany(Registration::class, 'patient_id');
    }
}
