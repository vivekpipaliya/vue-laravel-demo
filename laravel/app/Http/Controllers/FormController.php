<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'phone_number' => 'required',
            'zipcode' => 'required|max:5',
        ]);

        if ($validator->fails()) {
            return $validator->messages()->first();
        }
        $document = '';
        if($request->document != 'null') {
            $imageName = time().'.'.$request->document->getClientOriginalExtension();
            $request->document->move(public_path('/document'), $imageName);
            $document = $imageName;
        } else {
            $document = '';
        }

        $address = $request->address ? $request->address : '';
        
        $form = new Form;
        $form->name = $request->name;
        $form->email = $request->email;
        $form->phone_number = $request->phone_number;
        $form->address = $address;
        $form->zipcode = $request->zipcode;
        $form->document = $document;
        $form->save();
        return "Form submitted!";

    }

}
