<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\Site;
use App\Models\User;
use App\Usecases\FindOrCreateUserByCookie;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, FindOrCreateUserByCookie $findOrCreateUserUseCase)
    {
        $user = $findOrCreateUserUseCase($request->cookie('userid'));
        if($request->site_id) {
            $site = Site::find($request->site_id);
        }

        return response()->view('contact.create', [
            'site' => $site ?? null,
            'users_sites' => $user->sites->pluck('id')->toArray(),
        ])->cookie('userid', $user->uuid, 60*24*365*10, null, null, false, false);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request, FindOrCreateUserByCookie $findOrCreateUserUseCase)
    {
        $user = $findOrCreateUserUseCase($request->cookie('userid'));
        Contact::create([
            'uuid' => $user->uuid,
            'site_id' => $request->site_id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('sites.index')->with([
            'status' => "success",
            'message' => "ありがとうございました。お問い合わせを受け付けました。",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
