@extends('layouts.auth')

@section('login')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1">
                    <img src="{{ $setting->path_logo ? url($setting->path_logo) : asset('admin/images/logo.png') }}" alt="Logo" width="100"><br>
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        @error('email')
                            <label class="col-form-label text-danger" for="inputError" style="font-size: 14px;">
                                <i class="far fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="inputError" placeholder="Email" value="{{ old('email') }}" required autofocus />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember_me" id="remember" />
                                <label for="remember"> Remember Me </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                {{-- <p class="mb-0 mt-3">
                    <a href="{{ url('/register') }}" class="text-center">Register a new membership</a>
                </p> --}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
@endsection
