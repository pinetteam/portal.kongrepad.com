@extends('layout.portal.common')
@section('title', __('common.dashboard'))
@section('body')
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 col-lg-1 p-0 mb-4" id="operator-dashboard-left">
                <button type="button" class="btn btn-dark w-100 h-100 text-center text-white"><i class="fa-solid fa-chevron-left display-1"></i></button>
            </div>
            <div class="col-12 col-lg-10 mb-4 card text-bg-dark" id="operator-dashboard-main">
                <div class="card-header">
                    <h2 class="m-0 text-center h3">Operator Board <small>(Main Hall)</small></h2>
                </div>
                <div class="card-body p-0">
                    <div class="row row-cols-2">
                        <div class="col card text-bg-dark p-0">
                            <div class="card-header">
                                <h2 class="m-0 text-center h3">{{ __('common.program') }}</h2>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-dark text-center"><img src="" alt="" class="img-thumbnail img-fluid" /></li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-hotel mx-1"></span> {{ __('common.meeting-hall') }}:</b> Başlık</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}:</b> Başlama Tarihi</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}:</b> Bitiş tarihi</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}:</b> Tür</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b> Aktif</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col card text-bg-dark p-0">
                            <div class="card-header">
                                <h2 class="m-0 text-center h3">{{ __('common.session') }}</h2>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-dark text-center"><img src="" alt="" class="img-thumbnail img-fluid" /></li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-hotel mx-1"></span> {{ __('common.meeting-hall') }}:</b> Başlık</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}:</b> Başlama Tarihi</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}:</b> Bitiş tarihi</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}:</b> Tür</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b> Aktif</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <h2 class="m-0 text-center h3">Saat</h2>
                </div>
            </div>
            <div class="col-12 col-lg-1 p-0 mb-4" id="operator-dashboard-right">
                <button type="button" class="btn btn-dark w-100 h-100 text-center text-white"><i class="fa-solid fa-chevron-right display-1"></i></button>
            </div>
        </div>
    </div>
@endsection
