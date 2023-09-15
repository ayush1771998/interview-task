@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Bucket Suggestions</h2>
        @if (count($suggestions) > 0)
            <h3>Suggested Buckets:</h3>
            <ul>
                @foreach ($suggestions as $suggestion)
                    <li>
                        {{ $suggestion['bucket_name'] }} -
                        @if ($suggestion['remaining_space'] === 0)
                            Full
                        @else
                            Extra Space: {{ $suggestion['remaining_space'] }} cubic inches
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>No available buckets can accommodate the selected quantities for balls.</p>
        @endif
    </div>
@endsection
