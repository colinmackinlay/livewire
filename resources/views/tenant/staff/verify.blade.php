@extends('tenant.layouts.app')

@section('content')

    @include('tenant._partials.account')

    <form method="POST"
          action="{{ route('tenant.staff.password.email') }}"
          aria-label="{{ __('Reset Password') }}"
          class="lg:w-1/2 lg:mx-auto bg-card p-5 rounded shadow">
        @csrf

        <h1 class="text-2xl mb-3 font-bold">{{ __('Verify Your Email Address') }}</h1>

        @includeWhen(session('resent'),'tenant._partials.success',['message'=>__('A fresh verification link has been sent to your email address.')])

        {{ __('Before proceeding, please check your email for a verification link.') }}<br/>
        {{ __('If you did not receive the email') }}, <a
                href="{{ route('tenant.staff.verification.resend') }}">@lang('click here to request another')</a>.

    </form>

@endsection
