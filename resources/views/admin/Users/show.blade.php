@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
    <div class="row">
        <div class=" col-md-6">
            <div class="box box-success">
                <div class="box-title">
                    User Information
                </div>
                <div class="box-body">
                    <p>#id: {{$user->is}}</p>
                    <p>Full Name: {{$user->fullName}}</p>
                    <p>UserName: {{$user->username}}</p>
                    <p>E-mail: {{$user->email}}</p>
                    <p>phone: {{$user->phone}}</p>

                    <span class="datepicker-days">Account Create: {{$user->created_at}}</span>

                </div>
            </div>
        </div>

        {{--<div class=" col-md-4">--}}
        {{--<div class="box box-success">--}}
        {{--<div class="box-body">--}}
        {{--{{$user->id}}--}}
        {{--{{$user->fullName}}--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>
    <div class="container">
        <h2>Dynamic Tabs</h2>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
            <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
            <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
            <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <h3>HOME</h3>
                @foreach($user->accounts as $account)
                    <p>Account number: {{$account->PAN}}</p>
                    <p>Expiration Data: {{$account->expDate}}</p>
                    <p>Mbr: {{$account->mbr}}</p>
                    <p>Account Created at: {{$account->created_at}}</p>
                    <p>Account Last Update at: {{$account->updated_at}}</p>
                @endforeach
            </div>
            <div id="menu1" class="tab-pane fade">
                @foreach($user->transactions as $transaction)
                    <details>
                        <p>Account number: {{$transaction->transDateTime}}</p>
                        <p>transaction_type: {{$transaction->transaction_type}}</p>
                        <p>Account Created at: {{$account->created_at}}</p>
                        <p>Account Last Update at: {{$account->updated_at}}</p>
                    </details>
                @endforeach
            </div>
            <div id="menu2" class="tab-pane fade">
                <h3>Menu 2</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                    totam rem aperiam.</p>
            </div>
            <div id="menu3" class="tab-pane fade">
                <h3>Menu 3</h3>
                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                    explicabo.</p>
            </div>
        </div>
    </div>


@stop