@extends('layout.portal.common')
@section('title', __('common.operator-board'))
@section('body')
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 col-lg-1 p-0 mb-4" id="operator-board-left">
                <a href="{{ route('portal.operator-board.index',[ $meeting_hall->id, (int)\Route::current()->parameter('program_order') - 1]) }}" >
                <button type="button" class="btn btn-dark w-100 h-100 text-center text-white"><i class="fa-solid fa-chevron-left display-1"></i></button>
                </a>
            </div>
            <div class="col-12 col-lg-10 mb-4 card text-bg-dark" id="operator-board-main">
                <div class="card-header">
                    <h2 class="m-0 text-center h3">{{__('common.operator-board')}}<small> {{ $meeting_hall->title }}</small></h2>
                </div>
                <div class="card-body p-0">
                    <div class="row row-cols-1">
                        <div class="col card text-bg-dark p-0">
                            <div class="card-header">
                                <h2 class="m-0 text-center h3">{{ $program->title }}</h2>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    @isset($program)
                                    <li class="list-group-item bg-dark text-center"><img src="" alt="" class="img-thumbnail img-fluid" /></li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-hotel mx-1"></span> {{ __('common.meeting-hall') }}:</b> {{ $meeting_hall->title }}</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}:</b> {{ $program->start_at }}</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}:</b> {{ $program->finish_at }}</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}:</b> {{ __('common.'.$program->type) }}</li>
                                    <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                        @if($program->status)
                                            {{ __('common.active') }}
                                        @else
                                            {{ __('common.passive') }}
                                        @endif
                                    </li>
                                    @endisset
                                </ul>
                            </div>
                        </div>
                    </div>
                    @isset($sessions)
                        <div class="row row-cols-1">
                            <div class="col card text-bg-dark p-0">

                                <div class="card-header">
                                    <h1 class="m-0 text-center">{{ __('common.sessions') }}</h1>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped table-hover">
                                            <caption class="text-end me-3">
                                                Total Session
                                            </caption>
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col"><span class="fa-regular fa-circle-play mx-1"></span> {{ __('common.is-started') }}</th>
                                                <th scope="col"><span class="fa-regular fa-person-chalkboard mx-1"></span> {{ __('common.speaker') }}</th>
                                                <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                                                <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}</th>
                                                <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}</th>
                                                <th scope="col"><span class="fa-regular fa-block-question mx-1"></span> {{ __('common.questions') }}</th>
                                                <th scope="col"><span class="fa-regular fa-circle-play mx-1"></span> {{ __('common.is-questions-started') }}</th>
                                                <th scope="col"><span class="fa-regular fa-circle-1 mx-1"></span> {{ __('common.question-limit') }}</th>
                                                <th scope="col" class="text-end"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($sessions as $session)
                                                <tr>
                                                    <td>
                                                        @if($session->is_started)
                                                            <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                        @else
                                                            <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                        @endif
                                                    </td>
                                                    <td>{{ $session->speaker->full_name }}</td>
                                                    <td>{{ $session->title }}</td>
                                                    <td>{{ $session->start_at }}</td>
                                                    <td>{{ $session->finish_at }}</td>
                                                    <td>
                                                        @if($session->questions)
                                                            <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                        @else
                                                            <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($session->is_questions_started)
                                                            <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                        @else
                                                            <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                        @endif
                                                    </td>
                                                    <td>{{ $session->question_limit }}</td><td class="text-end">
                                                        <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                            <a class="btn btn-success btn-sm" href="{{ route('portal.session.start-stop', ['program_id' => $program->id, 'session' => $session->id]) }}" title="{{ __('common.start-stop') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.start-stop') }}">
                                                                <span class="fa-regular fa-play-pause"></span>
                                                            </a>
                                                            <a class="btn btn-info btn-sm" href="{{ route('portal.session.start-stop-questions', ['program_id' => $program->id, 'session' => $session->id]) }}" title="{{ __('common.start-stop-questions') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.start-stop-questions') }}">
                                                                <span class="fa-regular fa-block-question"></span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset
                    @isset($debates)
                        <div class="row row-cols-1">
                            <div class="col card text-bg-dark p-0">
                                <div class="card-header">
                                    <h1 class="m-0 text-center">{{ __('common.debates') }}</h1>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped table-hover">
                                            <caption class="text-end me-3">
                                                Total Session
                                            </caption>
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                                                <th scope="col"><span class="fa-regular fa-comment-dots mx-1"></span> {{ __('common.description') }}</th>
                                                <th scope="col"><span class="fa-regular fa-box-ballot mx-1"></span> {{ __('common.on-vote') }}</th>
                                                <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.voting-started-at') }}</th>
                                                <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.voting-finished-at') }}</th>
                                                <th scope="col" class="text-end"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($debates as $debate)
                                                <tr>
                                                    <td>{{ $debate->title }}</td>
                                                    <td>{{ $debate->description }}</td>
                                                    <td>
                                                        @if($debate->on_vote)
                                                            <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                        @else
                                                            <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                        @endif
                                                    </td>
                                                    <td>{{ $debate->voting_started_at }}</td>
                                                    <td>{{ $debate->voting_finished_at }}</td>
                                                    <td class="text-end">
                                                        <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                            <a class="btn btn-success btn-sm" href="{{ route('portal.debate.start-stop-voting', ['program_id' => $program->id, 'debate' => $debate->id]) }}" title="{{ __('common.start-stop-voting') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.start-stop-voting') }}">
                                                                <span class="fa-regular fa-box-ballot"></span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
                <div class="card-footer">
                    <h2 class="m-0 text-center h3"><div id="time"></div></h2>
                </div>
            </div>

            <div class="col-12 col-lg-1 p-0 mb-4" id="operator-board-right">
                <a href="{{ route('portal.operator-board.index',[ $meeting_hall->id, (int)\Route::current()->parameter('program_order') + 1]) }}" >
                <button title="{{ __('common.operator-board') }}" type="button" class="btn btn-dark w-100 h-100 text-center text-white"><i class="fa-solid fa-chevron-right display-1"></i></button>
                </a>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        function showTime() {
            var date = new Date()
            document.getElementById('time').innerHTML = 'Time: ' + date.toLocaleTimeString('en-US');
        }
        setInterval(showTime, 1000);
    </script>
@endsection
