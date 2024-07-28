{{-- @extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Feedbacks Items List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Create Image</a></li>
                                <li class="breadcrumb-item active">Feedbacks Tables</li>
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

                            <h4 class="card-title">All Items Feedbacks List</h4>
                            <p>
                                <br>
                            </p>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Ser. No</th>
                                        <th>Feedback Name</th>
                                        <th>Feedback Email</th>
                                        <th>Sender Company</th>
                                        <th>Sender Position</th>
                                        <th>Sender Phone</th>
                                        <th>Feedback Comment</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @foreach ($allFeedbacks as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                             <td style="white-space: normal; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $item->feedback_name }}
                                                </td>
                                                <td style="white-space: normal; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $item->feedback_email }}
                                                </td>
                                                <td style="white-space: normal; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $item->feedback_company }}
                                                </td>
                                                <td style="white-space: normal; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $item->feedback_position }}
                                                </td>
                                                <td style="white-space: normal; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $item->feedback_phone }}
                                                </td>
                                                <td style="white-space: normal; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $item->feedback_message }}
                                                </td>

                                            <td style="width: 150px;"> <!-- Adjust the width as needed -->
                                                <a href="{{ route('delete.feedbacks', $item->id) }}" class="btn btn-danger sm delete-btn" title="Delete Data"><i class="fas fa-trash-alt"></i></a>
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
@endsection --}}

@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Feedbacks Items List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Create Image</a></li>
                                <li class="breadcrumb-item active">Feedbacks Tables</li>
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

                            <h4 class="card-title">All Feedbacks List</h4>
                            <p><br></p>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Ser. No</th>
                                            <th>Feedback Name</th>
                                            <th>Feedback Email</th>
                                            <th>Sender Company</th>
                                            <th>Sender Position</th>
                                            <th>Sender Phone</th>
                                            <th>Feedback Comment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i = 1)
                                        @foreach ($allFeedbacks as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->feedback_name }}</td>
                                                <td>{{ $item->feedback_email }}</td>
                                                <td>{{ $item->feedback_company }}</td>
                                                <td>{{ $item->feedback_position }}</td>
                                                <td>{{ $item->feedback_phone }}</td>
                                                <td style="white-space: normal; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">{{ $item->feedback_message }}</td>
                                                <td style="width: 150px;">
                                                    <a href="{{ route('delete.feedbacks', $item->id) }}" class="btn btn-danger sm delete-btn" title="Delete Data"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                       @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

    <!-- Include DataTables CSS and JavaScript libraries -->
    @push('css')
        <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#datatable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
        </script>
    @endpush
@endsection
