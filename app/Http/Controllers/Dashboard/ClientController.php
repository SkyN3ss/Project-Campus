<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserValidate;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use PDF;
use App\Client;
use App\Product;
use App\Fabricator;

class ClientController extends Controller
{

    /**
     * __construct
     *
     * @return Language selected in the application
     */

    public function __construct()
    {
        Carbon::setlocale(config('app.locale'));

        // middleware
        $this->middleware('permission:clients.index')->only('index');
        $this->middleware('permission:clients.create')->only('create');
        $this->middleware('permission:clients.edit')->only('edit');
        $this->middleware('permission:clients.update')->only('update');
        $this->middleware('permission:clients.destroy')->only('destroy');
        // pdf
        $this->middleware('permission:clients.pdf.view')->only('clientPDFview');


       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::orderBy('id', 'desc')->paginate(10);

        return view('dashboard.clients.index', compact('clients'));
    }

    public function search() 
    {
        $currentYear = Carbon::now()->year;
        $searchField =  Input::get('field');
        $searchInput =  Input::get('input');

        if (empty($searchInput)) {
            $clients = Client::orderBy('id', 'desc')->paginate(10);
        } else {
            $clients = Client::where($searchField, 'like', '%'. $searchInput .'%')
            ->orderBy('created_at', 'asc')
            ->paginate(500);
        }
            
        return view('dashboard.clients.index', compact('clients'));
    }

    public function create()
    {
        $clients = Client::get();

        return view('dashboard.clients.create', compact('clients'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
        ]);

        $newClient = ([
            'name' => $request->name,
            'rubro' => $request->rubro,
            'last_name' => $request->last_name, 
            'city' => $request->city, 
            'residency' => $request->residency, 
            'zone' => $request->zone,
            'phone' => $request->phone, 
            'fax' => $request->fax,  
            'email' => $request->email,
            'web_page' => $request->web_page,
            'id_user' => Auth::user()->id
            ]);

        $client = Client::create($newClient);

        return save_response($client, 'clients.index', 
            'Cliente creado éxitosamente!!!'
        ); 
    }

    public function storeFromProduct(Request $request)
    {

        $request->validate([
            'name' => 'required',
        ]);

        $newClient = ([
            'name' => $request->name,
            'rubro' => $request->rubro,
            'last_name' => $request->last_name, 
            'city' => $request->city, 
            'residency' => $request->residency, 
            'zone' => $request->zone,
            'phone' => $request->phone, 
            'fax' => $request->fax,  
            'email' => $request->email,
            'web_page' => $request->web_page,
            'id_user' => Auth::user()->id
            ]);

        $newClient = Client::create($newClient);
        $newFabricator = null;

        $products = Product::get();
        $clients = Client::all(['id', 'name']);
        $fabricators = Fabricator::all(['id', 'name']);

        return view('dashboard.products.create', compact('products', 'fabricators', 'clients', 'newClient', 'newFabricator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);

        return view('dashboard.clients.edit', compact('client'));
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
        $client = Client::find($id);

        $client->update([
            'name' => $request->name,
            'last_name' => $request->last_name, 
            'city' => $request->city, 
            'residency' => $request->residency, 
            'phone' => $request->phone, 
            'fax' => $request->fax,  
            'email' => $request->email,
            'rubro' => $request->rubro,
            'zone' => $request->zone,
            'web_page' => $request->web_page,
            ]);

        return save_response($client, 'clients.index', 
            'Empresa actualizada éxitosamente!!!'
        ); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        $client->delete();

        return save_response($client, 'clients.index', 
            'Empresa eliminada éxitosamente!!!'
        ); 
    }

    /**
     * userPDFview
     *
     * @return pdf generate
     */
    public function clientPDFview()
    {
        return view('dashboard.clients.pdf.index');
    }

    /**
     * userPDFreport
     *
     * @return pdf report all
     */
    public function AllclientPDF()
    {
        $clients = Client::all();

        $pdf = PDF::loadView('dashboard.clients.pdf.archive', compact('clients'));
        
        $pdf->output();
        
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf ->get_canvas();
        $canvas->page_text(10, 750, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 12, [0, 0, 0]);

        return $pdf->stream();
    }

    /**
     * userPDFreport
     *
     * @return pdf report whereDate
     */
    public function clientPDFreport(Request $request)
    {
        $this->validate($request, ['from' => 'required', 'to' => 'required']);

        $clients = Client::whereBetween('created_at', [$request->from, $request->to])->get();
        
        $pdf = PDF::loadView('dashboard.clients.pdf.archive', compact('clients'));
        
        $pdf->output();
        
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf ->get_canvas();
        $canvas->page_text(10, 750, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 12, [0, 0, 0]);

        return $pdf->stream();
    }

}
