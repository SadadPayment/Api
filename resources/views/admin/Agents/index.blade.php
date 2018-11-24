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
        @foreach($agents as $agent)
            <tr>
            <th scope="row">{{$agent->id}}</th>
{{--            <td>{{++$i}}</td>--}}
            <td>{{$agent->first_name}}</td>
            <td>{{$agent->phone}}</td>
            {{--<td>@if($user->user_group==3)--}}
                    {{--عضو--}}
                {{--@elseif($user->user_group==1)--}}
                    {{--اداري--}}
            {{--@elseif($user->user_group==4)--}}
                    {{--عضو ذهبي--}}
                {{--@elseif($user->user_group==5)--}}
                    {{--عضو بلاتيني--}}
            {{--@endif</td>--}}
                <td>
                    @if($agent->status =='available')
                        مفعل
                    @else
                        غير مفعل
                    @endif
                </td>

                <td>
                    <form action="{{ route('users_management.destroy',$agent->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('users_management.show',$agent->id) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('users_management.edit',$agent->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
        </tr>
        @endforeach

        </tbody>
    </table>
{{--    {!! $agents->links() !!}--}}

@stop