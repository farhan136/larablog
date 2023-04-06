@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Posts List') }} <button type="button" class="btn btn-outline-success btn-sm" id="add" style="width:10%; float: right;">Add</button></div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table id="table_post" class="table table-striped " style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;"></th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Author</th>
                                <th style="text-align: center;">Publication Dates</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
    $('#add').on('click', function(){
        window.open(
            "{{url('/post/create')}}", 
            '_blank', 
            'width=800,height=500,resizable=yes,screenx=0,screeny=0'
        );
    });

    $(document).ready(function () {
      $.noConflict();
      let table1= $('#table_post').DataTable({
          ajax: {
            url : "{{url('/post/gridview')}}",
            type : "POST",
            headers: {
               'X-CSRF-TOKEN': "{{csrf_token()}}",
            },
          },
          serverSide: true,
          paging: true,
          order: [[0, 'asc']],
          info: false,
          ordering:false,
          button:false,
          destroy:true,
          seaching:false,
          columns: [
            {target: 0, data: 'DT_RowIndex',orderable: false, searchable: false},
            {target: 1, data: 'name'},
            {target: 2, data: 'author'},
            {target: 3, data: 'created_at'},
            {target: 4, data: 'post_action'}
        ]
      });
      // table1.buttons().remove();
    });

    function reloadDatatable() {
        $('#table_post').DataTable().ajax.reload();
    }

    $('body').on('click', '.tombol_invite', function(){
      let id = $(this).data('id');
      window.open(
          "{{url('/post/invite_people')}}"+"/"+id,
          '_blank', 
          'width=800,height=500,resizable=yes,screenx=0,screeny=0'
      );
    })

    $('body').on('click', '.tombol_edit', function(){
      let id = $(this).data('id');
      window.open(
          "{{url('/post/edit')}}"+"/"+id+"/edit",
          '_blank', 
          'width=800,height=500,resizable=yes,screenx=0,screeny=0'
      );
    })

    $('body').on('click', '.tombol_detail', function(){
      let id = $(this).data('id');
      window.open(
          "{{url('/post/detail')}}"+"/"+id+"/detail",
          '_blank', 
          'width=800,height=500,resizable=yes,screenx=0,screeny=0'
      );
    })

    $('body').on('click', '.tombol_delete', function(){
      let id = $(this).data('id');

      $.ajax({
        url : "{{url('/post/delete')}}",
        data : {'id':id},
        type : "POST",
        headers: {
          'X-CSRF-TOKEN': "{{csrf_token()}}",
        },
        success: function(ret) { 
            let code = JSON.parse(ret)
            // console.log(code.hashed)
            window.open(
                "{{url('/post/delete')}}"+"/"+code.hashed,
                '_blank', 
                'width=800,height=500,resizable=yes,screenx=0,screeny=0'
            );
        }
      })
    });


</script>
@endsection