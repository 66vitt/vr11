<fieldset class="mb-1">
    <dl class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
        <div class="container">
            <div class="row">
                <h3 class="mb-3">Изображения</h3>
            </div>
            <div class="row gallery" id="gallery" data-toggle="modal" data-target="#exampleModal">
                @if(is_countable($attachments))
                @foreach($attachments as $key => $item)
                    <div class="col-12 col-sm-6 col-lg-3 gallery-item">
                        <a href="{{ $item->url }}" data-lightbox="roadtrip">
                            <img src="{{ $item->url }}" class="w-100" alt="Image {{ $key }}">
                        </a>
                    </div>
                @endforeach
                @else

                    <div class="col-12 col-sm-6 col-lg-3 gallery-item">
                        <a href="{{ $attachments->url }}" data-lightbox="roadtrip">
                            <img src="{{ $attachments->url }}" class="w-100" alt=" ">
                        </a>
                    </div>
                @endif


            </div>
        </div>
    </dl>
</fieldset>

<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'alwaysShowNavOnTouchDevices': true
    })
</script>
