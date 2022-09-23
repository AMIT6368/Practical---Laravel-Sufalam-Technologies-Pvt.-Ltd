@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
             <i class="fa fa-check"></i>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif