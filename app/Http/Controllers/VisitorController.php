<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // This fixes the "Class DB not found" error
use Carbon\Carbon;
use App\Models\VisitRecord as Visit; // Use `VisitRecord` (table `visit_records`) as `Visit`

class VisitorController extends Controller
{
    // 1. Dashboard (Show Today's Visitors)
    public function index()
    {
        // Get visits for today, ordered by newest first
        // We use 'with' to load the related names (Visitor, Staff, Dept)
        $visits = Visit::with(['visitor', 'staff', 'department'])
                       ->whereDate('CheckInTime', Carbon::today())
                       ->orderBy('CheckInTime', 'desc')
                       ->get();

        return view('visitors.index', compact('visits'));
    }

    // 2. Show Register Form
    public function create()
    {
        // Pass departments/staff to the dropdowns if needed
        $departments = DB::table('departments')->get();
        // Get only host staff (not security/admins if you prefer)
        $staffMembers = DB::table('staff')->get(); 

        return view('visitors.create', compact('departments', 'staffMembers'));
    }

    // 3. Store New Visitor
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'Name' => 'required',
            'DeptID' => 'required',
            'StaffID' => 'required',
            'Purpose' => 'required'
        ]);

        // 1. Create or Find Visitor (Simple version: always create new visitor profile for now)
        // The `visitors` table uses `ContactNumber` (not `Phone`) and has no `Address` column.
        $visitorID = DB::table('visitors')->insertGetId([
            'Name' => $request->Name,
            'ContactNumber' => $request->Phone ?? 'N/A',
        ]);

        // 2. Create the Visit Record
        Visit::create([
            'VisitorID' => $visitorID,
            'DeptID' => $request->DeptID,
            'StaffID' => $request->StaffID,
            'Purpose' => $request->Purpose,
            // `visit_records` requires `VisitDate` (no default). Use today's date.
            'VisitDate' => Carbon::today()->toDateString(),
            'CheckInTime' => now(),
            'Status' => 'Active'
        ]);

        return redirect()->route('visitors.index')->with('success', 'Visitor registered successfully!');
    }

    // 4. Check Out Visitor
    public function checkOut($id)
    {
        $visit = Visit::where('VisitID', $id)->first();

        if ($visit) {
            $visit->update([
                'CheckOutTime' => now(),
                'Status' => 'Completed'
            ]);
            return back()->with('success', 'Visitor checked out.');
        }

        return back()->with('error', 'Visit not found.');
    }

// --- DELETE VISITOR (Admin Only) ---
public function destroy($id)
    {
        if (session('RoleID') != 3) {
            return back()->with('error', 'Only Admins can delete records.');
        }

        // We use 'VisitID' because that is what is in your Database
        $deleted = \App\Models\VisitRecord::where('VisitID', $id)->delete();

        if ($deleted) {
            return back()->with('success', 'Visitor record deleted successfully.');
        } else {
            return back()->with('error', 'Could not delete. Record not found.');
        }
    }
}