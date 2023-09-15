@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create a New Bucket</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('buckets.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Bucket Name</label>
                <input type="text" class="form-control" id="name" name="name" >
            </div>
            <div class="form-group">
                <label for="capacity">Bucket Capacity (cubic inches)</label>
                <input type="number" class="form-control" id="capacity" name="capacity" >
            </div>
            <button type="submit" class="btn btn-primary">Create Bucket</button>
        </form>
    </div>
@endsection