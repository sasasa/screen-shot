<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Mail\SendContactMail;
use App\Models\Contact;
use App\Models\Site;
use App\Models\User;
use App\Services\IpService;
use App\Usecases\FindOrCreateUserByCookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $user = $findOrCreateUserUseCase($request->cookie('userid'), IpService::getIp($request), $request->header('User-Agent'));
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
        // sleep(100);
        $user = $findOrCreateUserUseCase($request->cookie('userid'), IpService::getIp($request), $request->header('User-Agent'));
        $contact = Contact::create([
            'uuid' => $user->uuid,
            'site_id' => $request->site_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip' => IpService::getIp($request),
            'production_id' => Auth::guard('production')->id(),
        ]);
        Mail::to([
            'email' => 'masaakisaeki@gmail.com',
        ])->send(new SendContactMail($contact));

        $return_url = $request->return_url ?? route('sites.index');
        return redirect($return_url)->with([
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
