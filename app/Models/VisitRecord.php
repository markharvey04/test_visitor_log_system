<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitRecord extends Model
{
    protected $primaryKey = 'VisitID';
    protected $fillable = ['VisitorID', 'StaffID', 'DeptID', 'VisitDate', 'Purpose', 'CheckInTime', 'CheckOutTime', 'Status'];

    public function visitor() {
        return $this->belongsTo(Visitor::class, 'VisitorID', 'VisitorID');
    }

    public function department() {
        return $this->belongsTo(Department::class, 'DeptID', 'DepartmentID');
    }

    public function staff() {
        return $this->belongsTo(Staff::class, 'StaffID', 'StaffID');
    }
}