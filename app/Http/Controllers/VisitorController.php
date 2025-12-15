<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\VisitRecord;
use App\Models\Department;
use App\Models\Staff;

class VisitorController extends Controller
{
    // 1. Show the Registration Form
    public function create()
    {
        $departments = Department::all();
        $staffMembers = Staff::all();
        
        return view('visitors.create', compact('departments', 'staffMembers'));
    }

    // 2. Save the Data (With Duplicate Check)
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'Name' => 'required',
            'ContactNumber' => 'required',
            'Purpose' => 'required',
            'DeptID' => 'required',
            'StaffID' => 'required',
        ]);

        // A. Create or Find the Visitor
        $visitor = Visitor::firstOrCreate(
            ['Name' => $request->Name],
            ['ContactNumber' => $request->ContactNumber]
        );

        // B. CHECK FOR DUPLICATES (The New Rule)
        // Look for any visit by this person that is still 'Active'
        $activeVisit = VisitRecord::where('VisitorID', $visitor->VisitorID)
                        ->where('Status', 'Active')
                        ->first();

        if ($activeVisit) {
            // If they are already here, stop and show an error
            return redirect()->back()
                ->with('error', 'Error: This visitor is already checked in and has not checked out yet!');
        }

        // C. Create the Visit Record if no duplicate found
        VisitRecord::create([
            'VisitorID' => $visitor->VisitorID,
            'DeptID' => $request->DeptID,
            'StaffID' => $request->StaffID,
            'VisitDate' => now()->toDateString(),
            'CheckInTime' => now(),
            'Purpose' => $request->Purpose,
            'Status' => 'Active'
        ]);

        return redirect()->route('visitors.create')->with('success', 'Visitor Registered Successfully!');
    }

    // 3. Show the Dashboard
    public function index()
    {
        $visits = VisitRecord::with(['visitor', 'department', 'staff'])
                    ->orderBy('VisitDate', 'desc')
                    ->orderBy('CheckInTime', 'desc')
                    ->get();

        return view('visitors.index', compact('visits'));
    }

    // 4. Check Out a Visitor
    public function checkOut($id)
    {
        $visit = VisitRecord::findOrFail($id);

        $visit->update([
            'CheckOutTime' => now(),
            'Status' => 'Completed'
        ]);

        return redirect()->route('visitors.index')->with('success', 'Visitor Checked Out Successfully!');
    }

    // --- DELETE VISITOR (Admin Only) ---
    public function destroy($id)
    {
        // Double check permissions just in case
        if (session('RoleID') != 3) {
            return back()->with('error', 'Only Admins can delete records.');
        }

        // Use DB or Model to delete
        \Illuminate\Support\Facades\DB::table('visits')->where('VisitID', $id)->delete();

        return back()->with('success', 'Visitor record deleted successfully.');
    }
}
