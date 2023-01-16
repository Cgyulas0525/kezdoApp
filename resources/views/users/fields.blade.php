@section('css')
    @include('layouts.costumcss')
@endsection

<!-- Name Field -->
<div class="form-group col-sm-6">
    <img src={{ URL::asset($users->image_url) }} style="width: 250px; height: 250px;"></img>
</div>

<div class="form-group col-sm-6">
    <div class="mylabel col-sm-2">
        {!! Form::label('image_url', 'Kép:') !!}
    </div>
    <div class="mylabel col-sm-10">
        <label class="image__file-upload">Válasszon
            {!! Form::file('image_url',['class'=>'d-none', 'id' => 'image_url', 'accept' => ".png, .jpg, .svg"]) !!}
        </label>
    </div>
</div>
<!-- Userstatus Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('userstatus_id', 'Típus:') !!}
    {!! Form::select('userstatus_id', App\Http\Controllers\UsersController::userStatusDDW(), null,
                                                        ['class'=>'select2 form-control', 'id' => 'userstatus_id']) !!}
</div>

<!-- Commit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('commit', 'Megjegyzés:') !!}
    {!! Form::textarea('commit', null, ['class' => 'form-control','maxlength' => 500, 'rows' => 4, 'id' => 'commit']) !!}
</div>

<!-- Image Url Field -->
