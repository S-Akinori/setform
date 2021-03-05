<?php

namespace App\Http\Controllers;

use App\Models\FormAnswer;
use App\Models\FormMaster;
use Illuminate\Http\Request;

class FormController extends Controller
{
    // 6a44a5bfa3c7bf4cda3f06ebc649e0db
    public function show($key) {
        $form = FormMaster::where('key', $key)->first();
        $form->formats = json_decode($form->formats, true);
        // dd($form->formats);

        return view('form.show', ['form'=>$form]);
    }

    public function showAnswer($id) {
        $form_answer = FormAnswer::findOrFail($id);
        $form_answer->answers = json_decode($form_answer->answers, true);

        return view('form.show_answers', ['form_answer'=>$form_answer]);
    }

    public function store(Request $request) {
        $key = md5(uniqid());
        $form = FormMaster::create([
            'formats' => $request->formats,
            'key'=>$key,
        ]);

        return redirect()->route('form.show', $form->id);
    }

    public function storeAnswers(Request $request) {
        $form = FormMaster::findOrFail($request->id);
        $formats = json_decode($form->formats, true);
        $titles = [];
        foreach($formats as $item => $value) {
            $titles[] = $value['title'];
        }

        $answers = $request->all();
        $i = 0;
        
        $data = [];
        foreach($answers as $answer => $value) {
            if($answer == '_token' || $answer == 'id') continue;

            $data += [
                $titles[$i] => $value,
            ];
            $i++;
        }

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);

        FormAnswer::create([
            'form_id' => $request->id,
            'answers' => $data,
        ]);

        return view('form.thankyou');

    }
}
