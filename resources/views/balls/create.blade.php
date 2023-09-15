@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create a New Ball</h2>
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
        <form method="post" action="{{ route('balls.store') }}">
            @csrf
            <div class="form-group">
                <label for="color">Ball Color</label>
                <input type="text" class="form-control" id="color" name="color">
            </div>
            <div class="form-group">
                <label for="size">Ball Size (cubic inches)</label>
                <input type="number" class="form-control" id="size" name="size">
            </div>
            <button type="submit" class="btn btn-primary">Create Ball</button>
        </form>
    </div>
@endsection
