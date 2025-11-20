<div class="modal fade" id="{{ $attributes->get('id') }}" tabindex="-1" aria-labelledby="{{ $attributes->get('id') }}"
     aria-hidden="true">
    <div {{ $attributes->merge(['class' => 'modal-dialog modal-dialog-centered']) }}>
        <div class="modal-content">
            @if(isset($header))
                <div class="modal-header">
                    {{ $header }}
                </div>
            @elseif(isset($title))
                <div class="modal-header">
                    <h5 class="fw-bold">{{$title ?? 'Message'}}</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>
            @endif

            @if($attributes->get('form'))
                <form id="{{ $attributes->get('form-id') }}" novalidate="novalidate">
            @endif

            <div class="modal-body">
                {{$slot}}
            </div>

            @if(isset($footer))
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endif

            @if($attributes->get('form'))
                </form>
            @endif
        </div>
    </div>
</div>

@if(isset($other))
    {{ $other }}
@endif
