@extends('platform::auth')
@section('title',__('Регистрация'))

@section('content')
    <h1 class="mh4 text-body-emphasis mb-4">Регистрация нового пользователя</h1>
    <form class="m-t-md"
          role="form"
          method="POST"
          data-controller="form"
          data-form-need-prevents-form-abandonment-value="false"
          data-action="form#submit"
          action="{{ route('platform.register.auth') }}">
        @csrf

        <div class="mb-3">

            <label class="form-label">
                {{__('Name')}}
            </label>

            {!!  \Orchid\Screen\Fields\Input::make('name')
                ->type('name')
                ->required()
                ->tabindex(1)
                ->autofocus()
                ->autocomplete('name')
                ->inputmode('name')
                ->placeholder(__('Введите Фамилию, И.О.'))
            !!}
        </div>

        <div class="mb-3">

            <label class="form-label">
                {{__('Email')}}
            </label>

            {!!  \Orchid\Screen\Fields\Input::make('email')
                ->type('email')
                ->required()
                ->tabindex(1)
                ->autofocus()
                ->autocomplete('email')
                ->inputmode('email')
                ->placeholder(__('Enter your email'))
            !!}
        </div>


        <div class="mb-3">
            <label class="form-label w-100">
                {{__('Password')}}
            </label>

            {!!  \Orchid\Screen\Fields\Password::make('password')
                ->required()
                ->autocomplete('current-password')
                ->tabindex(2)
                ->placeholder(__('Enter your password'))
            !!}
        </div>

        <div class="mb-3">
            <label class="form-label w-100">
                {{__('Подтверждение пароля')}}
            </label>

            {!!  \Orchid\Screen\Fields\Password::make('password_confirmation')
                ->required()
                ->tabindex(2)
                ->placeholder(__('Повторите пароль'))
            !!}
        </div>

        <div class="row align-items-center">

            <div class="col-md-6 col-xs-12">
                <button id="button-login" type="submit" class="btn btn-default btn-block" tabindex="3">
                    <x-orchid-icon path="bs.box-arrow-in-right" class="small me-2"/>
                    {{__('Регистрация')}}
                </button>
            </div>
        </div>
    </form>


@endsection
