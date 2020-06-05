<?php

namespace App\Http\Controllers;

use App\Models\HouseholdHead;
use Illuminate\Http\Request;
use App\Http\Requests\HouseholdHeadRequest;

class HouseholdHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HouseholdHead  $householdHead
     * @return \Illuminate\Http\Response
     */
    public function show(HouseholdHead $householdHead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HouseholdHead  $householdHead
     * @return \Illuminate\Http\Response
     */
    public function edit(HouseholdHead $householdHead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HouseholdHead  $householdHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HouseholdHead $householdHead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HouseholdHead  $householdHead
     * @return \Illuminate\Http\Response
     */
    public function destroy(HouseholdHead $householdHead)
    {
        //
    }
}
