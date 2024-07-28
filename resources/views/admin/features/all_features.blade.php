@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Features Items List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Create Image</a></li>
                                <li class="breadcrumb-item active">Features Tables</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">All Items Features List</h4>
                            <p>
                                <br>
                            </p>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Ser. No</th>
                                        <th>Feature Image</th>
                                        <th>Feature Title</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @foreach ($allItems as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td><img src="{{ asset($item->feature_image) }}"
                                                    style="height: 70px; width:60px"></td>
                                            <td
                                                style="white-space: normal; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $item->feature_title }}
                                            </td>

                                            <td style="width: 150px;"> <!-- Adjust the width as needed -->
                                                <a href="{{ route('edit.feature', $item->id) }}" class="btn btn-info sm"
                                                    title="Edit Data"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('delete.feature', $item->id) }}"
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
