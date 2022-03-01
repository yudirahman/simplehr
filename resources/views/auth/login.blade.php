@extends('layouts.login_page')
@section('content')
	<div class="login-box">
	  <!-- /.login-logo -->
	  <div class="card card-outline card-primary">
	    <div class="card-header text-center">
	      <a href="../../index2.html" class="h1"><b>SIMPLE</b>HR</a>
	    </div>
	    <div class="card-body">
	      <p class="login-box-msg">Sign in to start your session</p>

	      <form action="{{ route('login') }}" method="post">
	      	@csrf
	        <div class="input-group mb-3">
	          <input type="username" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" required value="{{ old('username') }}">
	          <div class="input-group-append">
	            <div class="input-group-text">
	              <span class="fas fa-user"></span>
	            </div>
	          </div>

	          @error('username')
	          	<span class="invalid-feedback" role="alert">
	          		<strong>{{ $message }}</strong>
	          	</span>
	          @enderror
	        </div>
	        <div class="input-group mb-3">
	          <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Password" required >
	          <div class="input-group-append">
	            <div class="input-group-text">
	              <span class="fas fa-lock"></span>
	            </div>
	          </div>

	          @error('password')
	          	<span class="invalid-feedback" role="alert">
	          		<strong>{{ $message }}</strong>
	          	</span>
	          @enderror
	        </div>
	        <div class="row">
	          <div class="col-8">
	            <div class="icheck-primary">
	              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : ''}}>
	              <label for="remember">
	                Remember Me
	              </label>
	            </div>
	          </div>
	          <!-- /.col -->
	          <div class="col-4">
	            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
	          </div>
	          <!-- /.col -->
	        </div>
	      </form>

	    </div>
	    <!-- /.card-body -->
	  </div>
	  <!-- /.card -->
	</div>
	<!-- /.login-box -->
@endsection
