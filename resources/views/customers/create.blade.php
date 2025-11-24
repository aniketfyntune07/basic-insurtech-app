@extends('layouts.app')

@section('title', 'Create Customer')

@section('content')
    <h2>Create Customer</h2>

    @if ($errors->any())
        <div style="padding: 10px; background: #fee2e2; border: 1px solid #ef4444; margin-bottom: 15px;">
            <strong>There were some problems with your input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <div>
            <label>Name:</label><br>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            <label>Phone:</label><br>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>

        <div>
            <label>Date of Birth:</label><br>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
        </div>

        <div>
            <label>Address:</label><br>
            <input type="text" name="address" value="{{ old('address') }}">
        </div>

        <br>

        <button type="submit">Save Customer</button>
        <a href="{{ route('customers.index') }}">Cancel</a>
    </form>
@endsection
