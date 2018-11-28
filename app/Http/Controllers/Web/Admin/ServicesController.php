<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Merchant\Merchant;
use App\Model\Merchant\MerchantServices;
use App\Model\Merchant\MerchantType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = MerchantServices::with("merchant" , "type")->get();
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchants = Merchant::all();
        $types = MerchantType::all();
        return view('services/create')->with('merchants',$merchants)->with('types' , $types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new MerchantServices();
        $service->name = Input::get('name');
        $service->type_id = Input::get('type');
        $service->merchant_id = Input::get('merchant');
        $service->standardFess = Input::get('standardFess');
        $service->sadadFess = Input::get('sadadFess');
        $service->totalFees = doubleval(Input::get('sadadFess')) + doubleval(Input::get('standardFess'));

        $service->save();

        return redirect('services');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $service= MerchantServices::findOrFail($id);
        //dd($service);
        $types = MerchantType::all();
        $merchants = Merchant::all();
        return view('services/edit')->with('merchants',$merchants)->with('types' , $types)->with('service',$service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service= MerchantServices::findOrFail($id);
        $input = $request->all();
        //dd($input);

        //$merchant = new merchant();
        $service->name = $input['name'];
        $service->type_id = $input['type'];
        $service->merchant_id = $input['merchant'];
        $service->standardFess = $input['standardFess'];
        $service->sadadFess = $input['sadadFess'];
        $service->totalFees = doubleval($input['sadadFess']) + doubleval($input['standardFess']);




        //dd($input);
//        $totalFess=doubleval($input["sadadFess"]) + doubleval($input["standardFess"]);
//        unset($input["_token"]);
//        $input["totalFees"] = $totalFess;
        //$service->fill($input)->save();
        $service->save();
        //$service->totalFees = $totalFess;
        //$service->save();
        return redirect('services');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service= MerchantServices::findOrFail($id);
        $service->delete();
        return response()->json([
            'error' => 'false'
        ],200);
    }
}
