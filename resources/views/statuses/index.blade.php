@extends('layouts.adminindex')
@section('caption','Status List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <hr/>
        <div class="col-md-12">
            <form action="{{route('statuses.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row align-items-end">
                    <div class="col-md-6 form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Ener Status Name" value="{{old('name')}}" /> 
                    </div>
                    <div class="col-md-6">
                        <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                    </div>
                </div>

            </form>
        </div>

        <hr/>

        <div class="row">
            <div class="col-md-10">
                <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
            </div>
            <div class="col-md-2 col-sm-6 mb-2">
                <div class="input-group">
                    <input type="text" name="filtername" id="filtername" class="form-control form-control-sm rounded-0" placeholder="Search..." value="{{request('filtername')}}"/>
                    <button type="button" id="btn-search" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>

        <div class="col-md-12">

            {{-- <a href="{{route('statuses.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

            <hr/> --}}

            <table id="mytable" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
               
                </tbody>
            </table>

            <div class="loading">Loading...</div>

        </div>
    </div>
    {{-- End Page Content  --}}

    {{-- START MODAL AREA  --}}
    {{-- start edit modal  --}}
    <div id="edit-modal" class="modal fade">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Form</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formaction" action="" method="POST">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="row align-items-end">
                            <div class="col-md-8 form-group">
                                <label for="editname">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="editname" class="form-control form-control-sm rounded-0" placeholder="Ener Status Name" value="{{old('name')}}" /> 
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                            </div>
                        </div>
        
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
{{-- end edit modal  --}}
{{-- END MODAL AREA  --}}

@endsection
<!--End Content Area-->

@section('css')
    <style type="text/css">
        .loading{
            font-weight: bold;

            position: fixed;
            left: 50%;
            top: 50%;

            transform: translate(-50%,-50%); 

            display: none;
            
        }
    </style>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){

        // Start Passing Header Token

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')
            }
        })

        // End Passing Header Token 

        // Start Fetch All Datas 
        function fetchalldatas(query = ""){
            $.ajax({
                url:"{{url('api/statusessearch')}}",
                method:"GET", 
                type:"JSON", 
                data:{"query":query},
                success: function(response){

                    $("#mytable tbody").empty();
                    $('.loading').hide();

                    const datas = response.data; 
                    console.log(datas);
                    let html = '';
                    datas.forEach(function(data,idx){
                        html += `
                                <tr id="delete_${data.id}">
                                    <td>
                                        <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" />
                                    </td>
                                    <td>${++idx}</td>
                                    <td>${data.name}</td>
                                    <td>${data.user['name']}</td>
                                    <td>${data.created_at}</td>
                                    <td>${data.updated_at}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="text-info editform edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                        <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                `;
                            
                    })

                    $("#mytable tbody").html(html);
                }
            })
        }

        fetchalldatas();
        // End Fetch All Datas

        // Start Filter by Search Query
        $("#btn-search").on('click',function(e){
            e.preventDefault(); 

            const query = $("#filtername").val(); 

            if(query.length > 0){
                $(".loading").show();
            }

            fetchalldatas(query);
        }) 
        // End Filter by Search Query 

        // Start Delete item 

        $('.delete-btns').click(function(){

            var getidx = $(this).data('idx');

            if(confirm(`Are you sure !!! you want to delete ${getidx}?`)){
                $("#formdelete-"+getidx).submit();
            }else{
                return false;
            }
        })

        // ENd Delete Item 

        // Start Edit Form 

        $(document).on('click','.editform',function(e){
            
            // console.log($(this).attr('data-id'),$(this).data('name'));
            
            $("#editname").val($(this).data('name'));

            const getid = $(this).attr('data-id');
            $("#formaction").attr('action',`/statuses/${getid}`);

            e.preventDefault();
        })

        // End Edit Form 

        // $("#status-table").DataTable();

        // Start Bulk Delete 
        $("#selectalls").click(function(){
                $(".singlechecks").prop('checked',$(this).prop('checked'));
            });

            $("#bulkdelete-btn").click(function(){

                let getselectedids = []; 

                // console.log($("input:checkbox[name='singlechecks']:checked"));

                $("input:checkbox[name='singlechecks']:checked").each(function(){
                    getselectedids.push($(this).val());
                })

                Swal.fire({
                title: "Are you sure?",
                text: `You won't be able to revert!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {

                     // data remove 
                    $.ajax({
                        url:'{{route("statuses.bulkdeletes")}}',
                        type: "DELETE",
                        dataType: "json",
                        data:{
                                selectedids: getselectedids, 
                                _token: '{{csrf_token()}}'
                            },
                        success:function(response){
                            // console.log(response);
                            if(response){
                                $.each(getselectedids,function(key,value){
                                    $(`#delete_${value}`).remove();
                                });
                                
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                            }
                        }, 
                        error:function(){
                            console.log("Error : ", response);
                        }
                    });
                }
                });


            });
        // End Bulk Delete 
    })
</script>
@endsection


{{-- 
country to type search with ajax 
addon  search with php  --}}