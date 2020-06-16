<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DisallowDash;
use App\Rules\AllowedString;
use App\Rules\AllowedStringName;
use App\Rules\ValidBirthdate;
use App\Rules\RequiredIfNotEmpty;
use App\Rules\ValidRelasyonAge;
use App\Rules\ValidCellphoneNumber;
use App\Rules\MustHaveAlpha;
use App\Models\HouseholdHead;

class HouseholdHeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'first_name' => ['required', new DisallowDash, new AllowedStringName,'min:2','max:40', new MustHaveAlpha],
            'middle_name' => [new AllowedStringName, new DisallowDash,'max:40', new MustHaveAlpha],
            'last_name' => ['required', new DisallowDash, new AllowedStringName,'min:2','max:40', new MustHaveAlpha],
            'ext_name' => [new AllowedStringName, new DisallowDash,'max:40', new MustHaveAlpha],
            'kasarian' => ['required','max:1'],
            'barangay_id' => ['required'],
            'tirahan' => ['required', new AllowedString,'max:100', new MustHaveAlpha],
            'kalye' => ['required', new AllowedString,'max:100', new MustHaveAlpha],
            'cellphone_number' => ['required', new AllowedString, new ValidCellphoneNumber],
            'uri_ng_id' => ['required', new AllowedString,'max:80'],
            'numero_ng_id' => ['required', new AllowedString,'max:80', new MustHaveAlpha],
            'kapanganakan' => ['required', new ValidBirthdate],
            'trabaho' => ['required', new AllowedString, new RequiredIfNotEmpty('pinagtratrabahuhang_lugar'),'max:60', new MustHaveAlpha],
            'buwanang_kita' => ['required','numeric', new MustHaveAlpha],
            'pinagtratrabahuhang_lugar' => ['required', new RequiredIfNotEmpty('trabaho'), new AllowedString,'max:80', new MustHaveAlpha],
            'sektor' => ['required', new AllowedString,'max:80'],
            'kondisyon_ng_kalusugan' => ['required', new AllowedString,'max:80'],
            'bene_uct' => ['required', new AllowedString,'max:80'],
            'bene_4ps' => ['required', new AllowedString,'max:80'],
            'katutubo' => ['required', new RequiredIfNotEmpty('katutubo_name'), new AllowedString,'max:80'],
            'katutubo_name' => ['required_if:katutubo,Y', new AllowedString,'max:80'],
            'bene_others' => ['required', new RequiredIfNotEmpty('others_name'), new AllowedString,'max:80', new MustHaveAlpha],
            'others_name' => ['required_if:bene_others,Y', new DisallowDash, new AllowedString,'max:80'],
            'petsa_ng_pagrehistro' => ['required', new ValidBirthdate, 'after_or_equal:2020-04-01', 'before_or_equal:2020-06-30'],
            'pangalan_ng_punong_barangay' => ['required', new DisallowDash, new AllowedStringName,'max:80', new MustHaveAlpha],
            'pangalan_ng_lswdo' => ['required', new AllowedStringName,'max:80', new MustHaveAlpha],
            'barcode_number' => ['required'],
            'sac_number' => ['required','numeric'],
        ];

        if(request()->has('members')){
			$members = request('members');
			foreach ($members as $key => $member) {
				$rules["members.$key.first_name"] = ['required',new DisallowDash,new AllowedStringName,'max:40', new MustHaveAlpha];
				$rules["members.$key.middle_name"] = [new DisallowDash,new AllowedStringName,'max:40', new MustHaveAlpha];
				$rules["members.$key.last_name"] = ['required',new DisallowDash,new AllowedStringName,'max:40', new MustHaveAlpha];
				$rules["members.$key.ext_name"] = [new DisallowDash,new AllowedStringName,'max:40', new MustHaveAlpha];
				$rules["members.$key.relasyon_sa_punong_pamilya"] = ['required',new ValidRelasyonAge($key),new AllowedString,'max:100'];
				$rules["members.$key.kasarian"] = ['required','max:1'];
				$rules["members.$key.kapanganakan"] = ['required', new ValidBirthdate];
				$rules["members.$key.trabaho"] = ['required',new AllowedString,'max:60', new MustHaveAlpha];
				$rules["members.$key.pinagtratrabahuhang_lugar"] = [new AllowedString,'max:80'];
				$rules["members.$key.sektor"] = ['required',new AllowedString,'max:80'];
				$rules["members.$key.kondisyon_ng_kalusugan"] = ['required',new AllowedString,'max:80'];
			}
        }
        
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'barangay.required' => 'Please select Barangay',
            'petsa_ng_pagrehistro.after_or_equal' => "Petsa ng Pagrerehistro' field month should be April, May or June 2020 only",
            'petsa_ng_pagrehistro.before_or_equal' => "Petsa ng Pagrerehistro' field month should be April, May or June 2020 only",
            'barcode_number.unique' => "The :attribute is already added.",
        ];

        if(request()->has('members')){
			$members = request('members');
			foreach ($members as $key => $member) {
				$messages["members.$key.first_name.required"] = "Required";
				$messages["members.$key.last_name.required"] = "Required";
				$messages["members.$key.relasyon_sa_punong_pamilya.required"] = "Required";
				$messages["members.$key.kasarian.required"] = "Required";
				$messages["members.$key.kapanganakan.required"] = "Required";
				$messages["members.$key.trabaho.required"] = "Required";
				$messages["members.$key.sektor.required"] = "Required";
				$messages["members.$key.kondisyon_ng_kalusugan.required"] = "Required";
			}
        }

        return $messages;
    }

    public function withValidator($validator)
    {
        $id = null;
        if(request()->has('id')){
            $id = request('id');
        }
        $validator->after(function ($validator) use ($id) {
            if(request()->has('age')){
                if(request('age') < 12){
                    $validator->errors()->add("age", "Must be 12 years old and above.");
                }
            }
            if(request()->has('sac_number')){
                if(strlen(request('sac_number')) > 8){
                    $validator->errors()->add("sac_number", "The sac number must not exceed 8 characters.");
                }
            }
            if(request()->has('barcode_number')){
                $barcode_number = request("barcode_number");
                $household_head = HouseholdHead::whereBarcodeNumber($barcode_number);
                if($id != null){
                    $household_head->where("id","<>", $id);
                }
                $household_head = $household_head->first();
                if($household_head != null){
                    $last_name = $household_head->last_name;
                    $first_name = $household_head->first_name;
                    $middle_name = $household_head->middle_name;
                    $validator->errors()->add("barcode_number", "Already belongs to $last_name, $first_name $middle_name");
                }
            }
        });
    }

}
