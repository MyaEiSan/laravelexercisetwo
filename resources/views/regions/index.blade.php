@extends('layouts.adminindex')
@section('caption','City List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <hr/>
        <div class="col-md-12">
            <form action="{{route('regions.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row align-items-end">

                    <div class="col-md-3 form-group mb-3">
                        <label for="country_id">Country <span class="text-danger">*</span></label>
                        <select name="country_id" id="country_id" class="form-control form-control-sm rounded-0 country_id">
                            @foreach($countries as $country)
                                <option value="{{$country['id']}}" {{old('country_id') == $country['id']?'selected':''}}>{{$country['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="name">Region Name <span class="text-danger">*</span></label>
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Ener Country Name" value="{{old('name')}}" /> 
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="status_id">Status <span class="text-danger">*</span></label>
                        <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
                            @foreach($statuses as $status)
                                <option value="{{$status['id']}}" {{old('status_id') == $status['id']?'selected':''}}>{{$status['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 text-sm-end text-md-start mb-3">
                        <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                    </div>
                </div>

            </form>
        </div>

        <hr/>

        <div>
            <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
        </div>

        <div class="col-md-12">
            <form action="" method="">
                <div class="row justify-content-end">
                    <div class="col-md-2 col-sm-6 mb-2">
                        <div class="input-group">
                            <input type="text" name="filtername" id="filtername" class="form-control form-control-sm rounded-0" placeholder="Search..." />
                            <button type="submit" id="btn-search" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-12">
{{-- 
            <a href="{{route('countries.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

            <hr/> --}}

            <table id="country-table" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th>By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($regions as $idx=>$region)
                <tr id="delete_{{$region->id}}">
                        {{-- <td>{{++$idx}}</td> --}}
                        <td>
                            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$region->id}}" />
                        </td>
                        <td>{{$idx + $regions->firstItem()}}</td>
                        <td>{{$region->name}}</td>
                        <td>{{$region->country->name}}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input change-btn" {{ $region->status_id === 3 ? 'checked':'' }} data-id="{{$region->id}}" />
                            </div>
                        </td>
                        <td>{{$region->user['name']}}</td>
                        <td>{{$region->created_at->format('d M Y')}}</td>
                        <td>{{$region->updated_at->format('d M Y')}}</td>
                        <td>
                            <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{$region->id}}" data-name="{{$region->name}}" data-country="{{$region->country_id}}" data-city="{{$region->city_id}}" data-status="{{$region->status_id}}"><i class="fas fa-pen"></i></a>
                            <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        <form id="formdelete-{{$idx}}" action="{{route('regions.destroy',$region->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{$regions->links('pagination::bootstrap-4')}}

        </div>
    </div>
    {{-- End Page Content  --}}
@endsection
<!--End Content Area-->

{{-- START MODAL AREA  --}}
    {{-- start edit modal  --}}
        <div id="edit-modal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
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

                                <div class="col-md-6 form-group mb-3">
                                    <label for="editcountry_id">Country <span class="text-danger">*</span></label>
                                    <select name="editcountry_id" id="editcountry_id" class="form-control form-control-sm rounded-0 country_id">
                                        @foreach($countries as $country)
                                            <option value="{{$country['id']}}">{{$country['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="editname">Region Name <span class="text-danger">*</span></label>
                                    <input type="text" name="editname" id="editname" class="form-control form-control-sm rounded-0" placeholder="Ener Country Name" value="{{old('editname')}}" /> 
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="editstatus_id">Status <span class="text-danger">*</span></label>
                                    <select name="editstatus_id" id="editstatus_id" class="form-control form-control-sm rounded-0">
                                        @foreach($statuses as $status)
                                            <option value="{{$status['id']}}">{{$status['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
            

                                <div class="col-md-2 text-sm-end text-start mb-3">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-0">Update</button>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){

        // Start Dynamic Select Option 
        $(document).on('change','.country_id',function(){
            const getcountryid = $(this).val();

            let opforcity = "";

            $.ajax({
                url:   `/api/filter/cities/${getcountryid}`, 
                type: 'GET', 
                dataType: 'json', 
                success: function(response){

                    $(".city_id").empty();

                    opforcity += `<option selected disabled>Choose a city</option>`;

                    for(let x = 0; x < response.data.length; x++){
                        opforcity +=`<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                    }

                    $(".city_id").append(opforcity);

                }, 
                error: function(response){
                    console.log("Error : ",response);
                }
            });
        })
        // End Dynamic Selection Option 

         // Start Edit Form 

         $(document).on('click','.editform',function(e){
            
            // console.log($(this).attr('data-id'),$(this).data('name'));
            
            $("#editname").val($(this).data('name'));
            $("#editcountry_id").val($(this).attr('data-country'));
            $("#editcity_id").val($(this).attr('data-city'));
            $("#editstatus_id").val($(this).attr('data-status'));
            

            const getid = $(this).attr('data-id');
            $("#formaction").attr('action',`/regions/${getid}`);

            e.preventDefault();
        })

        // End Edit Form 

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

       

         // Start change-btn 

         $('.change-btn').change(function(){
            
            var getid = $(this).data('id');
            // console.log(getid);
            var setstatus = $(this).prop('checked') === true? 3 : 4;
            // console.log(setstatus);

            $.ajax({
                url: "regionsstatus" ,
                type: "GET",
                dataType: "json",
                data: {"id":getid,"status_id": setstatus},
                success: function(response){
                    // console.log(response);
                    Swal.fire({
                        title: "Updated!",
                        text: "Updated Successfully!",
                        icon: "success"
                    });
                }
            });
        });

        // End change-btn 

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
                        url:'{{route("regions.bulkdeletes")}}',
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

