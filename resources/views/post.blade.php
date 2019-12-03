@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row">
        <form action="{{url('/getLocation')}}" method="POST">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="">App Name</label>
                    <input type="text" name='app_name' class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Device Id</label>
                    <input type="text" name='device_id' class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Version</label>
                    <input type="text" name='app_version' class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </div>
        </form>
    </div>
</div>


@endsection
