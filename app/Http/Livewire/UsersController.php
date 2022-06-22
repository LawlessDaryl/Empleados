<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; 
use Livewire\WithPagination; 

class UsersController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public 
    $search, 
    $pageTitle, 
    $componentName, 
    $position_id, 
    $image,
    $name, 
    $lastname,
    $phone,
    $email,
    $address,
    $role,
    $posiname,
    $password,
    $selected_id,
    $role_id;
    protected $datos;

    private $pagination = 5;

    Public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->selected_id = 0;
    }
    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }


    /* bcrypt($this->password) *///////////////////////////////////
    

   public function render()
    {
        
        if (strlen($this->search) > 0)
        $data = User::join('positions','positions.id','users.position_id')        
            ->select(
            'users.id as userid',
            'users.name as username',
            'users.lastname',
            'users.phone',
            'users.email',
            'users.condition',
            'users.role', 
            'positions.name as posiname')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->orderBy('users.name','asc')
            ->paginate($this->pagination);
        else
        $data = User::join('positions','positions.id','users.position_id')        
                ->select(
                'users.id as userid',
                'users.name as username',
                'users.lastname',
                'users.phone',
                'users.email',
                'users.condition',
                'users.role', 
                'positions.name as posiname')
                ->orderBy('users.name','asc')
                ->paginate($this->pagination);

    $posiciones = Position::orderBy('id','desc')->get();

    return view('livewire.employee.component', [
        'data' => $data,
        'posis' => $posiciones,
    ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required',
            'lastname' =>'required',
            'phone' =>'required',
            'email' =>'required|unique:users',
            'password' => 'required',
            'condition' =>'required',
            'role' => 'required',
            'position_id' => 'required',


        ];
        $messages = [
            'name.required' => 'El nombre del usuario es requerido.',
            'lastname.required' => 'El apellido del usuario es requerido',            
            'phone.required' => 'El telefono del usuario es requerido',
            'email.required' => 'El email del usuario es requerido',
            'email.unique' => 'Ya existe un email con ese nombre.',
            'password.required' => 'La contraseña del usuario es requerida',
            'condition.required' => 'la condición es requerida',
            'role.required' => 'El rol es requerido',
            'position.required' => 'El cargo es requerido',
        ];
        $this->validate($rules, $messages);

        $p = Position::find($this->posiname)->first();
        echo "hola" + $p;
        $ui = User::create([
            'name' => $this->name,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'condition' => $this->condition,
            'role' => $this->role,
            'position_id' => $this->position_id
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Empleado Registrado');
    }
    public function Edit(User $user /*Employees $emp */)
    {
        $this -> resetUI();

        $p = Position::find($user->position_id)->first();        

        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->lastname = $user->lastname;
        $this->phone = $user->phone;
        $this->email = $user->email;        
        $this->condition = $user->condition;
        $this->role = $user->role;
        $this->posiname = $p->name;        
        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'email' => "required|unique:users,email,{$this->selected_id}",                        
        ];
        $messages = [
            'email.required' => 'El nombre del email es requerido.',
            'email.unique' => 'Ya existe un email con esa dirección.',
            
        ];
        $this->validate($rules, $messages);

        $us = User::find($this->selected_id);
        
        $us->update([
            'name' => $this->name,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'condition' => $this->condition,
            'role_id' => $this->role_id,
            'position_id' => $this->position_id
        ]);

        /*
        $em = Employee::find($this->selected_id);
        $em->update([
            'user_id' => $this->user_id,
            'position_id' => $this->position_id,
        ]);
        */


        $us->save();
        //$em->save();

        $this->resetUI();
        $this->emit('item-updated', 'Usuario Actualizado');
    }





    public function resetUI()
    {
        $this->name = '';
        $this->lastname = '';
        //$this->description = '';
        $this->phone = '';
        $this->email = '';
        $this->password = '';        
        $this->condition = '';
        $this->search = '';
        $this->posiname = '---';
        $this->role = '---';
        $this->condition = '---';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
