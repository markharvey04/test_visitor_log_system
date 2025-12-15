<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff'; 
    protected $primaryKey = 'StaffID';
    
    // THIS LINE is the Key. 'password' MUST be here.
    protected $fillable = ['RoleID', 'DeptID', 'Username', 'Name', 'password'];

    public function department() {
        return $this->belongsTo(Department::class, 'DeptID', 'DepartmentID');
    }

    public function role() {
        return $this->belongsTo(UserRole::class, 'RoleID', 'RoleID');
    }
}