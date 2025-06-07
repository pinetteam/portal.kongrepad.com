@props([
    'title' => null,
    'icon' => null,
    'headerActions' => null
])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if($title || $icon || $headerActions)
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @if($icon)
                        <i class="{{ $icon }} me-2"></i>
                    @endif
                    @if($title)
                        <h5 class="card-title mb-0">{{ $title }}</h5>
                    @endif
                </div>
                @if($headerActions)
                    <div>
                        {{ $headerActions }}
                    </div>
                @endif
            </div>
        </div>
    @endif
    
    <div class="card-body">
        {{ $slot }}
    </div>
    
    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endisset
</div> 