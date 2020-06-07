<?php

namespace App\Http\Controllers;

use App\Models\HouseholdHead;
use App\Models\HouseholdMember;
use Illuminate\Http\Request;
use App\Http\Requests\HouseholdHeadRequest;
use DB;
use Auth;
use App\Transformers\HouseholdHeadTransformer;


class HouseholdHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $household_heads = HouseholdHead::with('members','barangay');
        if(Auth::user()->role == "user"){
            $household_heads->where('user_id',Auth::user()->id);
        }
        $household_heads = $household_heads->paginate(10);
        return [
            'household_heads' => fractal($household_heads, new HouseholdHeadTransformer)->parseIncludes('barangay,members')->toArray()
        ];
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
    public function store(HouseholdHeadRequest $request)
    {
        DB::beginTransaction();
        try{
            $hhead = HouseholdHead::create($request->all());
            if($request->members){
                if($request->members != array()){
                    $members = $request->members;
                    $members_data = array();
                    foreach ($members as $key => $value) {
                        $members_data[] = new HouseholdMember($value);
                    }
                    $hhead->members()->saveMany($members_data);
                }
            }
            $hhead->user_id = Auth::user()->id;
            $hhead->save();
            DB::commit();
        }
        catch(\Exception $e){DB::rollback();throw $e;}
        return $hhead;
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
    public function update(HouseholdHeadRequest $request, HouseholdHead $householdHead, $id)
    {
        DB::beginTransaction();
        try{
            $hhead = $householdHead->find($id);
            if ($request->members && $request->members != array()) {
                foreach ($request->members as $member) {
                    $hmember = HouseholdMember::find($member['id']);
                    $hmember->update($member);
                }
            }
            $hhead->update($request->all());
                DB::commit();
            }
        catch(\Exception $e){DB::rollback();throw $e;}
        return $householdHead->find($id);
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
