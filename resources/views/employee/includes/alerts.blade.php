@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger w-50" role="alert">
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </div>
@endif