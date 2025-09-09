@component($typeForm, get_defined_vars())

        <div class="row mt-3">
            <div class="col-md">
                <label for="latitude">{{ __('Latitude') }}</label>
                <input class="form-control"
                       id="latitude"
                       data-map-target="lat"
                       @if($required ?? false) required @endif
                       name="{{$name}}[lat]"
                       value="{{ $value['lat'] ?? '' }}"/>
            </div>
            <div class="col-md">
                <label for="longitude">{{ __('Longitude') }}</label>
                <input class="form-control"
                       id="longitude"

                       data-map-target="lng"
                       @if($required ?? false) required @endif
                       name="{{$name}}[lng]"
                       value="{{ $value['lng'] ?? '' }}"/>
            </div>
        </div>
    <script>
        navigator.geolocation.getCurrentPosition(success, error, {
            // высокая точность
            enableHighAccuracy: true
        })

        function success({ coords }) {
            // получаем широту и долготу
            const { latitude, longitude } = coords
            const position = [latitude, longitude]

            document.getElementById('latitude').value = position[0]
            document.getElementById('longitude').value = position[1]
        }

        function error({ message }) {
            console.log(message) // при отказе в доступе получаем PositionError: User denied Geolocation
        }
    </script>
@endcomponent
