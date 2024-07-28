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

                            <h4 class="card-title">Update Logos Section Page</h4><br><br>

                            <form action="{{route('update.logos')}}" method="post" enctype="multipart/form-data">
                                @csrf


                                <input type="hidden" name="id" value="{{$logos->id}}">

                               
                           
                               

                                <div class="row mb-3">
                                    <label for="image-upload" class="col-sm-2 col-form-label">Logo  Image</label>
                                    <div class="col-sm-10">
                                        <div id="image-preview">
                                            <img id="preview-img"
                                                 src="{{ !empty($logos->logo_image) ? url($logos->logo_image) :url('uploads/no_image.jpg') }}"
                                                 alt="Slide Image"
                                                 style="max-width: 200px; max-height: 200px; display: block; margin-bottom: 10px;">
                                            <label for="image-upload" id="image-label" class="btn btn-primary">Choose
                                                File</label>
                                            <input type="file" name="logo_image" id="image-upload"
                                                   style="display: none;" onchange="previewImage(event, 'preview-img')" />
                                        </div>
                                    </div>
                                </div>



                               
                                <div class="row mb-3">
                                    <label for="image-upload-2" class="col-sm-2 col-form-label">Favicon Image</label>
                                    <div class="col-sm-10">
                                        <div id="image-preview-2">
                                            <img id="preview-img-2"
                                                 src="{{!empty($logos->favicon_image) ? url($logos->favicon_image) : url('uploads/no_image.jpg') }}"
                                                 alt="Slide Image"
                                                 style="max-width: 200px; max-height: 200px; display: block; margin-bottom: 10px;">
                                            <label for="image-upload-2" id="image-label-2" class="btn btn-primary">Choose
                                                File</label>
                                            <input type="file" name="favicon_image" id="image-upload-2"
                                                   style="display: none;" onchange="previewImage(event, 'preview-img-2')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="image-upload-3" class="col-sm-2 col-form-label">Footer Image</label>
                                    <div class="col-sm-10">
                                        <div id="image-preview-3">
                                            <img id="preview-img-3"
                                                 src="{{ !empty($logos->footer_image) ? url($logos->footer_image) : url('uploads/no_image.jpg') }}"
                                                 alt="Slide Image"
                                                 style="max-width: 200px; max-height: 200px; display: block; margin-bottom: 10px;">
                                            <label for="image-upload-3" id="image-label-3" class="btn btn-primary">Choose
                                                File</label>
                                            <input type="file" name="footer_image" id="image-upload-3"
                                                   style="display: none;" onchange="previewImage(event, 'preview-img-3')" />
                                        </div>
                                    </div>
                                </div>


                                <input type="submit" class="btn btn-info btn-rounded waves-effect waves-light"
                                value="Update Logos">
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