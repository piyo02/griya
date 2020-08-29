<?php

namespace App\Http\Controllers\S_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;

use Session;
use App\User;
use App\Model\Role;
use App\Alert;
use Auth;

class UsersManagementController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->data[ 'menu_id' ] = "users";

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table[ 'header' ]  = [ 
            'role_name' => 'Role',
            'name' => 'Nama',
            'email' => 'Email',
         ];
        $table[ 'number' ]  = 1;
        
        $users = User::select([ 'role_name','name', 'email', 'users.id as id' ])
                                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                                    ->where('users.id',"!=", Auth::user()->id );
        if( Auth::user()->roles()->first()->role_name != 'admin' )
        {
            $users = $users->where('roles.role_name',"!=", 'admin' );
            // $users = $users->where('roles.role_name',"!=", Auth::user()->roles()->first()->role_name );
        }
        

        $table[ 'rows' ]    = $users->get();
        $table[ 'action' ]  = [
            "link" => [
                "dataParam"     => "id",
                "linkName"      => "Detail",
                "url"           => url('users'),
                "buttonColor"   => "primary",
            ],//link
            "modal_delete" => [
                "modalId"       => "delete",
                "dataParam"     => "id",
                "modalTitle"    => "Hapus",
                "formUrl"       => url('users'),
                "formMethod"    => "post",
                "buttonColor"   => "danger",
                "formFields"    => [
                    '_method' => [
                        'type' => 'hidden',
                        'value'=> 'DELETE'
                    ],
                    'id' => [
                        'type' => 'hidden',
                    ],
                ],
            ],//modal_delete
        ];
        $table = view('layouts.templates.tables.plain_table', $table);

        $linkEdit['url']        = url('users/create');
        $linkEdit['linkName']   = 'Tambah User';
        $linkEdit               = view('layouts.templates.tables.actions.link', $linkEdit);
        $this->data[ 'header_button' ]       = $linkEdit;


        $this->data[ 'contents' ]            = $table;

        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'page_title' ]          = 'User management';
        $this->data[ 'header' ]              = 'List';
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
        // dd( $user->roles );
        $form[ 'formUrl' ]      = url('users');
        $form[ 'formMethod' ]   = 'post';
        $form[ 'blank' ]        = 'blank';
        $formFields = User::getFormData(  );
        unset( $formFields['_password'] );
        unset( $formFields['_password_confirmation'] );
        $form[ 'content' ]      = view('layouts.templates.forms.form_fields', [ 'formFields' => $formFields ] );
        $form                   = view('layouts.templates.forms.form', $form );
        
        $this->data[ 'contents' ]            = $form ;

        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'page_title' ]          = 'User management';
        $this->data[ 'header' ]              = 'Tambah User';
        $this->data[ 'sub_header' ]          = '';
        return $this->render(  );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationConfig = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ];
        
        $request->validate( $validationConfig );
        $user = User::create([
            'name'      =>  $request->input('name'),
            'email'     =>  $request->input('email'),
            'username'  =>  $request->input('email'),
            'password'  =>  Hash::make( substr( $request->input('email'), 0, strpos( $request->input('email') , "@" ) ) ) 
        ]);
        $user->putRole( Role::find( $request->input('role') ) );
        
        return redirect()->route('users.index' )->with(['message' => Alert::setAlert( 1, "data berhasil di buat, PASSWORD PERTAMA adalah nama email sampai '@' " ) ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $user       = User::findOrFail( $id );
        $user->role = $user->roles[0]->id;
        $user->role_name = $user->roles[0]->role_name;
        // dd( $user->roles );
        $detail     = view('layouts.templates.forms.form_fields_readonly', [ 'formFields' => User::getFormData( FALSE ), 'data'=> $user ] );

        $linkEdit['url']        = url('users').'/'. $user->id.'/edit';
        $linkEdit['linkName']   = 'Edit';
        $linkEdit               = view('layouts.templates.tables.actions.link', $linkEdit);

        
        $this->data[ 'contents' ]            = $detail.'<br>'.$linkEdit;

        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'page_title' ]          = 'User management';
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
        $user       = User::findOrFail( $id );
        $user->role = $user->roles[0]->id;
        $user->role_name = $user->roles[0]->role_name;
      
        $form[ 'formUrl' ]      = url('users').'/'. $user->id;
        $form[ 'formMethod' ]   = 'post';
        $form[ 'blank' ]        = 'blank';
        $formFields = User::getFormData(  );
        $formFields["_method"] = [
            'type' => 'hidden',
            'value' => "PUT"
        ];
        $form[ 'content' ]      = view('layouts.templates.forms.form_fields', [ 'formFields' => $formFields , 'data'=> $user ] );
        $form                   = view('layouts.templates.forms.form', $form );
        
        $this->data[ 'contents' ]            = $form ;
        
        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'page_title' ]          = 'User management';
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
        // dd( $request->input('_password') );
        $validationConfig = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
       
        $user       = User::findOrFail( $id );
        if( $request->input('email') != $user->email )
            $validationConfig[ 'email' ] []= 'unique:users';

        if( $request->input('_password') != NULL )
        {
            $validationConfig[ '_password' ] = ['required', 'string', 'min:4', 'confirmed'];
        }
        
        $request->validate( $validationConfig );
        
        $data = [
            'name' =>  $request->input('name'),
            'email' =>  $request->input('email'),
        ];
        if( $request->input('_password') != NULL )
            $data['password'] = Hash::make( $request->input('_password') );

        $user->update( $data );

        $user->forgetRole();
        $user->putRole( Role::find( $request->input('role') ) );

        return redirect()->route('users.show', $id )->with(['message' => Alert::setAlert( 1, "data berhasil di edit" ) ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user       = User::findOrFail( $id );
        $user->forgetRole();
        $user->delete();
        return redirect()->route('users.index' )->with(['message' => Alert::setAlert( 1, "data berhasil di Hapus" ) ]);

    }
}
