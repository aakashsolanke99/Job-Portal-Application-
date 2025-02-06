<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(request('tags'));
        return view('listings.index', [
                    'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(4)
                ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $companies = Company::pluck('company_name', 'id');
 
    return view('listings.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       
    //    dd($formFields);
        $request['company'] = Company::find($request->company_id)->company_name;
        if(is_null($request['tags'])){
           $request['tags']='';
        }else{
            $request['tags'] = implode(', ', $request['tags']);
        }
       
        dd($request);
        $formFields = $request->validate([
            'title'=>'required',
            'company'=>'required',
            'location'=>'required',
            'tags'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'description'=>'required'

        ]);
       
        $formFields['company_id'] = $request->company_id;
     

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');

        }

        $formFields['user_id'] = auth()->id();
        

        Listing::create($formFields);

        return redirect('/')->with('message','Job Listing Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' =>$listing]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        if($listing->user_id !=  auth()->id()){
            abort(403, 'unathorized access');
        }

        $formFields = $request->validate([
            'title'=>'required',
            'company'=>'required',
            'location'=>'required',
            'tags'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'description'=>'required'

        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');

        }

        $listing->update($formFields);

        return back()->with('message','Job Listing Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        if($listing->user_id !=  auth()->id()){
            abort(403, 'unathorized access');
        }

        $listing->delete();
        return redirect('/')->with('message', 'listing deleted successfully');
    }

    public function manage(Listing $listing)
    {
       
        return view('listings.manage', ['listings'=>auth()->user()->listings()->get()]);
    }
}
