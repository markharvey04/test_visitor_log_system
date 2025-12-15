<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primaryKey = 'DepartmentID';
    protected $fillable = ['DepartmentName'];

    public function staff() {
        return $this->hasMany(Staff::class, 'DeptID', 'DepartmentID');
    }
}
