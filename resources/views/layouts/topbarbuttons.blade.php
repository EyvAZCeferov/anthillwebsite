@if ($add)
    <a href="{{ route($routename . '.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> @lang("additional.page_types.create")</a>
@endif
@if ($home)
    <a href="{{ route($routename . '.index') }}" class="btn btn-warning"><i class="fa fa-home"></i> @lang("additional.page_types.list")</a>
@endif
@if (auth()->user()->hasRole('Admin') && $harddelete)
    <a href="{{ route($routename . '.deleted') }}" class="btn btn-danger"><i class="fa fa-trash"></i> @lang("additional.page_types.deleted_list")</a>
@endif
@if ($restoreall)
    <form action="{{ route($routename . '.restoreall') }}" method="post" style="display:inline-block">
        @csrf
        <button type="submit" class="btn btn-success"><i class="fa fa-history"></i> @lang("additional.buttons.restoreall")</button>
    </form>
@endif
