<div>
    @if ($view)
        <a href="{{ route($routename . '.show', $data) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
    @endif
    @if ($edit)
        <a href="{{ route($routename . '.edit', $data) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
    @endif
    
    @if ($destroy)
        <form action="{{ route($routename . '.destroy', $data) }}" method="post" style="display:inline-block">
            @csrf
            @method("DELETE")
            <button type="submit" class="btn btn-danger"><i class="fa fa-remove"></i></button>
        </form>
    @endif
    @if ($harddelete)
        <form action="{{ route($routename . '.harddelete', $data) }}" method="post" style="display:inline-block">
            @csrf
            @method("DELETE")
            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
        </form>
    @endif
    @if ($recover)
        <form action="{{ route($routename . '.restore', $data) }}" method="post" style="display:inline-block">
            @csrf
            <button type="submit" class="btn btn-success"><i class="fa fa-history"></i></button>
        </form>
    @endif
</div>
