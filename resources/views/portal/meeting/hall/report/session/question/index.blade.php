@extends('layout.portal.common')
@section('title', $session->title . ' | ' .  __('common.question-reports'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-question"></span> <small>{{ $session->title }}</small> {{ __('common.question-reports') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $questions->links() }}
                    </caption>
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.questioner') }}</th>
                        <th scope="col"><span class="fa-regular fa-question mx-1"></span> {{ __('common.question') }}</th>
                        <th scope="col"><span class="fa-regular fa-user-secret mx-1"></span> {{ __('common.is-hidden-name') }}</th>
                        <th scope="col"><span class="fa-regular fa-check mx-1"></span> {{ __('common.is-selected') }}</th>
                        <th scope="col"><span class="fa-regular fa-multiply mx-1"></span> {{ __('common.is-deselected') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->questioner->full_name }}</td>
                            <td>{{ $question->question }}</td>
                            <td>
                                @if($question->is_hidden_name)
                                    <i style="color:green"
                                       class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                            <td>
                                @if($question->selected_for_show)
                                    <i style="color:green"
                                       class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                            <td>
                                @if($question->is_deselected)
                                    <i style="color:green"
                                       class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
