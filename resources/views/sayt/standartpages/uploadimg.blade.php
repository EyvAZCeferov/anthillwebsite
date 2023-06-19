@extends('layouts.app')
@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="w-100 align-center justify-center text-center mx-auto mt-5 pt-5">
        <form action="{{ route('apiuploadimage') }}" method="post" enctype="multipart/form-data" class="w-50 mx-auto">
            <input type="file" multiple name="images[]" id="" class="form-control">
            <input type="submit" value="Submit" class="form-control btn" />
        </form>
    </div>
@endsection
