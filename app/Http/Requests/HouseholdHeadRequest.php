<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DisallowDash;
use App\Rules\AllowedString;
use App\Rules\AllowedStringName;
use App\Rules\ValidBirthdate;
use App\Rules\RequiredIfNotEmpty;
use App\Rules\ValidRelasyonAge;

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
        $id = null;
        if(request()->has('id')){
            $id = request('id');
        }
        $rules = [
            'first_name' => ['required', new DisallowDash, new AllowedStringName,'min:2','max:100'],
            'middle_name' => [new AllowedStringName, new DisallowDash,'max:100'],
            'last_name' => ['required', new DisallowDash, new AllowedStringName,'min:2','max:100'],
            'ext_name' => [new AllowedStringName, new DisallowDash,'max:100'],
            'kasarian' => ['required','max:1'],
            'barangay' => ['required'],
            'tirahan' => ['required', new AllowedString,'max:200'],
            'kalye' => ['required', new AllowedString,'max:200'],
            'cellphone_number' => ['required', new AllowedString],
            'uri_ng_id' => ['required', new AllowedString,'max:200'],
            'numero_ng_id' => ['required', new AllowedString,'max:200'],
            'kapanganakan' => ['required', new ValidBirthdate],
            'trabaho' => ['required', new AllowedString, new RequiredIfNotEmpty('pinagtratrabahuhang_lugar'),'max:200'],
            'buwanang_kita' => ['required','numeric'],
            'pinagtratrabahuhang_lugar' => ['required', new RequiredIfNotEmpty('trabaho'), new AllowedString,'max:200'],
            'sektor' => ['required', new AllowedString,'max:200'],
            'kondisyon_ng_kalusugan' => ['required', new AllowedString,'max:200'],
            'bene_uct' => ['required', new AllowedString,'max:200'],
            'bene_4ps' => ['required', new AllowedString,'max:200'],
            'katutubo' => ['required', new RequiredIfNotEmpty('katutubo_name'), new AllowedString,'max:200'],
            'katutubo_name' => ['required_if:katutubo,Y', new AllowedString,'max:200'],
            'bene_others' => ['required', new RequiredIfNotEmpty('others_name'), new AllowedString,'max:200'],
            'others_name' => ['required_if:bene_others,Y', new DisallowDash, new AllowedString,'max:200'],
            'petsa_ng_pagrehistro' => ['required', new ValidBirthdate, 'after_or_equal:2020-04-01', 'before_or_equal:2020-06-30'],
            'pangalan_ng_punong_barangay' => ['required', new DisallowDash, new AllowedStringName,'max:200'],
            'pangalan_ng_lswdo' => ['required', new DisallowDash, new AllowedStringName,'max:200'],
            'sac_number' => ['required','numeric','unique:household_heads,sac_number,'.$id.',id'],
        ];

        if(request()->has('members')){
			$members = request('members');
			foreach ($members as $key => $member) {
				$rules["members.$key.first_name"] = ['required',new DisallowDash,new AllowedStringName,'max:100'];
				$rules["members.$key.middle_name"] = [new DisallowDash,new AllowedStringName,'max:100'];
				$rules["members.$key.last_name"] = ['required',new DisallowDash,new AllowedStringName,'max:100'];
				$rules["members.$key.ext_name"] = [new DisallowDash,new AllowedStringName,'max:100'];
				$rules["members.$key.relasyon_sa_punong_pamilya"] = ['required',new ValidRelasyonAge($key),new AllowedString,'max:100'];
				$rules["members.$key.kasarian"] = ['required','max:1'];
				$rules["members.$key.kapanganakan"] = ['required', new ValidBirthdate];
				$rules["members.$key.trabaho"] = ['required',new AllowedString,'max:200'];
				$rules["members.$key.pinagtratrabahuhang_lugar"] = [new AllowedString,'max:200'];
				$rules["members.$key.sektor"] = ['required',new AllowedString,'max:200'];
				$rules["members.$key.kondisyon_ng_kalusugan"] = ['required',new AllowedString,'max:200'];
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
        $validator->after(function ($validator) {
            if(request()->has('age')){
                if(request('age') < 12){
                    $validator->errors()->add("age", "Must be 12 years old and above.");
                }
            }
            if(request()->has('cellphone_number')){
                if(request('cellphone_number') != "-" && strlen(request('cellphone_number')) < 11){
                    $validator->errors()->add("cellphone_number", "The cellphone number must be 11 characters.");
                }
            }
            if(request()->has('sac_number')){
                if(strlen(request('sac_number')) > 8){
                    $validator->errors()->add("sac_number", "The sac number must not exceed 8 characters.");
                }
            }
        });
    }

}
