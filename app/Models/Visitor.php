<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $primaryKey = 'VisitorID';
    protected $fillable = ['Name', 'ContactNumber'];

    public function visits() {
        return $this->hasMany(VisitRecord::class, 'VisitorID', 'VisitorID');
    }
}