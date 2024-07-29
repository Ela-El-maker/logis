@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Help Items List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Create Image</a></li>
                                <li class="breadcrumb-item active">Help Tables</li>
                            </ol>
                        </div>

                        <a href="{{route('add.help')}}">
                        <button type="button" class="btn btn-outline-primary waves-effect waves-light">Create New</button>

                        </a>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">

                            <h4 class="card-title">All Help Links List</h4>
                            <p>

                                <br>
                            </p>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Ser. No</th>


                                        <th>Help Title</th>
                                        <th>Help URL</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @foreach ($allItems as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            {{-- <td><i class="" style="font-size: 20px;"></i></td> --}}
                                            <td>{{ $item->help_title }}</td>
                                            <td>{{ $item->help_url }}</td>
                                            
                                            <td style="width: 150px;"> <!-- Adjust the width as needed -->
                                                <a href="{{ route('edit.help', $item->id) }}" class="btn btn-info sm"
                                                    title="Edit Data"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('delete.help', $item->id) }}"
                                                    class="btn btn-danger sm delete-btn" title="Delete Data"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>




                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div> <!-- container-fluid -->
    </div>
@endsection
