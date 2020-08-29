<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Auth;
use App\Alert;
use App\User;
use Session;
use Illuminate\Support\Facades\Hash;


class ProfileController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->data[ 'page_title' ]          = 'PROFIL';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user       = Auth::user() ;
        $user->role = $user->roles[0]->id;
        $user->role_name = $user->roles[0]->role_name;
        // dd( $user->roles );
        $detail     = view('layouts.templates.forms.form_fields_readonly', [ 'formFields' => User::getFormData( FALSE ), 'data'=> $user ] );

        $linkEdit['url']        = route('profiles.edit', $user->id);
        $linkEdit['linkName']   = 'Edit';
        $linkEdit               = view('layouts.templates.tables.actions.link', $linkEdit);

        
        $this->data[ 'contents' ]            = $detail.'<br>'.$linkEdit;

        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'header' ]              = $user->name;
        $this->data[ 'sub_header' ]          = '';
        return $this->render(  );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        
        $user       = Auth::user() ;
        $user->role = $user->roles[0]->id;
        $user->role_name = $user->roles[0]->role_name;
        // dd( $user->roles );
        $detail     = view('layouts.templates.forms.form_fields_readonly', [ 'formFields' => User::getFormData( FALSE ), 'data'=> $user ] );

        $linkEdit['url']        = route('profiles.edit', $user->id);
        $linkEdit['linkName']   = 'Edit';
        $linkEdit               = view('layouts.templates.tables.actions.link', $linkEdit);

        
        $this->data[ 'contents' ]            = $detail.'<br>'.$linkEdit;

        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'header' ]              = $user->name;
        $this->data[ 'sub_header' ]          = '';
        return $this->render(  );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user       = Auth::user() ;
        $user->role = $user->roles[0]->id;
        $user->role_name = $user->roles[0]->role_name;
      
        $form[ 'formUrl' ]      = route('profiles.update', $user->id);
        $form[ 'formMethod' ]   = 'post';
        $form[ 'blank' ]        = 'blank';
        $formFields = User::getFormData(  );
        unset( $formFields['role'] );
        $formFields["_method"] = [
            'type' => 'hidden',
            'value' => "PUT"
        ];
        $form[ 'content' ]      = view('layouts.templates.forms.form_fields', [ 'formFields' => $formFields , 'data'=> $user ] );
        $form                   = view('layouts.templates.forms.form', $form );
        
        $this->data[ 'contents' ]            = $form ;
        
        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'header' ]              = 'edit '.$user->name;
        $this->data[ 'sub_header' ]          = '';
        return $this->render(  );
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
        $validationConfig = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
       
        $user       = Auth::user() ;
        if( $request->input('email') != $user->email )
            $validationConfig[ 'email' ] []= 'unique:users';

        if( $request->input('_password') != NULL )
        {
            $validationConfig[ '_password' ] = ['required', 'string', 'min:5', 'confirmed'];
        }
        
        $request->validate( $validationConfig );
        
        $data = [
            'name' =>  $request->input('name'),
            'email' =>  $request->input('email'),
        ];
        if( $request->input('_password') != NULL )
        {
            Auth::logout();
            $data['password'] = Hash::make( $request->input('_password') );
        }

        $user->update( $data );

        return redirect()->route('profiles.show', $id )->with(['message' => Alert::setAlert( 1, "data berhasil di edit" ) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
