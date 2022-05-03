@foreach($errors->all() as $error)
    <div class="x" role="alert">
        {{$error}}
    </div>
@endforeach
