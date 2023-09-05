<ul class="row">
    <div class="search-bar">
        <form class="search-form d-flex justify-content-center align-items-center" method="get">
            <div class="col-1">
                <a class="form-control btn btn-outline-info" title="Refresh Search" href="{{ route(request()->route()->getName()) }}"><i class="fa-solid fa-arrows-rotate"></i></a>
            </div>
            <div class="col-5 mx-2">
                <div class="form-floating">
                <input type="text" class="form-control" id="floatingName" placeholder="Search" title="Enter search keyword" name="searchByName">
                <label for="floatingName">Search</label>
                </div>
            </div>
            <div class="col-1">
                <button class="form-control btn btn-outline-primary" type="submit" title="Search"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
</ul>