<!-- resources/views/employees/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Employee</h1>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ $employee->first_name }}" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ $employee->last_name }}" required>
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">Company</label>
            <select name="company_id" class="form-control">
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ $employee->company_id == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $employee->email }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}">
        </div>

        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Employee</button>
    </form>
</div>
@endsection
