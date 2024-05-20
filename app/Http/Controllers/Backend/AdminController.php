<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(Request $request)
    {

        return view('backend.pages.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function list()
    {
        return view('backend.pages.admin.manage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // print_r($request->all());
        // $user = new User();

        // if( !is_null( $user ) ){
        //     $user->name       = $request->name;
        //     $user->email      = $request->email;
        //     $user->password   = Hash::make($request->password);
        //     $user->role       = $request->role;
        //     $user->status     = 1;

        //     $user->save();
        // }

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function getData()
    {
        $user = User::all();
        return response()->json(['status' => 'success', "allUser" => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editData(Request $request)
    {
        $user = User::where('id', $request->id)->first();

         return response()->json(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateData(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        if( !is_null( $user ) ){
            $user->name       = $request->name;
            $user->password   = Hash::make($request->password);
            $user->role       = $request->role;
            $user->status     = $request->status;

            $user->save();

            return response()->json(['status' => 'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteData(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        if( !is_null($user) ){
            $user->delete();

            return response()->json(['status' => 'success']);
        }
    }
}
