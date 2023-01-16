@section('css')
    @include('layouts.costumcss')
@endsection

@foreach($array as $key => $value)
    <div class="form-group col-sm-{{ $value["width"] }}">
        <div class="form-group col-sm-12">
            <div class="row">
                <div class="mylabel col-sm-2">
                    {{ $value["label"] }}
                </div>
                <div class="mylabel col-sm-10">
                    @if ($value["file"])
                        <label class="image__file-upload">Válasszon
                            {{ $value["field"] }}
                        </label>
                    @else
                        {{ $value["field"] }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

@section('scripts')
    @include($scriptFile)
@endsection

