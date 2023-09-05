<form method="post" action="{{ route($table.'.delete', $item->slug) }}">
    @csrf
    <a class="btn btn-primary" href="{{ route($table.'.show', $item->slug) }}">Detail</a>
    @if ($item->deleted_at)
        <a class="btn btn-secondary" href="{{ route($table.'.restore', $item->slug) }}">Restore</a>
    @method('DELETE')
    @else
        <button onclick="return confirm('Are you sure ?')" type="submit" class="btn btn-danger">Delete</button>
    @endif
</form>
<form action="{{ route($table.'.forceDelete',$item->slug) }}" method="post">
    @csrf
    <button type="submit" class="btn btn-danger">Force_Delete</button>
</form>