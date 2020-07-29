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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class HouseholdHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $household_heads = HouseholdHead::with('members','barangay','user');
        $household_heads->select('household_heads.*');
        $household_heads->addSelect('barangays.barangay_psgc');
        $household_heads->addSelect('barangays.province_psgc');
        $household_heads->addSelect('barangays.city_psgc');
        $household_heads->leftJoin('barangays', 'household_heads.barangay_id', '=', 'barangays.id');
        if(Auth::user()->role == "user"){
            $household_heads->where('user_id',Auth::user()->id);
        }else{
            if($request->user_id){
                $household_heads->where('user_id',$request->user_id);
            }
        }
        $key = request('query');
        if ($key){
            $household_heads->where(function ($query) use ($key) {
                $query->where('first_name','like',"%$key%");
                $query->orWhere('middle_name','like',"%$key%");
                $query->orWhere('barcode_number','like',"%$key%");
                $query->orWhere('last_name','like',"%$key%");
            });
        }else{
            if($request->startDate){
                $start_date = Carbon::parse($request->startDate)->toDateTimeString();
                $end_date = Carbon::parse($request->endDate)->addDay(1)->subSecond()->toDateTimeString();
            }else{
                $date_now = Carbon::now()->format('Y-m-d');
                $date_now = Carbon::parse($date_now);
                $start_date = $date_now->toDateTimeString();
                $date_tommorow = $date_now->addDay(1);
                $end_date = $date_tommorow->subSecond();
                $end_date = $end_date->toDateTimeString();
            }
            // return [$start_date, $end_date];
            $household_heads->wherebetween('household_heads.created_at',[$start_date, $end_date]);
        }
        if(request()->has('province_psgc') && request('province_psgc') != ""){
            $household_heads->where('province_psgc', request('province_psgc'));
        }
        if(request()->has('sap_type') && request('sap_type') != ""){
            $household_heads->where('sap_type', request('sap_type'));
        }
        if(request()->has('city_psgc') && request('city_psgc') != ""){
            $household_heads->where('city_psgc', request('city_psgc'));
        }
        if(request()->has('barangay_psgc') && request('barangay_psgc') != ""){
            $household_heads->where('barangay_psgc', request('barangay_psgc'));
        }
        if(request()->has('currentPage')){
            $per_page = 500;
        }else{
            $per_page = 50;
        }
        $household_heads = $household_heads->paginate($per_page);
        return [
            'household_heads' => fractal($household_heads, new HouseholdHeadTransformer)->parseIncludes('barangay,members,user')->toArray()
        ];
    }

    public function writeExport(Request $request)
    {
        $filename = $request->filename;
        $to_export = $this->index($request);
        $writer = Writer::createFromPath("storage/$filename", 'a+');
        $for_export = [];
        $households =  $to_export['household_heads']['data'];
        $total_pages =  $to_export['household_heads']['meta']['pagination']['total_pages'];
        $batch = $request->page;
        if($batch != 1){
            if($request->page % 2 == 0){
                $batch = $batch/2;
            }else{
                $batch = (($batch+1)/2);
            }
        }
        foreach ($households as $value) {
            $head = fractal([$value], new ExportHouseholdHeadTransformer)->toArray();
            $for_export = $head['data'][0];
            $for_export['batch'] = $batch;
            $data = array();
            foreach ($for_export as $export_data) {
                $data[] = mb_convert_encoding($export_data, 'UTF-16LE', 'UTF-8');
            }
            $writer->insertOne($data);
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
                    $member['username'] = $value['user']['name'];
                    $member['sap_type'] = $value['sap_type'];
                    $member = fractal([$member],new ExportHouseholdMemberTransformer)->toArray();
                    $for_export = $member['data'][0];
                    $for_export['batch'] = $batch;
                    $data = array();
                    foreach ($for_export as $export_data) {
                        $data[] = mb_convert_encoding($export_data, 'UTF-16LE', 'UTF-8');
                    }
                    $writer->insertOne($data);
                }
            }
        }
        return [
            'filename' => $filename,
            'total_pages' => $total_pages,
        ];
    }

    public function createExport(Request $request)
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
            'Encoded on',
            'Encoded by',
            'SAP Type',
            'Batch Upload',
        ];

        $datetime = Carbon::now();
        $filename = "sac-forms-".$datetime->toDateString()."-".$datetime->format('H-i-s').".csv";
        $writer = Writer::createFromPath("storage/$filename", 'w+');
        $writer->insertOne($headers);
        // $spreadsheet = new Spreadsheet();
        // $sheet = $spreadsheet->getActiveSheet()->fromArray($headers, NULL, 'A1');
        // $writer = new Xlsx($spreadsheet);
        $writer->save("storage/$filename");
        // $url = \Storage::url("$filename");
        return [
            'filename' => $filename,
            'path' => $url
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
            $hhead->update($request->all());
            $hhead = $householdHead->find($id);
            $members = array();
            $roster_ids_form = array();
            $roster_ids = HouseholdMember::where('household_head_id',$request->id)->pluck('id')->toArray();
            foreach ($request->members as $key => $member) {
                if(isset($member['id'])){
                    HouseholdMember::find($member['id'])->update($member);
                    $roster_ids_form[] = $member['id']; 
                }else{
                    $members[$key] = new HouseholdMember($member);
                    $members[$key]->household_head_id = $hhead->id;
                    $members[$key]->save();
                }
            }
            $removed_roster_ids = array_diff($roster_ids,$roster_ids_form);
            HouseholdMember::whereIn('id', $removed_roster_ids)->delete();
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

    public function listTrabaho(Type $var = null)
    {
        $heads = HouseholdHead::select('trabaho')->distinct()->orderBy('trabaho')->pluck('trabaho')->toArray();
        $members = HouseholdMember::select('trabaho')->distinct()->orderBy('trabaho')->pluck('trabaho')->toArray();
        $trabaho = array_merge($heads,$members);
        $trabaho = array_map(function($item){
            return removeFirstCharDash($item);
        }, $trabaho);
        $trabaho = array_values(array_unique($trabaho));
        return [
            'trabaho' => $trabaho
        ];
    }
}
