@extends('layout.portal.common')
@section('title', $user->FullName)
@section('body')
    <div class="card bg-dark text-white">
        <div class="card-header text-center">
            <h1>{{ $user->FullName }}</h1>
            <h5>{{ $user->role->title }}</h5>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <table class="table table-dark table-hover table-bordered w-25">
                        <thead>
                        <tr>
                            <td colspan="2">{{ __('common.profile') }}</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-user"></i> {{ __('common.username') }}</th>
                            <td colspan="2" class="table-active">{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-right-to-bracket"></i> {{ __('common.last-login') }}</th>
                            <td colspan="2" class="table-active">{{ $user->last_login }}</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-phone"></i> {{ __('common.phone-number') }}</th>
                            <td colspan="2" class="table-active">{{ $user->FullPhoneNumber }}
                                @isset( $user->phone_verified_at )
                                    <i style="color:green" class="fa fa-check-square"></i>
                                @endisset</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-envelope"></i> {{ __('common.email') }}</th>
                            <td colspan="2" class="table-active">{{ $user->email }}
                                @isset( $user->email_verified_at )
                                    <i style="color:green" class="fa fa-check-square"></i>
                                @endisset</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-dashboard"></i> {{ __('common.activity') }}</th>
                            <td colspan="2" class="table-active"></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class=" mx-5 table table-dark table-hover table-bordered w-25">
                        <thead>
                        <tr>
                            <td colspan="2">{{ __('common.profile') }}</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-user"></i> {{ __('common.username') }}</th>
                            <td colspan="2" class="table-active">{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-right-to-bracket"></i> {{ __('common.last-login') }}
                            </th>
                            <td colspan="2" class="table-active">{{ $user->last_login }}</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-phone"></i> {{ __('common.phone-number') }}</th>
                            <td colspan="2" class="table-active">{{ $user->FullPhoneNumber }}
                                @isset( $user->phone_verified_at )
                                    <i style="color:green" class="fa fa-check-square"></i>
                                @endisset</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-envelope"></i> {{ __('common.email') }}</th>
                            <td colspan="2" class="table-active">{{ $user->email }}
                                @isset( $user->email_verified_at )
                                    <i style="color:green" class="fa fa-check-square"></i>
                                @endisset</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-dashboard"></i> {{ __('common.activity') }}</th>
                            <td colspan="2" class="table-active"></td>
                        </tr>
                        </tbody>
                    </table>

                    <table class="table table-dark table-hover table-bordered w-25">
                        <thead>
                        <tr>
                            <td colspan="2">{{ __('common.profile') }}</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-user"></i> {{ __('common.username') }}</th>
                            <td colspan="2" class="table-active">{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-right-to-bracket"></i> {{ __('common.last-login') }}
                            </th>
                            <td colspan="2" class="table-active">{{ $user->last_login }}</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-phone"></i> {{ __('common.phone-number') }}</th>
                            <td colspan="2" class="table-active">{{ $user->FullPhoneNumber }}
                                @isset( $user->phone_verified_at )
                                    <i style="color:green" class="fa fa-check-square"></i>
                                @endisset</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-envelope"></i> {{ __('common.email') }}</th>
                            <td colspan="2" class="table-active">{{ $user->email }}
                                @isset( $user->email_verified_at )
                                    <i style="color:green" class="fa fa-check-square"></i>
                                @endisset</td>
                        </tr>
                        <tr>
                            <th scope="row"><i class="fa-solid fa-dashboard"></i> {{ __('common.activity') }}</th>
                            <td colspan="2" class="table-active"></td>
                        </tr>
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>


    <!--/col-3-->

@endsection
@section('footer')

@endsection

