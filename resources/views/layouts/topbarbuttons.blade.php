@if ($add)
    <a href="{{ route($routename . '.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Əlavə et</a>
@endif
@if ($home)
    <a href="{{ route($routename . '.index') }}" class="btn btn-warning"><i class="fa fa-home"></i> List</a>
@endif
@if (auth()->user()->hasRole('Admin') && $harddelete)
    <a href="{{ route($routename . '.deleted') }}" class="btn btn-danger"><i class="fa fa-trash"></i> Silinmiş List</a>
@endif
@if ($restoreall)
    <form action="{{ route($routename . '.restoreall') }}" method="post" style="display:inline-block">
        @csrf
        <button type="submit" class="btn btn-success"><i class="fa fa-history"></i> Hamısını
            geri qaytar</button>
    </form>
@endif
