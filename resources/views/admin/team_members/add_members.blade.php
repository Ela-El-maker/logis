@extends('admin.admin_master')

@section('admin')
    <style type="text/css">
        #image-preview, #image-preview-2, #image-preview-3 {
            width: 200px;
            height: 200px;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            background-repeat: no-repeat;
            color: #ecf0f1;
        }

        #image-preview input, #image-preview-2 input, #image-preview-3 input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }

        #image-preview label, #image-preview-2 label,#image-preview-3 label {
            position: absolute;
            z-index: 5;
            opacity: 0.8;
            cursor: pointer;
            background-color: #bdc3c7;
            width: 200px;
            height: 50px;
            font-size: 20px;
            line-height: 50px;
            text-transform: uppercase;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            text-align: center;
        }
    </style>


<div class="page-content">
    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                            <h4 class="card-title">Add Team Member Section Page</h4><br><br>

                            <form action="{{route('store.member')}}" method="post" enctype="multipart/form-data">
                                @csrf


                                <input type="hidden" name="id" value="">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Member Name</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="team_member_name" type="text"
                                            value="" id="example-text-input">
                                    </div>
                                </div>
                               

                                <div class="row mb-3">
                                    <label for="image-upload" class="col-sm-2 col-form-label">Member Profile Picture</label>
                                    <div class="col-sm-10">
                                        <div id="image-preview">
                                            <img id="preview-img"
                                                 src="{{ url('uploads/no_image.jpg') }}"
                                                 alt="Slide Image"
                                                 style="max-width: 200px; max-height: 200px; display: block; margin-bottom: 10px;">
                                            <label for="image-upload" id="image-label" class="btn btn-primary">Choose
                                                File</label>
                                            <input type="file" name="team_member_image" id="image-upload"
                                                   style="display: none;" onchange="previewImage(event, 'preview-img')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Position</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="team_member_position" type="text"
                                            value="" id="example-text-input">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Twitter Handle</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="team_member_twitter" type="text"
                                            value="" id="example-text-input">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Instagram Handle</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="team_member_instagram" type="text"
                                            value="" id="example-text-input">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">LinkendIn Handle</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="team_member_linkedIn" type="text"
                                            value="" id="example-text-input">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Personal Speech</label>

                                    <div class="col-sm-10">
                                        <textarea id="elm1" name="team_member_speech"></textarea>
                                        @error('team_member_speech')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                                


                                <input type="submit" class="btn btn-info btn-rounded waves-effect waves-light"
                                value="Add Feature">
                     </form>
                 </div>
             </div>
         </div> <!-- end col -->
     </div>
     <!-- end row -->
 </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
 function previewImage(event, previewId) {
     var reader = new FileReader();
     reader.onload = function() {
         var output = document.getElementById(previewId);
         output.src = reader.result;
     };
     reader.readAsDataURL(event.target.files[0]);
 }
</script>
@endsection