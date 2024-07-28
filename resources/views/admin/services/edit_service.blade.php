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

                            <h4 class="card-title">Edit Service Items Section Page</h4><br><br>

                            <form action="{{route('update.service')}}" method="post" enctype="multipart/form-data">
                                @csrf


                                <input type="hidden" name="id" value="{{$editService->id}}">

              

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Service Category Name</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="service_category_id" aria-label="Default select example">
                                            <option selected="">Category Name</option>
                                            @foreach ($serviceCategories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $editService->service_category_id ? 'selected' : '' }}>
                                                {{ $category->service_category }}</option>
                                        @endforeach
                                           
                                           
                                            </select>
                                    </div>
                                </div>

                               

                               

                                <div class="row mb-3">
                                    <label for="image-upload" class="col-sm-2 col-form-label">Service  Image</label>
                                    <div class="col-sm-10">
                                        <div id="image-preview">
                                            <img id="preview-img"
                                                 src="{{!empty($editService->service_image) ? url($editService->service_image) :  url('uploads/no_image.jpg') }}"
                                                 alt="Slide Image"
                                                 style="max-width: 200px; max-height: 200px; display: block; margin-bottom: 10px;">
                                            <label for="image-upload" id="image-label" class="btn btn-primary">Choose
                                                File</label>
                                            <input type="file" name="service_image" id="image-upload"
                                                   style="display: none;" onchange="previewImage(event, 'preview-img')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Service Title</label>
                                    <div class="col-sm-10">

                                        <div class="form-floating">

                                            <input class="form-control" name="service_title" type="text"
                                                value="{{$editService->service_title}}" id="example-text-input">
                                                @error('service_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Service Sub
                                        Title</label>
                                    <div class="col-sm-10">

                                        <textarea class="form-control" name="service_sub_title" type="text" placeholder="Leave a Sub title here"
                                            id="example-text-input" style="height: 100px">{{$editService->service_sub_title}}</textarea>

                                        @error('service_sub_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Service
                                        Description</label>

                                    <div class="col-sm-10">
                                        <textarea id="elm1" name="service_description">{{$editService->service_description}}</textarea>
                                        @error('service_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

               

                                <input type="submit" class="btn btn-info btn-rounded waves-effect waves-light"
                                value="Update Service">
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

