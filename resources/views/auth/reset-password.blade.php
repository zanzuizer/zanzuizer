@extends('layouts.guest')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0"><i class="fas fa-lock me-2"></i>{{ __('Đặt lại mật khẩu') }}</h3>
                </div>
                <div class="card-body p-4">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="text-center mb-4">
                        <p class="text-muted">Vui lòng nhập mật khẩu mới của bạn.</p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                            <label for="email">{{ __('Địa chỉ Email') }}</label>
                            @error('email')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="matkhau" type="password" class="form-control @error('matkhau') is-invalid @enderror" name="matkhau" required autocomplete="new-password" placeholder="Mật khẩu">
                            <label for="matkhau">{{ __('Mật khẩu mới') }}</label>
                            @error('matkhau')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input id="matkhau-confirm" type="password" class="form-control" name="matkhau_confirmation" required autocomplete="new-password" placeholder="Xác nhận mật khẩu">
                            <label for="matkhau-confirm">{{ __('Xác nhận mật khẩu') }}</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>{{ __('Đặt lại mật khẩu') }}
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại đăng nhập
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection