<div class="row">
    <div class="col-md-12 text-center">
        <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $datas->appends(request()->query())->previousPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $datas->appends(request()->query())->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ !$datas->previousPageUrl() ? 'true' : 'false' }}">Previous</a>
            </li>
            @foreach ($datas->appends(request()->query())->links()->elements[0] as $page => $url)
                <li class="page-item {{ $datas->currentPage() === $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
            <li class="page-item {{ $datas->appends(request()->query())->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $datas->appends(request()->query())->nextPageUrl() }}">Next</a>
            </li>
        </ul>
        </nav>
    </div>
</div>