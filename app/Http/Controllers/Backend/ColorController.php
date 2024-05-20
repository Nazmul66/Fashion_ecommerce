<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $colors = Color::getRecord();
        return view('backend.pages.color.manage', compact('colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $color = new Color();

        $color->name               =  $request->color_name;
        $color->code               =  $request->color_code;
        $color->status             =  $request->status;
        $color->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $color = Color::findRecord($id);

        $color->name               =  $request->color_name;
        $color->code               =  $request->color_code;
        $color->status             =  $request->status;
        $color->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::findRecord($id);

        $color->is_delete = 1;
        $color->save();

        return redirect()->back();
    }
}
