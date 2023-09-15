<!-- buckets.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>List of Buckets</h2>
        <ul>
            @foreach ($buckets as $bucket)
                <li>{{ $bucket->name }} - Capacity: {{ $bucket->capacity }} cubic inches (Filled :- {{$bucket->filled_value}})</li>
            @endforeach
        </ul>
        
    </div>
@endsection
