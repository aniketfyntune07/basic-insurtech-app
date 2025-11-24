@extends('layouts.app')

@section('title', 'Edit Policy')

@section('content')
    <h2>Edit Policy #{{ $policy->policy_number }}</h2>

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

    <form action="{{ route('policies.update', $policy) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Policy Number:</label><br>
            <input type="text" name="policy_number" value="{{ old('policy_number', $policy->policy_number) }}">
        </div>

        <div>
            <label>Customer Name:</label><br>
            <input type="text" name="customer_name" value="{{ old('customer_name', $policy->customer_name) }}">
        </div>

        <div>
            <label>Policy Type:</label><br>
            <select name="type">
                @php
                    $type = old('type', $policy->type);
                @endphp
                <option value="">-- Select Type --</option>
                <option value="Health" {{ $type == 'Health' ? 'selected' : '' }}>Health</option>
                <option value="Motor" {{ $type == 'Motor' ? 'selected' : '' }}>Motor</option>
                <option value="Life" {{ $type == 'Life' ? 'selected' : '' }}>Life</option>
            </select>
        </div>

        <div>
            <label>Premium Amount:</label><br>
            <input type="number" step="0.01" name="premium_amount"
                   value="{{ old('premium_amount', $policy->premium_amount) }}">
        </div>

        <div>
            <label>Start Date:</label><br>
            <input type="date" name="start_date"
                   value="{{ old('start_date', $policy->start_date) }}">
        </div>

        <div>
            <label>End Date (optional):</label><br>
            <input type="date" name="end_date"
                   value="{{ old('end_date', $policy->end_date) }}">
        </div>

        <div>
            <label>Status:</label><br>
            @php
                $status = old('status', $policy->status);
            @endphp
            <select name="status">
                <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ $status == 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <br>

        <button type="submit">Update Policy</button>
        <a href="{{ route('policies.index') }}">Cancel</a>
    </form>
@endsection
