<!-- resources/views/employees/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employee Details</h1>
    <p><strong>First Name:</strong> {{ $employee->first_name }}</p>
    <p><strong>Last Name:</strong> {{ $employee->last_name }}</p>
    <p><strong>Company:</strong> {{ $employee->company->name ?? 'N/A' }}</p>
    <p><strong>Email:</strong> {{ $employee->email }}</p>
    <p><strong>Phone:</strong> {{ $employee->phone }}</p>

    @if($employee->profile_picture)
        <p><strong>Profile Picture:</strong></p>
        <img src="{{ Storage::disk('private')->url($employee->profile_picture) }}" alt="Profile Picture" width="100">
    @endif

    <a href="{{ route('employees.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
