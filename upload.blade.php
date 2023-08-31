
@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="kmlFile">Upload KML File:</label>
            <input type="file" class="form-control" name="kmlFile" id="kmlFile">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
