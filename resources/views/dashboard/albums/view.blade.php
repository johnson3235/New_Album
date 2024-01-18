@extends('layouts.parent')
@section('title', 'view album')


@section('content')

@include('includes.response-messages')
<div class="col-12">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">view album</h3>
        </div>
        {{-- <input type="hidden" name="id" value="{{ $album->id }}"> --}}
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                        value="{{ $album->name }}">
                    @error('name')
                    <p class="text-danger"> {{ $message }} </p>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="created_at">Created_at</label>
                    <input type="created_at" name="created_at"
                        class="form-control @error('created_at') is-invalid @enderror" id="created_at"
                        value="{{ $album->created_at }}">
                    @error('created_at')
                    <p class="text-danger"> {{ $message }} </p>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="p-3"><a href="{{ route('picture.create') }}" class="btn btn-outline-primary"> Add
                            Picture To Album </a></div>
                </div>
                <div class="col-4">
<?php if(sizeof($album->pictures)!= 0){ ?>
                    <div class="p-3">
                        <a class="btn btn-outline-warning" href="{{ route('album.transport', $album->id) }}"> Transport photos and Delete
                            Album </a>
                    </div>
<?php } ?>
                </div>
                <div class="col-4">
                    <div class="p-3">
                        <form action="{{ route('album.destroy', $album->id) }}" class="d-inline" method="post" id="deleteForm2">
                            @method('DELETE')
                            @csrf

                            <button class="btn btn-outline-danger" data-toggle="modal" data-target="#confirmationModal2" type="button">
                            Delete Album with Photos
    </button>
                        
                        </form>
                    </div>
                </div>
            </div>

        </div>


        <!-- /.card-header -->

        <div class="card-header">
            <h3 class="card-title">album's picture</h3>
        </div>
        <table id="example1" class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Src</th>
                    <th>Creation Date</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($album->pictures as $picture)
                <tr>
                    <td>{{ $picture->id }}</td>
                    <td>{{ $picture->name }}</td>
                    <td>
                        <img src="{{$picture->url}}" alt="{{$picture->name}}" class="w-25 h-25"
                            style="cursor: pointer">
                    </td>
                    <td>{{ $picture->created_at }}</td>
                    <td>

                        <a href="{{ route('picture.edit', $picture->id) }}" class="btn btn-outline-warning"> Edit </a>
                        <form action="{{ route('picture.destroy', $picture->id) }}" class="d-inline" method="post" id="deleteForm">
    @method('DELETE')
    @csrf
    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#confirmationModal" type="button">
        Delete
    </button>
</form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this picture?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="confirmationModal2" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Album With Photos?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete2">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection



@section('js')
<script>
    document.getElementById('confirmDelete').addEventListener('click', function () {
        document.getElementById('deleteForm').submit();
    });

    document.getElementById('confirmDelete2').addEventListener('click', function () {
        document.getElementById('deleteForm2').submit();
    });
</script>

@endsection


