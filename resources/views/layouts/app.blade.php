<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ball and Bucket Task</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Interview Task</a>
        <a href="{{ route('buckets.index') }}" class="btn btn-primary">View Bucket</a>
        <a href="{{ route('buckets.create') }}" class="btn btn-primary">Add Bucket</a>
        <a href="{{ route('balls.index') }}" class="btn btn-primary">View Balls</a>
        <a href="{{ route('balls.create') }}" class="btn btn-primary">Add Balls</a>
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
