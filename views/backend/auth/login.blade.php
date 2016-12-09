@extends('backend.auth.cliplogin')

@section('login-content')
<h3>Sign in to your account</h3>
<p> Please enter your name and password to log in. </p>
    {!! Form::open([]) !!}
        @if($errors->has('login'))
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>{!! $errors->first('login', ':message') !!}
        </div>
        @endif
    <fieldset>
        <div class="form-group">
            <span class="input-icon">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}"/> <i class="fa fa-envelope"></i>
            </span>
        </div>
        <div class="form-group form-actions">
            <span class="input-icon">
            <input type="password" class="form-control password" name="password" placeholder="Password"/>
            <i class="fa fa-lock"></i>
            <a class="forgot" href="#">I forgot my password</a>
            </span>
        </div>
        <div class="form-actions icheck">
            <label for="remember" class="checkbox-inline">
            <input type="checkbox" class="grey remember" id="remember" name="remember"/>
            Keep me signed in
            </label>
            <button type="submit" class="btn btn-bricky pull-right">
            Login
            <i class="fa fa-arrow-circle-right"></i>
            </button>
        </div>
        <div class="new-account">
            Do not have an account yet?
            <a href="#" class="register">Create an account</a>
        </div>
    </fieldset>
    {!! Form::close() !!}
@endsection

@section('forgot-content')
<h3>Forget Password?</h3>
<p> Enter your e-mail address below to reset your password. </p>
{!! Form::open(array('class' => 'form-signup', 'id' => 'form-signin')) !!}
<div class="errorHandler alert alert-danger no-display">
    <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
</div>
<fieldset>
    <div class="form-group">
        <span class="input-icon">
        <input type="email" class="form-control" name="email" placeholder="Email">
        <i class="fa fa-envelope"></i> </span>
    </div>
    <div class="form-actions">
        <a class="btn btn-light-grey go-back">
        <i class="fa fa-circle-arrow-left"></i> Back
        </a>
        <button type="submit" class="btn btn-bricky pull-right"> Submit <i class="fa fa-arrow-circle-right"></i>
        </button>
    </div>
</fieldset>
</form>
{!! Form::submit('Send Password', array('class' => 'btn btn-sm btn-primary btn-block', 'role'=>'button')) !!}
{!! Form::close() !!}
@endsection

@section('register-content')
<h3>Sign Up</h3>
<p>
    Enter your personal details below:
</p>
<form class="form-register">
    <div class="errorHandler alert alert-danger no-display">
        <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
    </div>
    <fieldset>
        <div class="form-group">
            <input type="text" class="form-control" name="full_name" placeholder="Full Name">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="address" placeholder="Address">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="city" placeholder="City">
        </div>
        <div class="form-group">
            <div>
                <label class="radio-inline"> <input type="radio" class="grey" value="F" name="gender"> Female </label>
                <label class="radio-inline"> <input type="radio" class="grey" value="M" name="gender"> Male </label>
            </div>
        </div>
        <p>
            Enter your account details below:
        </p>
        <div class="form-group">
            <span class="input-icon">
            <input type="email" class="form-control" name="email" placeholder="Email">
            <i class="fa fa-envelope"></i> </span>
        </div>
        <div class="form-group">
            <span class="input-icon">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <i class="fa fa-lock"></i> </span>
        </div>
        <div class="form-group">
            <span class="input-icon">
            <input type="password" class="form-control" name="password_again" placeholder="Password Again">
            <i class="fa fa-lock"></i> </span>
        </div>
        <div class="form-group">
            <div>
                <label for="agree" class="checkbox-inline">
                <input type="checkbox" class="grey agree" id="agree" name="agree">
                I agree to the Terms of Service and Privacy Policy
                </label>
            </div>
        </div>
        <div class="form-actions">
            <a class="btn btn-light-grey go-back">
            <i class="fa fa-circle-arrow-left"></i> Back
            </a>
            <button type="submit" class="btn btn-bricky pull-right">
            Submit <i class="fa fa-arrow-circle-right"></i>
            </button>
        </div>
    </fieldset>
</form>
@endsection
