<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
//use App\Models\Department;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; //subir imagenes la backend
use Livewire\WithPagination; //

class EmployeesController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $employees, 
    $search, 
    $employee_id, 
    $pageTitle, 
    $componentName, 
    $position_id, 
    $image,
    $user_id,
    $name, 
    $lastname,
    $phone,
    $email,
    $address,
    $role,
    $posiname,
    $password;
    protected $datos;
    
    private $pagination = 5;

    public function paginationView(){
        return 'vendor.livewire.bootsrtap';
    }

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empleados';
        $this->selected_id = 0;
    }

    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Employee::join('users','users.id','=','employees.user_id')
                ->join('positions', 'positions.id','employees.position_id')
                ->select('users.name as username',
                'users.lastname',
                'users.phone',
                'users.email',
                'users.condition',
                'users.role', 
                'positions.name as posiname',
                'users.password')
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->orderBy('users.name','asc')
                ->paginate($this->pagination);
        else
        $data = Employee::join('users','users.id','employees.user_id')
                ->join('positions', 'positions.id', 'employees.position_id')
                ->select('users.name as username',
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
            'positions.required' => 'El cargo es requerido',
        ];
        $this->validate($rules, $messages);

        $ui = User::create([
            'name' => $this->name,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => $this -> password,
            'condition' => $this->condition,
            'role' => $this->role
        ]);
/* 
        $uss = User::select('name')
        ->where('email', $this->email)->first();
        dd($uss->id); */

        Employee::create([
            'user_id'  => $ui->id,
            'position_id' => $this->position_id
        ]);        


        $this->resetUI();
        $this->emit('item-added', 'Empleado Registrado');
    }

    public function Edit(User $user /*Employees $emp */)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->lastname = $user->lastname;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->condition = $user->condition;
        //$this->user_id = $emp->user_id;
        //$this->position_id = $emp->positon_id;

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
            'condition' => $this->condition
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

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(User $use/*, Employee $emp*/)
    {
        $use->delete();
        //$emp->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'usuario Eliminado');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->lastname = '';
        $this->description = '';
        $this->phone = '';
        $this->password = '';
        $this->email = '';
        $this->condition = '';
        $this->search = '';
        $this->posiname = '---';
        $this->role = '---';
        $this->condition = '---';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
