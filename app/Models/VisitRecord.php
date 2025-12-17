<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitRecord extends Model
{
    // Use the correct table name created by the migration
    protected $table = 'visit_records';

    // 2. Define the Primary Key
    protected $primaryKey = 'VisitID';

    // 3. Disable auto-incrementing if your ID is not an integer (Optional, usually safe to keep true)
    public $incrementing = true;

    // 4. Allow mass assignment
    protected $guarded = [];

    // Relationships
    public function visitor() {
        return $this->belongsTo(Visitor::class, 'VisitorID', 'VisitorID');
    }
    public function staff() {
        return $this->belongsTo(Staff::class, 'StaffID', 'StaffID');
    }
    public function department() {
        return $this->belongsTo(Department::class, 'DeptID', 'DepartmentID');
    }
}