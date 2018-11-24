@extends('adminlte::page')

@section('title', 'Agents Management')
<style>
    #map {
        height: 40%;
    }

    html, body {
        height: 40%;
        margin: 0;
        padding: 0;
    }
</style>
@section('content_header')
    <h1>Agents</h1>
@stop

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">

                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span><i class="fa fa-edit"></i></span>
                        <span>{{ isset($item)? 'Edit ' . $item->name : 'Add Agent' }}</span>
                    </h3>
                </div>

                <div class="box-body ">

                    <form method="post" enctype="multipart/form-data"
                          {{--                          @if (isset($item)) action="{{route('products.update', $item)}}"--}}
                          @if (isset($item)) action="{{route('agent_management.update', $item->id)}}"
                          @else
                          action="{{route('agent_management.store')}}"
                            @endif>
                        @if(isset($item))
                            {{ method_field('PATCH') }}
                            @method('PATCH')
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="first_name">First Name: </label>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                   placeholder="first_name"
                                   @if (isset($item))
                                   value="{{$item->first_name}}"
                                    @endif>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name: </label>
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                   placeholder="last_name"
                                   @if (isset($item))
                                   value="{{$item->last_name}}"
                                    @endif>
                        </div>


                        <div class="form-group">
                            <label for="phone">phone: </label>
                            <input type="number" class="form-control" name="phone" id="phone"
                                   placeholder="phone"
                                   @if (isset($item))
                                   value="{{$item->phone}}"
                                    @endif>
                        </div>

                        <div class="form-group">
                            <label for="password">password: </label>
                            <input type="text" class="form-control" name="password" id="password"
                                   placeholder="password" value="agent321"
                                   @if (isset($item))
                                   value="{{$item->password}}"
                                    @endif>
                        </div>

                        <div class="form-group">
                            <label for="email">email: </label>
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="email"
                                   @if (isset($item))
                                   value="{{$item->email}}"
                                    @endif>
                        </div>

                        <div class="form-group">
                            <label for="work">work: </label>
                            <input type="text" class="form-control" name="work" id="work"
                                   placeholder="work"
                                   @if (isset($item))
                                   value="{{$item->work}}"
                                    @endif>
                        </div>


                        <div class="form-group">
                            <label for="work">state: </label>
                            <input type="text" class="form-control" name="state" id="state"
                                   placeholder="state"
                                   @if (isset($item))
                                   value="{{$item->state}}"
                                    @endif>
                        </div>

                        <div class="form-group">
                            <label for="city">city: </label>
                            <input type="text" class="form-control" name="city" id="city"
                                   placeholder="city"
                                   @if (isset($item))
                                   value="{{$item->city}}"
                                    @endif>
                        </div>


                        <div class="form-group">
                            <label for="local">local: </label>
                            <input type="text" class="form-control" name="local" id="local"
                                   placeholder="local"
                                   @if (isset($item))
                                   value="{{$item->local}}"
                                    @endif>
                        </div>


                        <div class="form-group">
                            <label for="local">address: </label>
                            <input type="text" class="form-control" name="address" id="address"
                                   placeholder="address"
                                   @if (isset($item))
                                   value="{{$item->address}}"
                                    @endif>
                        </div>


                        <div class="form-group">
                            <label for="status">status: </label>
                            <select id="status" name="status" class="form-control form-control-sm">
                                @if (isset($item))
                                    value="{{$item->status}}"
                                @endif>
                                <option value="available">available</option>
                                <option value="cancel">cancel</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="map">map: </label>
                            <div id="map"></div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="lat">latitude: </label>
                            <input type="text" class="form-control" name="latitude" id="latitude"
                                   placeholder="latitude"
                                   readonly
                                   @if (isset($item))
                                   value="{{$item->latitude}}"
                                    @endif>
                            <label for="lng">longitude: </label>
                            <input type="text" class="form-control" name="longitude" id="longitude"
                                   placeholder="longitude"
                                   readonly
                                   @if (isset($item))
                                   value="{{$item->longitude}}"
                                    @endif>
                        </div>
                        <div class="form-group-sm col-md-10">
                            <button type="submit" class="btn btn-primary btn-adn ">@if (isset($item))
                                    تحديث
                                @else
                                    إضافة
                                @endif</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.googlemap')
@stop