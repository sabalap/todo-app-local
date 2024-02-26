@extends('app')
@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('invalid'))
                            <div class="alert alert-danger">
                                {{ session('invalid') }}
                            </div>
                        @endif
                        <h3 class="card-header text-center">Login</h3>
                        <div class="card-body">
                            <form method="post" action="{{route('login.post')}}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" value="{{old('email')}}" placeholder="Email" id="email"
                                           class="form-control" name="email">
                                    @error('email')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password" class="form-control"
                                           name="password">
                                    @error('password')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Signin</button>
                                </div>
                                <div class="d-grid mx-auto">
                                    <label>New User? </label>
                                    <a href="{{route('registration')}}">Register</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
