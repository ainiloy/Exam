@extends('admin.layouts.app')

@section('title')
    Categories
@endsection

@php
    $page = 'Categories';
@endphp

@section('mainpart')
<div class="container">
    <h1>Laravel AJAX CRUD Example Tutorial - www.techsolutionstuff.com</h1>
    <a class="btn btn-info" href="javascript:void(0)" id="createNewPost"> Add New Post</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="postForm" name="postForm" class="form-horizontal">
                   <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Category Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Name" value="" required>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="savedata" value="create">Save
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

<script type="text/javascript">
  $(function () {

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('category.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewPost').click(function () {
        $('#savedata').val("create-post");
        $('#id').val('');
        $('#postForm').trigger("reset");
        $('#modelHeading').html("Create New Category");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editPost', function () {
      var id = $(this).data('id');
      $.get("{{ route('ajaxposts.index') }}" +'/' + id +'/edit', function (data) {
          $('#modelHeading').html("Edit Category");
          $('#savedata').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#id').val(data.id);
          $('#title').val(data.title);
      })
   });

    $('#savedata').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
          data: $('#postForm').serialize(),
          url: "{{ route('category.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#postForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();

          },
          error: function (data) {
              console.log('Error:', data);
              $('#savedata').html('Save Changes');
          }
      });
    });

    $('body').on('click', '.deletePost', function () {

        var id = $(this).data("id");
        confirm("Are You sure want to delete this category!");

        $.ajax({
            type: "DELETE",
            url: "{{ route('category.store') }}"+'/'+id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

  });
</script>
@endsection
