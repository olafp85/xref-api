<?php

namespace App\Http\Controllers;

use App\Models\Xref;
use Illuminate\Http\Request;

class XrefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Xref::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  Xref  $xref
     * @return \Illuminate\Http\Response
     */
    public function show(Xref $xref)
    {
        $xref->load('units')->load('calls');
        return $xref;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required'
        ]);

        // Check for unprocessable content 
        $xref = new Xref();
        foreach ($request->all() as $key => $value) {
            if (!$xref->isRelation($key) && !$xref->isFillable($key)) {
                return response()->json(["message" => "The " . $key . " field cannot be processed"], 422);
            }
        }

        $xref->fill($request->all());
        $xref->createdBy = $request->user()->email;
        $xref->save();

        if (isset($request->units)) {
            $xref->units()->createMany($request->units);
        }

        if (isset($request->calls)) {
            $xref->calls()->createMany($request->calls);
        }

        return $xref;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Xref  $xref
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Xref $xref)
    {
        $xref->update($request->all());

        if (isset($request->units)) {
            $xref->units()->delete();
            $xref->units()->createMany($request->units);
        }

        if (isset($request->calls)) {
            $xref->calls()->delete();
            $xref->calls()->createMany($request->calls);
        }
        return $this->show($xref);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Xref  $xref
     * @return \Illuminate\Http\Response
     */
    public function destroy(Xref $xref)
    {
        $xref->delete();
        return response()->json(null, 204);
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Xref::where('name', 'like', '%' . $name . '%')->get();
    }
}
