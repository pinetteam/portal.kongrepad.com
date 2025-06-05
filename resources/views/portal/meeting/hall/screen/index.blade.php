@extends('layout.portal.meeting-detail')
@section('title', $hall->title . ' | ' . __('common.screens'))
@section('head')
    @vite(['resources/css/meeting-pages-theme.css'])
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none text-white">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.show', $hall->meeting->id) }}" class="text-decoration-none text-white">{{ $hall->meeting->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $hall->meeting->id]) }}" class="text-decoration-none text-white">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $hall->meeting->id, 'hall' => $hall->id]) }}" class="text-decoration-none text-white">{{ $hall->title }}</a></li>
    <li class="breadcrumb-item active text-white text-decoration-underline" aria-current="page">{{ __('common.screens') }}</li>
@endsection
@section('meeting_content')
    <!-- Modern Hero Card -->
    <div class="modern-hero-card">
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fa-duotone fa-presentation-screen"></i>
            </div>
            <div class="hero-text">
                <div class="hero-title">{{ __('common.screens') }}</div>
                <div class="hero-subtitle">
                    <i class="fa-regular fa-building me-2"></i>{{ $hall->title }}
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <i class="fa-regular fa-tv me-2"></i>{{ $screens->total() }} {{ __('common.screens') }}
                    </div>
                </div>
            </div>
            <div class="hero-action">
                <button type="button" class="btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#screen-create-modal" data-route="{{ route('portal.meeting.hall.screen.store', ['meeting' => $hall->meeting_id, 'hall' => $hall->id]) }}">
                    <i class="fa-solid fa-plus"></i>{{ __('common.create-new-screen') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Main Screens Card -->
    <div class="modern-main-card">
        <div class="card-header">
            <h3 class="card-header-title">
                <i class="fa-duotone fa-tv me-2"></i>
                {{ __('common.screens') }} {{ __('common.list') }}
            </h3>
        </div>
        <div class="card-body p-0">
            @if($screens->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <i class="fa-regular fa-input-text me-2"></i>{{ __('common.title') }}
                                </th>
                                <th scope="col">
                                    <i class="fa-regular fa-person-military-pointing me-2"></i>{{ __('common.type') }}
                                </th>
                                <th scope="col">
                                    <i class="fa-regular fa-font me-2"></i>{{ __('common.font') }}
                                </th>
                                <th scope="col">
                                    <i class="fa-regular fa-text-size me-2"></i>{{ __('common.font-size') }}
                                </th>
                                <th scope="col">
                                    <i class="fa-regular fa-palette me-2"></i>{{ __('common.font-color') }}
                                </th>
                                <th scope="col">
                                    <i class="fa-regular fa-toggle-large-on me-2"></i>{{ __('common.status') }}
                                </th>
                                <th scope="col" class="text-end">{{ __('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($screens as $screen)
                                <tr>
                                    <td>
                                        <div class="item-info">
                                            <div>
                                                <div class="item-name">{{ $screen->title }}</div>
                                                @if($screen->description)
                                                    <small class="text-muted">{{ Str::limit($screen->description, 40) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="theme-badge">{{ __('common.'.$screen->type) }}</span>
                                    </td>
                                    <td>
                                        <span style="font-family: '{{ $screen->font }}'" class="font-preview">{{ $screen->font }}</span>
                                    </td>
                                    <td>
                                        <span class="id-badge">{{ $screen->font_size }}px</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="color-preview me-2" style="background-color: {{ $screen->font_color }}"></div>
                                            <small class="text-muted">{{ $screen->font_color }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $screen->status ? 'status-active' : 'status-inactive' }}">
                                            <i class="fa-regular fa-{{ $screen->status ? 'toggle-on' : 'toggle-off' }}"></i>
                                            {{ $screen->status ? __('common.active') : __('common.passive') }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-buttons">
                                            <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.' .$screen->type. '.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.screen') }}" data-bs-toggle="tooltip" target="_blank">
                                                <i class="fa-regular fa-tv"></i>
                                            </a>
                                            <a class="btn btn-outline-info btn-sm" href="{{ route('portal.meeting.hall.screen.show', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'screen' => $screen->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#screen-edit-modal" data-route="{{ route('portal.meeting.hall.screen.update', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'screen' => $screen->id]) }}" data-resource="{{ route('portal.meeting.hall.screen.edit', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'screen' => $screen->id]) }}" data-id="{{ $hall->id }}" data-bs-toggle="tooltip">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#screen-delete-modal" data-route="{{ route('portal.meeting.hall.screen.destroy', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'screen' => $screen->id]) }}" data-record="{{ $screen->title }}" data-bs-toggle="tooltip">
                                                <i class="fa-regular fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($screens->hasPages())
                    <div class="card-footer">
                        {{ $screens->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fa-duotone fa-presentation-screen"></i>
                    </div>
                    <div class="empty-state-title">{{ __('common.no-screens-found') }}</div>
                    <div class="empty-state-text">{{ __('common.create-your-first-screen') }}</div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#screen-create-modal" data-route="{{ route('portal.meeting.hall.screen.store', ['meeting' => $hall->meeting_id, 'hall' => $hall->id]) }}">
                        <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-screen') }}
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Create Screen Modal -->
    <x-crud.form.common.create name="screen" >
        @section('screen-create-form')
            <x-input.hidden method="c" name="hall_id" :value="$hall->id" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.text method="c" name="description" title="description" icon="comment-dots" />
            <x-input.file method="c" name="background" title="background" icon="image" />
            <x-input.select method="c" name="font" title="font" :options="$fonts" option_value="value" option_name="title" icon="font" />
            <x-input.text method="c" name="font_size" title="font-size" icon="text-size" />
            <x-input.select method="c" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing" />
            <x-input.color method="c" name="font_color" title="font-color" icon="palette" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>

    <!-- Edit Screen Modal -->
    <x-crud.form.common.edit name="screen" >
        @section('screen-edit-form')
            <x-input.hidden method="e" name="hall_id" :value="$hall->id" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.text method="e" name="description" title="description" icon="comment-dots" />
            <x-input.file method="e" name="background" title="background" icon="image" />
            <x-input.select method="e" name="font" title="font" :options="$fonts" option_value="value" option_name="title" icon="font" />
            <x-input.text method="e" name="font_size" title="font-size" icon="text-size" />
            <x-input.select method="e" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing" />
            <x-input.color method="e" name="font_color" title="font-color" icon="palette" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>

    <!-- Delete Screen Modal -->
    <x-crud.form.common.delete name="screen" />
@endsection
