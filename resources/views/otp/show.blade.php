@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card">
                @if ($errors->count() > 0)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                <div class="card-header">
                    <h3>Enter OTP</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('otp.verify') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="otp">OTP Code</label>
                            <input type="text" name="otp" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('otp.resend') }}">Resend OTP</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection