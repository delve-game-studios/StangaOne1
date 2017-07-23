<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
USE App\Http\Requests\StoreWordRequest;
use Excel;

class WordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $words = Word::paginate(20);
        return view('words.index', compact('words'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('words.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWordRequest $request)
    {
        Word::create($request->all());
        return redirect()->route('words.index')->with(['message' => 'Word added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $word = Word::findOrFail($id);
        return view('words.edit', compact('word'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreWordRequest $request, $id)
    {
        $word = Word::findOrFail($id);
        $word->update($request->all());
        return redirect()->route('words.index')->with(['message' => 'word updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $word = Word::findOrFail($id);
        $word->delete();
        return back()->with(['message' => 'Word deleted successfully']);
    }

        /**
     * Return View file
     *
     * @var array
     */
    public function importExport()
    {
        return view('words.importExport');
    }

    /**
     * File Export Code
     *
     * @var array
     */
    public function downloadExcel(Request $request, $type)
    {
        $data = Word::get()->toArray();
        return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
            $excel->sheet('words', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    /**
     * Import file into database Code
     *
     * @var array
     */
    public function importExcel(Request $request)
    {

        if($request->hasFile('import_file')){
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function($reader) {})->get();

            if(!empty($data) && $data->count()){
                // var_dump($data);exit;
                foreach ($data->toArray() as $key => $value) {
                    if(!empty($value)){
                        $insert[$value['word']] = ['word' => $value['word'], 'meaning' => $value['meaning']];

                        if(empty($insert[$value['word']]['created_at'])) {
                            $insert[$value['word']]['created_at'] = date('Y-m-d H:i:s');
                        }
                        if(empty($insert[$value['word']]['updated_at'])) {
                            $insert[$value['word']]['updated_at'] = date('Y-m-d H:i:s');
                        }
                    }
                }

                if(!empty($insert)){
                    Word::insert($insert);
                    return redirect()->route('words.index')->with(['message' => 'Words imported successfully']);
                }

            }

        }

        return back()->with('error','Please Check your file, Something is wrong there.');
    }

    public function massDestroy(Request $request)
    {
        $words = explode(',', $request->input('ids'));
        foreach ($words as $word_id) {
            $word = Word::findOrFail($word_id);
            $word->delete();
        }
        return redirect()->route('words.index')->with(['message' => 'Words deleted successfully']);
    }
}
