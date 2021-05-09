@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/category/"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Category Management</li>
                    </ul>
                    <p></p>
                </div>            
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-6 col-md-12 col-sm-12">
                @include('backend.layouts.notification')
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Total Category</strong> : {{\App\Models\Category::count()}}</h2>
                        <a class="float-right btn btn-primary" href="{{route('category.create')}}">Create New Category</a>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th>Category Image</th>
                                        <th>Is Parent</th>
                                        <th>Parents</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>                            
                                <tbody>
                                    
                                    @foreach($categories as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->title}}</td>
                                        <td><img src="{{$item->photo}}" alt="banner image" style="max-height: 90px; max-width: 120px;" ></td>
                                        <td>{{$item->is_parent===1 ? 'Yes' : 'No' }}</td>
                                        <td>{{\App\Models\Category::where('id',$item->parent_id)->value('title')}}</td>
                                        <td>
                                            <input type="checkbox" name="toogle" value="{{$item->id}}" data-toggle="switchbutton" {{$item->status=='active' ? 'checked' : '' }} data-onlabel="active" data-offlabel="inactive" data-size="sm" data-onstyle="success" data-offstyle="danger">
                                        </td>
                                        
                                        <td>
                                            <a href="{{route('category.edit',$item->id)}}" data-toggle="tooltip" title="edit"  class="float-left btn btn-sm btn-outline-warning" data-placement="bottom" ><i class="fa fa-edit"></i></a>
                                            <form class="float-left ml-2" action="{{route('category.destroy',$item->id)}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a href="" data-toggle="tooltip" title="delete" data-id="{{$item->id}}" class="dltBtn btn btn-sm btn-outline-danger" data-placement="bottom" ><i class="fa fa-trash"></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                        @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                   
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function (e) {
            var form=$(this).closest('form');
            var dataID=$(this).data('id');
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Category",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                    swal("Poof! Your Category has been deleted!", {
                    icon: "success",
                    });
                } else {
                    swal("Your Category is safe!");
                }
                });
        });
</script>
<script>
    $('input[name=toogle]').change(function () {
        var mode=$(this).prop('checked');
        var id=$(this).val();
        //alert(id);
        $.ajax({
            url:"{{route('category.status')}}",
            type:"POST",
            data:{
                _token:'{{csrf_token()}}',
                mode:mode,
                id:id,
            },
            success:function (response) {
                if(response.status){
                    alert(response.msg);
                }
                else{
                    alert('Please try again!');
                }
            }

        })
    });
</script>

@endsection