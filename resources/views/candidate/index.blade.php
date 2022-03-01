@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2 class="m-0">Candidate List</h2>
          </div><!-- /.col -->
          <div class="col-sm-6">
            {{-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v3</li>
            </ol> --}}
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('candidate.create') }}" class="btn btn-sm btn-info" style="float: right">
                                    Add Candidate
                                </a>
                            </div>
                            <div class="card-body">

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <p>{{ $message }}</p>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="20px" class="text-center">No</th>
                                        <th class="text-center">Full Name</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Experience</th>
                                        <th class="text-center">Last Position</th>
                                        <th class="text-center">Applied Position</th>
                                        <th width="220px" class="text-center">Action</th>
                                    </tr>
                                    @foreach ($candidates as $candidate)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td>{{ $candidate->name }}</td>
                                        <td>{{ $candidate->phone }}</td>
                                        <td>{{ $candidate->experience }}</td>
                                        <td>{{ $candidate->last_position }}</td>
                                        <td>{{ $candidate->applied_position }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('candidate.destroy',$candidate->id) }}" method="POST">

                                               <a class="btn btn-info btn-sm" href="{{ route('candidate.show',$candidate->id) }}">View</a>
                                                @can('candidate-edit')
                                                <a class="btn btn-primary btn-sm" href="{{ route('candidate.edit',$candidate->id) }}">Edit</a>
                                                @endcan
                                                @csrf
                                                @method('DELETE')
                                                @can('candidate-delete')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this record ?')">Delete</button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                </div>
                                <div class="mb-2 mt-2 float-right">
                                    {!! $candidates->links('pagination::bootstrap-4') !!}
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
@endsection
