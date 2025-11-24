@extends('layouts.app')

@section('title', 'Policies')

@section('content')
    <h2>Policies</h2>

    <p>
        <a href="{{ route('policies.create') }}">+ Create New Policy</a>
    </p>

    @if($policies->isEmpty())
        <p>No policies found.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Policy #</th>
                    <th>Customer</th>
                    <th>Type</th>
                    <th>Premium</th>
                    <th>Status</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($policies as $policy)
                    <tr>
                        <td>{{ $policy->id }}</td>
                        <td>{{ $policy->policy_number }}</td>
                        <td>{{ $policy->customer_name }}</td>
                        <td>{{ $policy->type }}</td>
                        <td>{{ $policy->premium_amount }}</td>
                        <td>{{ $policy->status }}</td>
                        <td>{{ $policy->start_date }}</td>
                        <td>{{ $policy->end_date ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('policies.edit', $policy) }}">Edit</a>

                            <form action="{{ route('policies.destroy', $policy) }}"
                                  method="POST"
                                  style="display:inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this policy?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
