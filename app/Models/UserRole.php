<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $primaryKey = 'RoleID';
    protected $fillable = ['RoleName'];

    public function staff() {
        return $this->hasMany(Staff::class, 'RoleID', 'RoleID');
    }
}