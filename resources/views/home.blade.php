@extends('layouts.app')

@section('content')
<nav class="col-12 col-md-2 admin-sidebar">
    <Sidebar></Sidebar>
</nav>
<div class="col-12 col-md-10">
    <div class="admin-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            You are logged in!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
