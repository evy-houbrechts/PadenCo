<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VrijwilligerMail;  

//pagina's padenco
class VrijwilligerController extends Controller
{ //pagina vijwilligers
    public function index()
    {
        return view("vrijwilliger.index");
    }
//pagina help je mee?
    public function form()
    {
        return view("vrijwilliger.form");
    }
//formulier - help je mee?
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'telefoonnummer' => [
                'required',
                'regex:/^(?:\+32|0)4[0-9]{8}$/'
            ],
            'bericht' => 'string|max:255'
        ]);
        Mail::to('made4animals@gmail.com')->send(new VrijwilligerMail($request->all()));

        return redirect()->route('vrijwilliger.form')->with('success', 'Bedankt voor je inzending! We nemen contact met je op.');
    }
//pagina soorten
    public function soorten()
    {
        return view("vrijwilliger.soorten");
    }

}
