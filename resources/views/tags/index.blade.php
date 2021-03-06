@extends('layouts.app')


@section('content')

<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('tags.create') }}" class="btn btn-success"> Add Tag</a>
</div>
<div class="card card-default">
    <div class="card-header">
        tags
    </div>

    <div class="card-body">
        @if ($tags ->count() > 0)
        <div class="card card-default">
            <div class="card-header">
                tags
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <th> Name</th>
                        <th>Posts count</th>
                        <th></th>
                    </thead>

                    <tbody>
                        @foreach ($tags as $tag)
                        <tr>
                            <td>
                                {{ $tag->name }}
                            </td>
                            <td>
                                {{ $tag->posts->count()}}
                            </td>
                            <td>
                                <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-info btn-sm">
                                    Edit
                                </a>
                                <div class="btn btn-danger btn-sm" onclick="handleDelete({{ $tag->id}})"> Delete
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="modal fade" id="deleteModal" data-backdrop="static" role="dialog" data-keyboard="false"
                    tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">

                        <form action="" method="POST" id="deleteTagForm">
                            @csrf
                            @method('DELETE')

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Delete tag</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center text-bold">
                                        Are you sure to delete this
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Go
                                        Back</button>
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <h3 class="text-center">NO tags yet</h3>
        @endif

    </div>
</div>
</div>

@endsection

@section('scripts')
<script>
    function handleDelete(id) {

        var form = document.getElementById('deleteTagForm')
        form.action= '/tags/' + id

        $('#deleteModal').modal('show')
    }
</script>
@endsection
