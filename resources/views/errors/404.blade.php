@extends('admin.admin_master')
@section('admin')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Custom Error Page Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<div class="page-content">
    <div class="container-fluid">
        <div class="container mt-5 pt-5">
            <div class="alert alert-danger text-center">
                <h2 class="display-3">404</h2>
                <p class="display-5">Oops Something went wrong..</p>
                <a href="{{route('dashboard')}}" class="btn btn-info">Go Home</a>
            </div>
        </div>
    </div>
</div>


@endsection