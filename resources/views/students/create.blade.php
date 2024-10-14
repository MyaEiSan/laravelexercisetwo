@extends('layouts.adminindex')
@section('caption','Create Student')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">
            <form action="/students" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="firstname">First Name <span class="text-danger">*</span></label>
                        @error('firstname')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" placeholder="Ener First name" value="{{old('firstname')}}" /> 
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="lastname">Last Name <span class="text-danger">*</span></label>
                        @error('lastname')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" placeholder="Ener Last Name" value="{{old('lastname')}}"/> 
                    </div>
                    {{-- <div class="col-md-6 form-group mb-3">
                        <label for="regnumber">Register Number <span class="text-danger">*</span></label>
                        @error('regnumber')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="regnumber" id="regnumber" class="form-control form-control-sm rounded-0" placeholder="Ener Register Number" value="{{old('regnumber')}}"/> 
                    </div> --}}
                    <div id="multiphone" class="col-md-4 form-group mb-3 createpage">
                        <label for="phone">Phone</label>
                        <div class="input-group phonelimit">
                            <input type="text" name="phone[]" id="phone" class="form-control form-control-sm rounded-0 phone" placeholder="Enter Mobile Number" value="{{old('phone')}}" />
                            <span id="addphone" class="input-group-text" style="font-size:10px;cursor: pointer; "><i class="fas fa-plus-circle"></i></span>
                        </div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="remark">Remark</label>
                        <textarea name="remark" id="remark" class="form-control rounded-0" rows="5" placeholder="Enter Remark">{{old('remark')}}</textarea> 
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <a href="{{route('students.index')}}" class="btn btn-secondary btn-sm rounded-0">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    {{-- End Page Content  --}}
@endsection
<!--End Content Area-->

@section('scripts')
    <script type="text/javascript">
    $(document).ready(function(){
        // Start Add /Remove Phone for (creagepage / editpage)
            // Note :: do not forget to put createpage or editpage / phone 

            $(document).on('click', '#addphone', function(){
                addnewinput();
            });

            function addnewinput(){
                // console.log('hi');
                const maxnumber = 5; 
                let getphonelimit = $(".phonelimit").length;
                let newinput; 

                if($("#multiphone").hasClass('createpage')){
                    newinput =     `
                     <div class="input-group phonelimit">
                            <input type="text" name="phone[]" id="phone" class="form-control form-control-sm rounded-0 phone" placeholder="Enter Mobile Number" value="{{old('phone')}}" />
                            <span class="input-group-text removephone" style="font-size:10px;cursor: pointer; "><i class="fas fa-plus-circle"></i></span>
                        </div>
                    `;

                    $("#multiphone").append(newinput);
                }
            }

            $(document).on('click','.removephone',function(){
                $(this).parent().remove();
            })
        // End Add /Remove Phone for (creagepage / editpage)
    });
    </script>
@endsection