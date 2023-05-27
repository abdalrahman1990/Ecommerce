<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;

class ContactController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ContactController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for displaying a list of contact messages,
    | updating and deleting those messages.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = null;
        if($request->search){
       
            $search = $request->search;
            $option = ($request->option) ? : 'first_name';
            $contacts = Contact::where($option,'LIKE','%'.$search.'%')->paginate(10);    
            $title = "Showing results by {$option} for \"{$search}\"";
        
        }else{
            $contacts = Contact::orderBy('created_at','desc')->paginate(10);
        }

        return view('admin.contacts.index',[
            'contacts' => $contacts,
            'title'    => $title
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->showContact($id,'show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->showContact($id,'edit');
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
        $this->validateContact($request);
        $contact = Contact::findOrFail($id);
        
        if($request->first_name){
            $contact->first_name = $request->first_name;
        }

        if($request->last_name){
            $contact->last_name = $request->last_name;
        }

        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();
        
        return redirect()
            ->route('admin.contacts.index')
            ->with('status','Selected contact message has been updated!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        
        $contact->delete();
        
        return redirect()
            ->route('admin.contacts.index')
            ->with('status','Selected contact message has been deleted!');
        
    }

    /**
     * Show details of a specific contact message.
     * 
     * @param int $id
     * @param string $view
     * @return \Illuminate\Http\Response
     */
    private function showContact($id,$view){
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.'.$view,[
            'contact' => $contact
        ]);
    }

    /**
     * Validate the request
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function validateContact(Request $request){

        $rules = $this->rules();

        $messages = $this->messages();

        $this->validate($request,$rules,$messages);
    }

    /**
     * Validation rules.
     * 
     * @return array
     */
    private function rules(){
        $message = "/^[a-zA-Z0-9 ]+$/";
        $name = "/^[a-zA-Z ]+$/";

        return [
            'first_name' => "nullable|regex:{$name}|min:3|max:50",
            'last_name'  => "nullable|regex:{$name}|min:3|max:50",
            'email'      => 'required|email|min:5|max:150',
            'message'    => "required|regex:{$message}|min:20|max:1500",
        ];
    }
    
    /**
     * Validation messages.
     * 
     * @return array
     */
    private function messages(){
        return [
            'first_name.regex' => 'Only letters and spaces are allowed',
            'last_name.regex' => 'Only letters and spaces are allowed',
            'message.regex' => 'Only letters, spaces, and numbers are allowed'
        ];
    }
}
