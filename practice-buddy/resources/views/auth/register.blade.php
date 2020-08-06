<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card register-card border-0 shadow">
                <div class="card-header"><h3 class="text-center align-middle m-1">{{ __('Register') }}</h3></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="register-email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="register-email" type="email" class="form-control{{ $errors->has('register-email') ? ' is-invalid' : '' }}" name="register-email" value="{{ old('register-email') }}" required>

                                @if ($errors->has('register-email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('register-email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="register-password" class="col-md-4 col-form-label text-md-right">{{ __('password') }}</label>

                            <div class="col-md-6">
                                <input id="register-password" type="password" class="form-control{{ $errors->has('register-password') ? ' is-invalid' : '' }}" name="register-password" required>

                                @if ($errors->has('register-password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('register-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="register-password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm password') }}</label>

                            <div class="col-md-6">
                                <input id="register-password-confirm" type="password" class="form-control" name="register-password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <span>{{ __('Register') }}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
