@extends('admin.admin_master')

@section('admin')
   
    <div class="page-content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Summary Section Page</h4><br><br>

                            <form action="{{ route('update.summary') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id" value="{{ $allSummary->id }}">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Number of Clients</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="summary_clients" type="text"
                                            value="{{ $allSummary->summary_clients }}" id="example-text-input">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Number of Projects</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="summary_projects" type="text"
                                            value="{{ $allSummary->summary_projects }}" id="example-text-input">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Hours of Support</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="summary_support" type="text"
                                            value="{{ $allSummary->summary_support }}" id="example-text-input">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Number of Workers</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="summary_workers" type="text"
                                            value="{{ $allSummary->summary_workers }}" id="example-text-input">
                                    </div>
                                </div>                          

                                <!-- end row -->
                                <input type="submit" class="btn btn-info btn-rounded waves-effect waves-light"
                                    value="Update Summary Page">
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
@endsection
