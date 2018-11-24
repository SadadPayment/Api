<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\UserGroup;
use Illuminate\Http\Request;

class UsersManagementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()
            ->with(['transactions', 'userGroup', 'accounts'])
            ->paginate(5);

        return view('admin.Users.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $type = type::all();
        return view('merchants.create')->with('types', $type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $merchant = new Merchant();
        $merchant->merchant_name = $request->name;
        $merchant->type_id = $request->type;
        $merchant->status = true;
        $merchant->payee_id = 1;
        $merchant->save($request->all());


        return redirect('merchants');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\User
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['transactions.transactionType', 'accounts'])->find($id);
        $group_type = UserGroup::all('id', 'type');

        return view('admin.Users.show', compact(['user', 'group_type']));
//        return response()->json([$user, $group_type]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\User
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $merchant = Merchant::findOrFail($id);
        $types = type::all();
        return View('merchants/edit', compact(['merchant', 'types']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $merchant = Merchant::findOrFail($id);
        //$merchant = new merchant();
        $input = $request->all();
        $merchant->fill($input)->save();
        return redirect('merchants');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\User
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        //
//        $merchant= Merchant::findOrFail($id);
//        $merchant->delete();
//        return response()->json([
//            'error' => 'false'
//        ],200);
//    }

    public function delete($id)
    {
        //Application
        $merchant = User::findOrFail($id);
        $merchant->delete();
        return response()->json([
            'error' => 'false'
        ], 200);
    }


}
