<div class="d-flex flex-column grid grid-cols-2 d-md-grid form-group {{ $align }}"
    @style([
        '--bs-columns: '.count($group),
        'grid-template-columns: '. $widthColumns => $widthColumns !== null,
    ])>
    @foreach($group as $field)
        <div class="{{ $class }}
                    {{ $loop->first && $itemToEnd ? 'ms-auto': '' }}
            ">
            {!! $field !!}
        </div>
    @endforeach
</div>
