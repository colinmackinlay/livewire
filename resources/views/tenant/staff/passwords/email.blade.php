@extends('tenant.layouts.app')

@section('content')

    @include('tenant._partials.account')

    <form method="POST" action="{{ route('tenant.staff.password.email') }}"
          aria-label="@lang('global.reset-password')"
          class="lg:w-1/2  md:w-2/3 lg:mx-auto bg-card p-5 rounded shadow">
        @csrf

        <h1 class="text-2xl mb-3 font-bold">@lang('global.reset-password')</h1>

        @includeWhen(session('status'),'tenant._partials.success',['message'=>session('status')])

        <div class="form-row">
            <label for="email"
                   class="col-md-4 col-form-label text-md-right">@lang('admin.users.fields.email')
            </label>

            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required>

            @error('email') @include('tenant._partials.error') @enderror
        </div>

        <div class="form-row">
            <button type="submit" class="btn">
                @lang('global.send-password')
            </button>
        </div>

    </form>

@endsection
