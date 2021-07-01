<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
   

    public function getClient()
    {
        $client =Client::OrderBy('id', 'DESC')->get();
        return response()->json($client);

    }
    public function StoreClient(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'email' =>'required|unique:clients,email',
            'document' =>'required',
            'addres' =>'required'
         ]);

         $client = new Client($request->all());
         $client->save();
         return response()->json($client);

    }
    public function UpdateClient(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'email' =>'required|unique:clients,email,'.$request->id,
            'document' =>'required',
            'addres' =>'required'
         ]);
         $client = Client::findOrFail($request->id);
         $client->update($request->all());
       
        return response()->json($client);

    }
    public function destroy(Request $request )
    {
        $client = Client::find($request->id);
        $client->delete();
    }
}
