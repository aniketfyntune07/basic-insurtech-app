@extends('layouts.app')

@section('title', 'Create Policy')

@section('content')
    <h2>Create Policy</h2>

    {{-- Validation errors --}}
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

    <form action="{{ route('policies.store') }}" method="POST">
        @csrf

        <div>
            <label>Policy Number:</label><br>
            <input type="text" name="policy_number" value="{{ old('policy_number') }}">
        </div>

        <div>
            <label>Customer Name:</label><br>
            <input type="text" name="customer_name" value="{{ old('customer_name') }}">
        </div>

        <div>
            <label>Policy Type:</label><br>
            <select name="type">
                <option value="">-- Select Type --</option>
                <option value="Health" {{ old('type') == 'Health' ? 'selected' : '' }}>Health</option>
                <option value="Motor" {{ old('type') == 'Motor' ? 'selected' : '' }}>Motor</option>
                <option value="Life" {{ old('type') == 'Life' ? 'selected' : '' }}>Life</option>
            </select>
        </div>

        <div>
            <label>Premium Amount:</label><br>
            <input type="number" step="0.01" name="premium_amount" value="{{ old('premium_amount') }}">
        </div>

        <div>
            <label>Start Date:</label><br>
            <input type="date" name="start_date" value="{{ old('start_date') }}">
        </div>

        <div>
            <label>End Date (optional):</label><br>
            <input type="date" name="end_date" value="{{ old('end_date') }}">
        </div>

        <div>
            <label>Status:</label><br>
            <select name="status">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <br>

        <button type="submit">Save Policy</button>
        <a href="{{ route('policies.index') }}">Cancel</a>
    </form>
@endsection
