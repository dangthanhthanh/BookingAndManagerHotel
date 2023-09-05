<a href="{{ 
        request()->fullUrlWithQuery(['sortBy'=>$sortBy,'sortType' => (request()->sortBy===$sortBy && request()->sortType==='desc') ? 'asc':'desc']) 
    }}">
    <i class="bx bxs-sort-alt"></i>
</a>