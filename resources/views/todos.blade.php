@php use Illuminate\Support\Facades\Auth; @endphp
@extends('app')
    <!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Todo App</title>

</head>
<body>

<nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand mr-auto" href="#">Todo App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Register</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('logout')}}">Logout</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="row justify-content-center mt-5">
    <div class="col-lg-6">
        @if (session('invalid'))
            <div class="alert alert-success">
                {{ session('invalid') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>

<div class="text-center mt-5">
    <h2>Hello <strong>{{auth()->user()->name}}</strong>, these are your todos</h2>
    <h2>Add Todo</h2>

    <form class="row g-3 justify-content-center" method="post" action="{{route('todos.store')}}">
        @csrf
        <div class="col-6">
            <input type="text" class="form-control" name="title" placeholder="Title">
            @error('title')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>
    </form>
</div>

<div class="text-center my-4">
    <form action="{{ route('todos.index') }}" method="GET">
        <input type="text" name="search" placeholder="Search Todos">
        <button type="submit">Search</button>
    </form>
</div>

<div class="text-center">
    <h2>All Todos</h2>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @php $counter = 1; @endphp
                @foreach($todos as $todo)
                    @if(auth()->user()->id === $todo->user_id)
                        <tr>
                            <td>{{$counter}}</td>
                            <td>{{$todo->title}}</td>
                            <td>{{$todo->created_at}}</td>
                            <td>
                                @if($todo->is_completed)
                                    <div class="badge bg-success">Completed</div>
                                @else
                                    <div class="badge bg-warning">Not Completed</div>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('todos.edit', ['todo' => $todo->id])}}">
                                    <i class="fas fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{route('todos.destroy', ['todo' => $todo->id])}}">
                                    <i
                                        class="fas fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
                    @php $counter++; @endphp
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@yield('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
