<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // 1. List all Staff Members
    public function index()
    {
        // Get all staff and join with Roles/Departments for names
        $users = DB::table('staff')
            ->join('user_roles', 'staff.RoleID', '=', 'user_roles.RoleID')
            ->join('departments', 'staff.DeptID', '=', 'departments.DepartmentID')
            ->select('staff.*', 'user_roles.RoleName', 'departments.DepartmentName')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    // 2. Show Create User Form
    public function create()
    {
        $roles = DB::table('user_roles')->get();
        $departments = DB::table('departments')->get();
        return view('admin.users.create', compact('roles', 'departments'));
    }

    // 3. Save New User
    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required',
            'Username' => 'required|unique:staff,Username',
            'Password' => 'required|min:4',
            'RoleID' => 'required',
            'DeptID' => 'required'
        ]);

        DB::table('staff')->insert([
            'Name' => $request->Name,
            'Username' => $request->Username,
            'password' => Hash::make($request->Password), // Encrypt password
            'RoleID' => $request->RoleID,
            'DeptID' => $request->DeptID,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.users')->with('success', 'New user created successfully!');
    }

    // 4. Delete User
    public function destroy($id)
    {
        // Prevent deleting yourself
        if ($id == session('LoggedUser')) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        DB::table('staff')->where('StaffID', $id)->delete();
        return back()->with('success', 'User deleted.');
    }


    public function settings()
    {
        // Get the settings, OR create them automatically if missing
        $settings = SystemSetting::firstOrCreate(
            ['id' => 1], // Look for ID 1
            [            // If not found, create with these defaults:
                'system_name' => 'Visitor Log System',
                'maintenance_mode' => false
            ]
        );

        return view('admin.settings', compact('settings'));
    }
    // 6. Update Settings (REAL)
    public function updateSettings(Request $request)
    {
        $request->validate([
            'system_name' => 'required|string|max:50',
        ]);

        // Get the settings row
        $settings = SystemSetting::first();

        // Update values
        $settings->system_name = $request->system_name;
        
        // Checkboxes: if checked, it sends "on". If unchecked, it sends nothing.
        // We convert that to true (1) or false (0).
        $settings->maintenance_mode = $request->has('maintenance_mode') ? true : false;

        $settings->save();

        return back()->with('success', 'System settings updated successfully!');
    }
}