
@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
@endif