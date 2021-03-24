<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FormAnswer;
use App\Models\FormMaster;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $form_answer = FormAnswer::findOrFail(1);

        return $form_answer->answers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form_key = md5(uniqid());
        $answer_key = md5(uniqid());
        $form = FormMaster::create([
            'formats' => json_encode($request->formats, JSON_UNESCAPED_UNICODE),
            'form_key'=>$form_key,
            'answer_key'=>$answer_key,
        ]);

        return $form;
    }

    public function storeAnswers(Request $request) {
        $answers = FormAnswer::create([
            'form_id'=>$request->form_id,
            'answers'=>json_encode($request->answers, JSON_UNESCAPED_UNICODE)
        ]);

        return $answers;
    }

    public function storeFiles(Request $request) {
        $path = 'public/files/' . $request->form_key;
        $file_paths = [];

        foreach ($request->file('files') as $key => $value) {
            $file_path = $value->store($path);
            $file_path = url('/') . '/' . $file_path;
            $file_path = str_replace('public', 'storage', $file_path);
            $file_paths[$request->ids[$key]] =  $file_path;
            // $file_paths[] = [$request->ids[$key] => $file_path];
        }

        return $file_paths;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        $form = FormMaster::where('form_key', $key)->first();
        // dd($form->formats);

        return $form;
    }

    public function showAnswers($key) {
        $form_id = FormMaster::where('answer_key', $key)->value('id');
        $form_answers = FormAnswer::where('form_id', $form_id)->get();

        return $form_answers;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $form = FormMaster::where('form_key', $request->form_key)->where('answer_key', $request->answer_key)->get();
        $answers = FormAnswer::where('form_id', $form->id)->get();

        $form->delete();
        $answers->delete();

        return $request->all();

    }
}
