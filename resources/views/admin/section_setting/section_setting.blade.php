@extends('admin.admin_master')

@section('admin')
<style type="text/css">
    #image-preview {
        width: 200px;
        height: 200px;
        position: relative;
        overflow: hidden;
        background-color: #ffffff;
        background-repeat: no-repeat;
        /* Added to prevent image repetition */
        color: #ecf0f1;
    }

    #image-preview input {
        line-height: 200px;
        font-size: 200px;
        position: absolute;
        opacity: 0;
        z-index: 10;
    }

    #image-preview label {
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

                            <h4 class="card-title">Section Setting Section Page</h4><br><br>

                            <form action="{{ route('update.section') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id" value="{{ $sections->id }}">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Our Email</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="contact_us_email" type="email"
                                            value="{{ $sections->contact_us_email }}" id="example-text-input">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Our Phone Number</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="contact_us_call" type="text"
                                            value="{{ $sections->contact_us_call }}" id="example-text-input">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Our Address</label>
                                    <div class="col-sm-10">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="contact_us_address" type="text"
                                                      placeholder="Leave an Address" id="example-text-input"
                                                      style="height: 100px">{{ $sections->contact_us_address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Map Location</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="contact_us_map" type="text"
                                            value="{{ $sections->contact_us_map }}" id="example-text-input">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="image-upload" class="col-sm-2 col-form-label">Feedback Image</label>

                                    <div class="col-sm-10">
                                        <div id="image-preview">
                                            <img id="preview-img" src="{{ !empty($sections->feedback_image) ? url( $sections->feedback_image) : url('uploads/no_image.jpg') }}" alt="Slide Image"
                                                style="max-width: 200px; max-height: 200px; display: block; margin-bottom: 10px;">
                                            <label for="image-upload" id="image-label" class="btn btn-primary">Choose
                                                File</label>
                                            <input type="file" name="feedback_image" id="image-upload"
                                                style="display: none;" onchange="previewImage(event)" />
                                        </div>
                                    </div>
                                </div>

                                <!-- end row -->
                                <input type="submit" class="btn btn-info btn-rounded waves-effect waves-light"
                                    value="Update Section Setting Page">
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
    
    

    <script type="text/javascript">
        $(document).ready(function() {
            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "Choose File", // Default: Choose File
                label_selected: "Change File", // Default: Change File
                no_label: false // Default: false
            });
        });
    </script>


    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview-img');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
