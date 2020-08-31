@extends('layouts.app')

@section('content')
    <div>
        <form action="{{route('verify.store')}}" method="post">
            @csrf
            <input type="text" name="two_factor_code">
            <button type="submit">Submit</button>
        </form>
    </div>   
@endsection