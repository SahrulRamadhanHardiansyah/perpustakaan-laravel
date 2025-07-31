@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="auth-box">
                <div class="auth-title">
                    {{ __('Verify Your Email Address') }}
                </div>

                <p class="auth-desc">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                </p>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <div class="auth-link text-center">
                    <span>{{ __('If you did not receive the email') }},</span>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection