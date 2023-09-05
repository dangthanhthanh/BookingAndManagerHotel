<form class="search-form d-flex justify-content-center align-items-center" method="get" id="search-form">
    <div class="col-1">
        <a class="form-control btn btn-outline-info" title="Refresh Search" href="{{ route(request()->route()->getName()) }}"><i class="fa-solid fa-arrows-rotate"></i></a>
    </div>
    @foreach ( $selects as $item )
        <div class="col-2 mx-2">
            <div class="form-floating">
                <select name="{{$item['title']}}" class="form-control" id="floatingName">
                    <option></option>
                    @foreach ( $item['data'] as $value )
                    <option value="{{$value['id']}}" @checked(request()->method === $value['id'])>{{$value['name']}}</option>
                    @endforeach
                </select>
                <label for="floatingName">Search By {{$item['title']}}</label>
            </div>
        </div>
    @endforeach
    <div class="col-1">
        <button class="form-control btn btn-outline-primary" type="submit" title="Search By Name"><i class="bi bi-search"></i></button>
    </div>
</form>