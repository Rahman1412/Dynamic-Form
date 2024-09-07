@extends('app')

@section('content')

<div class="container">
    @if(session("success"))
    {{session("success")}}
    @endif
    @if(session("error"))
    {{session("error")}}
    @endif
    <form action="{{url('register')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name')}}">
            @error("name")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" value="{{ old('email')}}">
            @error("email")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password">
            @error("password")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>

    <form action="{{url('login')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" value="{{ old('email')}}">
            @error("email")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password">
            @error("password")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
</div>

@endsection