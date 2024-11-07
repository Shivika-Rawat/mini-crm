<!-- resources/views/employees/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Employee</h1>

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">Company</label>
            <select name="company_id" class="form-control">
                <option value="">Select Company</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Employee</button>
    </form>
</div>
@endsection
