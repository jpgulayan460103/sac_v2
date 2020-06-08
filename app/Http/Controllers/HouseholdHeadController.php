<?php

namespace App\Http\Controllers;

use App\Models\HouseholdHead;
use App\Models\HouseholdMember;
use Illuminate\Http\Request;
use App\Http\Requests\HouseholdHeadRequest;
use DB;
use Auth;
use App\Transformers\HouseholdHeadTransformer;
use App\Transformers\ExportHouseholdHeadTransformer;
use App\Transformers\ExportHouseholdMemberTransformer;
use Carbon\Carbon;
use League\Csv\Writer;
use App\Exports\HouseholdHeadExport;
use Maatwebsite\Excel\Facades\Excel;


class HouseholdHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $household_heads = HouseholdHead::with('members','barangay','user');
        if(Auth::user()->role == "user"){
            $household_heads->where('user_id',Auth::user()->id);
        }
        $date_now = Carbon::now()->format('Y-m-d');
        $date_now = Carbon::parse($date_now);
        $start_date = $date_now->toDateTimeString();
        $date_tommorow = $date_now->addDay(1);
        $end_date = $date_tommorow->subSecond();
        $end_date = $end_date->toDateTimeString();
        $household_heads->wherebetween('created_at',[$start_date, $end_date]);
        $household_heads = $household_heads->get();
        return [
            'household_heads' => fractal($household_heads, new HouseholdHeadTransformer)->parseIncludes('barangay,members,user')->toArray()
        ];
    }

    public function export(Request $request)
    {
        $headers = [
            'Row Indicator *',
            'Barcode *',
            'Last Name *',
            'First Name *',
            'Middle Name',
            'Ext',
            'Rel HH *',
            'Kapanganakan (mm/dd/yy) *',
            'Kasarian *',
            'Trabaho * ( - for None)',
            'Sektor *',
            'Kondisyon ng Kalusugan *',
            'PSGC Barangay Code *',
            'Tirahan *',
            'Kalye *',
            'Uri Ng ID *',
            'Numero ng ID *',
            'Buwanang Kita * (For HH Head Only)',
            'Cellphone Number (+09XXXXXXXX) *',
            'Pinagtratrabahuhang Lugar  * ( - for None)',
            'Bene_UCT *',
            'Bene_4ps *',
            'Katutubo *',
            'Katutubo  Name *',
            'Bene_others *',
            'Others Name',
            'Petsa ng Pagrehistro *',
            'Pangalan ng Punong Barangay *',
            'Pangalan ng LSWDO *',
            'SAC',
            'Remarks',
            'Created on',
            'Created by',
        ];
        $to_export = $this->index();
        $for_export = [];
        $for_export[] = $headers;
        $households =  $to_export['household_heads']['data'];
        foreach ($households as $value) {
            $head = fractal([$value], new ExportHouseholdHeadTransformer)->toArray();
            $for_export[] = $head['data'][0];
            if($value['members']['data'] != array()){
                foreach ($value['members']['data'] as $member) {
                    $member['barcode_number'] = $value['barcode_number'];
                    $member['barangay_psgc'] = $value['barangay']['barangay_psgc'];
                    $member['city_name'] = $value['barangay']['city_name'];
                    $member['petsa_ng_pagrehistro'] = $value['petsa_ng_pagrehistro'];
                    $member['pangalan_ng_punong_barangay'] = $value['pangalan_ng_punong_barangay'];
                    $member['pangalan_ng_lswdo'] = $value['pangalan_ng_lswdo'];
                    $member['sac_number'] = $value['sac_number'];
                    $member['created_at'] = $value['created_at'];
                    $member['remarks'] = $value['remarks'];
                    $member['username'] = $value['user']['username'];
                    $member = fractal([$member],new ExportHouseholdMemberTransformer)->toArray();
                    $for_export[] = $member['data'][0];
                }
            }
        }
        $datetime = Carbon::now();
        $filename = "sac-forms-".$datetime->toDateString()."-".$datetime->format('H-i-s');
        ob_end_clean();
        ob_start();
        Excel::store(new HouseholdHeadExport($for_export), "$filename.xlsx", 'public');
        $url = \Storage::url("$filename.xlsx");
        return [
            'filename' => $url
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
    public function destroy(HouseholdHead $householdHead, $id)
    {
        $householdHead->findOrFail($id)->delete();
    }

    public function test(Request $request)
    {
        $date_now = Carbon::now()->format('m-d-Y');
        $start_date = Carbon::parse($date_now);
        $date_tommorow = $start_date->addDay(1);
        $end_date = $date_tommorow->subSecond();
        return $end_date;
    }
}
