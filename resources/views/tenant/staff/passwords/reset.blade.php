@extends('tenant.layouts.app')

@section('content')

    @include('tenant._partials.account')

    <form method="POST"
          action='{{ route('tenant.staff.password.request') }}'
          aria-label="@lang('global.reset-password')"
          class="lg:w-1/2 md:w-2/3 form-panel">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <h1 class="text-2xl mb-3 font-bold">{{ isset($url) ? ucwords($url) : ""}} @lang('global.reset-password')</h1>

        <div class="form-row">
            <label class="form-label" for="email">@lang('admin.users.fields.email')</label>

            <input id="email"
                   type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email"
                   value="{{ old('email') }}"
                   required>

            @error('email') @include('tenant._partials.error') @enderror

        </div>

        <div class="form-row">
            <label class="form-label" for="password">@lang('global.password')</label>

            <input id="password"
                   type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password"
                   required>

            @error('password') @include('tenant._partials.error') @enderror

        </div>

        <div class="form-row">
            <label class="form-label" for="password-confirm">@lang('global.confirm-password')</label>

            <input id="password-confirm"
                   type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password_confirmation"
                   required>
        </div>

        <div class="form-row">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn mr-2">
                    @lang('global.reset-password')
                </button>
            </div>
        </div>
    </form>

@endsection
