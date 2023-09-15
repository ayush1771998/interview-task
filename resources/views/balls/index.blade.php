<!-- resources/views/balls/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Available Balls</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('buckets.suggest') }}">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Color</th>
                        <th>Size (cubic inches)</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($balls as $ball)
                        <tr>
                            <td>{{ $ball->color }}</td>
                            <td>{{ $ball->size }}</td>
                            <td>
                                <input type="number" name="quantities[{{ $ball->id }}]" min="0" value="0">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Get Suggestions</button>
        </form>
    </div>
@endsection
