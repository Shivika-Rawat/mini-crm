<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all companies with pagination
        $companies = Company::paginate(10); // Adjust pagination as needed
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Display form for creating a new company
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|dimensions:min_width=100,min_height=100'
        ]);

        // Handle file upload if a logo is provided
        if ($request->hasFile('logo')) {
            $validatedData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Create a new company with validated data
        Company::create($validatedData);

        return redirect()->route('companies.index')
                         ->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        // Display a single company
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        // Display form for editing a company
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|dimensions:min_width=100,min_height=100'
        ]);

        // Handle file upload for the logo if provided
        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validatedData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Update the company with validated data
        $company->update($validatedData);

        return redirect()->route('companies.index')
                         ->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // Delete the logo file if it exists
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        // Delete the company from the database
        $company->delete();

        return redirect()->route('companies.index')
                         ->with('success', 'Company deleted successfully.');
    }
}
