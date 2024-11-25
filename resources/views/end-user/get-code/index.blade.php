@extends('layout.end-user.common')
@section('title', __('common.get-login-code'))
@section('body')
    <div class="card bg-dark">
        <div class="card-header bg-dark text-white border-dark">
            <h1 class="m-0 text-center"><i class="fa-duotone fa-key"></i> {{ __('common.get-the-access-code-for-kongrepad') }}</h1>
        </div>
        <div class="card-body mt-2">
            <div class="row h-100">
                <div class="col-md-6 d-md-block mt-4">
                    <h2 class="h2 mb-3 fw-normal text-white text-center"><i class="fa-duotone fa-envelope"></i> {{ __('common.send-by-email') }}</h2>
                    <form method="POST" action="{{ route("end-user.get-code.store") }}" name="send-by-email-form" id="send-by-email-form" autocomplete="off">
                        @csrf
                        <input type="hidden" name="type" id="type" value="email" autocomplete="false" />
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control @error('email')is-invalid @enderror" id="email" placeholder="info@kongrepad.com" autocomplete="false" />
                            <label for="email">{{ __('common.email') }}</label>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-lg btn-info w-100 py-2 shadow mt-2"><i class="fa-solid fa-envelope"></i> {{ __('common.send-by-email') }}</button>
                    </form>
                    <hr />
                </div>
                <div class="col-md-6 d-md-block mt-4">
                    <h2 class="h2 mb-3 fw-normal text-white text-center"><i class="fa-duotone fa-message-sms"></i> {{ __('common.send-via-sms') }}</h2>
                    <form method="POST" action="{{ route("end-user.get-code.store") }}" name="send-via-sms-form" id="send-via-sms-form" autocomplete="off">
                        @csrf
                        <input type="hidden" name="type" id="type" value="sms" autocomplete="false" />
                        <div class="form-floating">
                            <input type="number" name="phone" class="form-control @error('phone')is-invalid @enderror" id="phone" placeholder="3129119113" min="0" max="9999999999" autocomplete="false" />
                            <label for="phone">{{ __('common.phone') }}</label>
                            @error('phone')
                                <div class="invalid-feedback d-block">
                                    <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-lg btn-info w-100 py-2 shadow mt-2"><i class="fa-solid fa-message-sms"></i> {{ __('common.send-via-sms') }}</button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
@endsection
