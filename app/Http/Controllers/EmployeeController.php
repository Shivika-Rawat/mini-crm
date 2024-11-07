<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all employees with pagination
        $employees = Employee::with('company')->paginate(10); // Adjust pagination as needed
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retrieve all companies for the select dropdown
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image'
        ]);

        // Handle file upload if a profile picture is provided
        if ($request->hasFile('profile_picture')) {
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'private');
        }

        // Create a new employee with validated data
        Employee::create($validatedData);

        return redirect()->route('employees.index')
                         ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        // Display a single employee
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        // Retrieve all companies for the select dropdown
        $companies = Company::all();
        return view('employees.edit', compact('employee', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image'
        ]);

        // Handle file upload for the profile picture if provided
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($employee->profile_picture) {
                Storage::disk('private')->delete($employee->profile_picture);
            }
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'private');
        }

        // Update the employee with validated data
        $employee->update($validatedData);

        return redirect()->route('employees.index')
                         ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        // Delete the profile picture if it exists
        if ($employee->profile_picture) {
            Storage::disk('private')->delete($employee->profile_picture);
        }

        // Delete the employee from the database
        $employee->delete();

        return redirect()->route('employees.index')
                         ->with('success', 'Employee deleted successfully.');
    }
}
