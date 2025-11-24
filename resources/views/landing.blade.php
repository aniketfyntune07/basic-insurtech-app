@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <h2>Welcome to the Insurtech Demo App</h2>

    <p>This app will help manage:</p>
    <ul>
        <li>Customers</li>
        <li>Policies</li>
        <li>Claims</li>
    </ul>

    <p>We are currently building Feature 1: <strong>Landing Page</strong>.</p>
@endsection

@section('scripts')
    <script>
        // just a simple JS example
        console.log('Landing page loaded.');
    </script>
@endsection
