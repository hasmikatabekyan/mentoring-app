@extends('layouts.app')

@section('content')
    <div class="bg-light p-5 rounded">
        <h1>Files</h1>
        <a href="{{ route('files.create') }}" class="btn btn-primary float-right mb-3">Add file</a>

{{--        @include('layouts.app')--}}

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Size</th>
                <th scope="col">Type</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($files as $file)
                <tr>
                    <td width="3%">{{ $file->id }}</td>
                    <td>{{ $file->name }}</td>
                    <td width="10%">{{ $file->size }}</td>
                    <td width="10%">{{ $file->type }}</td>
                    <td width="10%"><a href="{{ url('matches/'.$file->id) }}" class="btn btn-info btn-sm">View Matches</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection