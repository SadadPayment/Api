@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First Name</th>
            <th scope="col">phone</th>
            <th scope="col">Account Status</th>
            <th scope="col">users status</th>
            <th width="280px">Action</th>

        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
            <th scope="row">{{++$i}}</th>
{{--            <td>{{++$i}}</td>--}}
            <td>{{$user->fullName}}</td>
            <td>{{$user->phone}}</td>
            <td>@if($user->user_group==3)
                    عضو
                @elseif($user->user_group==1)
                    اداري
            @elseif($user->user_group==4)
                    عضو ذهبي
                @elseif($user->user_group==5)
                    عضو بلاتيني
            @endif</td>
                <td>
                    @if($user->status ==1)
                        مفعل
                    @else
                        غير مفعل
                    @endif
                </td>

                <td>
                    <form action="{{ route('users_management.destroy',$user->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('users_management.show',$user->id) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('users_management.edit',$user->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
        </tr>
        @endforeach

        </tbody>
    </table>
    {!! $users->links() !!}

@stop