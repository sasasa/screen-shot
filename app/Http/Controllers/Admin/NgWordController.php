<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNgWordRequest;
use App\Http\Requests\UpdateNgWordRequest;
use App\Models\NgWord;
use App\Usecases\NgWordCreate;

class NgWordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ng_words.index', [
            'ng_words' => NgWord::paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ng_words.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNgWordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNgWordRequest $request, NgWordCreate $usecase)
    {
        $ngWord = $usecase($request->validated());
        return redirect()->route('system_admin.ng_words.index')->with([
            'status' => "success",
            'message' => "{$ngWord->word} を追加しました。",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NgWord  $ngWord
     * @return \Illuminate\Http\Response
     */
    public function show(NgWord $ngWord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NgWord  $ngWord
     * @return \Illuminate\Http\Response
     */
    public function edit(NgWord $ngWord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNgWordRequest  $request
     * @param  \App\Models\NgWord  $ngWord
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNgWordRequest $request, NgWord $ngWord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NgWord  $ngWord
     * @return \Illuminate\Http\Response
     */
    public function destroy(NgWord $ngWord)
    {
        $ngWord->delete();
        return redirect()->route('system_admin.ng_words.index')->with([
            'status' => "success",
            'message' => "{$ngWord->word} を削除しました。",
        ]);
    }
}
