@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2 class="m-0">Edit Candidate</h2>
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
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong><br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('candidate.update', $candidates->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                    
                                      <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                                        <div class="col-md-6 col-sm-10">
                                          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{$candidates->name}}" placeholder="Full Name" required>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="education" class="col-sm-2 col-form-label">Education</label>
                                        <div class="col-md-6 col-sm-10">
                                         {{--  <input type="text" class="form-control" id="text" placeholder="Education"> --}}
                                         <select class="form-control @error('education') is-invalid @enderror" name="education" required>
                                          <option value="">-Select Education-</option>
                                          <option value="SMU" {{ ($candidates->education === 'SMU') ? 'Selected' : ''}} >SMU</option>
                                          <option value="Associate Degree" {{ ($candidates->education === 'Associate Degree') ? 'Selected' : ''}}>Associate Degree</option>
                                          <option value="Bachelor's Degree" {{ ($candidates->education === 'Bachelor\'s Degree') ? 'Selected' : ''}} >Bachelor's Degree</option>
                                          <option value="Masters Degree" {{ ($candidates->education === 'Masters Degree') ? 'Selected' : ''}}>Masters Degree</option>
                                          <option value="Doctorate" {{ ($candidates->education === 'Doctorate') ? 'Selected' : ''}}>Doctorate</option>
                                        </select>

                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="birthday" class="col-sm-2 col-form-label">Birthday</label>
                                        <div class="col-md-6 col-sm-10">
                                          <input type="date" name="birthday" class="form-control @error('birtday') is-invalid @enderror" id="text" placeholder="Birthday" value="{{ date('Y-m-d', strtotime($candidates->birthday)) }}" required>

                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="experience" class="col-sm-2 col-form-label">Experience</label>
                                        <div class="col-md-2 col-sm-10">
                                          <input type="number" name="experience" class="form-control @error('experience') is-invalid @enderror" id="text" placeholder="In Years" value="{{$candidates->experience}}" required>

                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="last_position" class="col-sm-2 col-form-label">Last Position</label>
                                        <div class="col-md-6 col-sm-10">
                                          <input type="text" name="last_position" class="form-control @error('last_position') is-invalid @enderror" id="text" placeholder="Your Last Position" value="{{$candidates->last_position}}" required>


                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="applied_position" class="col-sm-2 col-form-label">Applied Position</label>
                                        <div class="col-md-6 col-sm-10">
                                          <input type="text" name="applied_position" class="form-control @error('applied_position') is-invalid @enderror" id="text" placeholder="Position applied" value="{{$candidates->applied_position}}" required>

                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="skils" class="col-sm-2 col-form-label">Top 5 Skills</label>
                                        <div class="col-md-6 col-sm-10">
                                          <input type="text" name="skils" class="form-control @error('skils') is-invalid @enderror" id="text" placeholder="Separated by comma" value="{{$candidates->skils}}" required>

                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-md-6 col-sm-10">
                                          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="text" placeholder="Email address" value="{{$candidates->email}}" required>

                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="education" class="col-sm-2 col-form-label">Phone Number</label>
                                        <div class="col-md-6 col-sm-10">
                                          <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" id="text" placeholder="ex:081219219292" value="{{$candidates->phone}}" required>

                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="education" class="col-sm-2 col-form-label">Resume</label>
                                        <div class="col-md-6 col-sm-10">
                                        <div class="input-group">
                                          <div class="custom-file">
                                            <input type="file" name="resume" class="custom-file-input @error('resume') is-invalid @enderror" id="resumeFile" >
                                            <label class="custom-file-label" for="resumeFile">Choose file</label>
                                          </div>

                                        </div>
                                          <a href="{{ asset('resume/'.$candidates->resume) }}" target="_blank">{{ $candidates->resume }}</a>
                                      </div>
                                      
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="col-md-8 col-sm-10">
                                      <button type="submit" class="btn btn-info float-right">Submit</button>
                                    </div>
                                    <!-- /.card-footer -->
                                </form>
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
@push('js')
    <script type="application/javascript">
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
    </script>
@endpush