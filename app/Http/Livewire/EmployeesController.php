<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; //subir imagenes la backend
use Livewire\WithPagination; //

class EmployeesController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $employees, 
    $user_id,
    $name, 
    $search, 
    $lastname,
    $phone,
    $address, 
    $employee_id, 
    $pageTitle, 
    $componentName, 
    $position_id, 
    $image;
    private $pagination = 5;

    public function paginationView(){
        return 'vendor.livewire.bootsrtap';
    }

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empleados';
        $this->selected_id = 0;
    }

    public function render()
    {
       //funciona 
       /*$data = User::join('employees as emp', 'emp.user_id', 'users.id')
            ->select('users.name','users.lastname','users.phone','users.email','emp')
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);*/

      /*  $data = Employee::join('users','users.id','=','employees.user_id')
            ->join('positions', 'employees.position_id', '=', 'positions.id')
            ->select('users.name','users.lastname','users.phone','users.email','users.condition', 'positions.name')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);*/

        if (strlen($this->search) > 0)
            $data = Employee::join('users','users.id','=','employees.user_id')
                ->join('positions', 'employees.position_id', '=', 'positions.id')
                ->select('users.name as username','users.lastname','users.phone','users.email','users.condition', 'positions.name as posiname')
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->orderBy('users.name','asc')
                ->paginate($this->pagination);
        else
            $data = Employee::join('users','users.id','=','employees.user_id')
                ->join('positions', 'employees.position_id', '=', 'positions.id')
                ->select('users.name as username','users.lastname','users.phone','users.email','users.condition', 'positions.name as posiname')
                ->orderBy('users.name','asc')
                ->paginate($this->pagination);

        return view('livewire.employee.component', [
            'data' => $data,
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
            'condition' =>'required',
            //'positions' => 'required',


        ];
        $messages = [
            'name.required' => 'El nombre del usuario es requerido.',
            'lastname.required' => 'El apellido del usuario es requerido',            
            'phone.required' => 'El telefono del usuario es requerido',
            'email.required' => 'El email del usuario es requerido',
            'email.unique' => 'Ya existe un email con ese nombre.',
            'condition.required' => 'la condición es requerida',
            //'positions.required' => 'El cargo es requerido',
        ];
        $this->validate($rules, $messages);

        User::create([
            'name' => $this->name,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'email' => $this->email,
            'condition' => $this->condition,
        ]);
        /*Employee::create([
            'user_id'  => $this -> id,
            'positon_id' => $this -> position_id
        ]);*/

        $this->resetUI();
        $this->emit('item-added', 'Empleado Registrado');
    }

    public function Edit(Users $user /*Employees $emp */)
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
        $this->description = '';
        $this->phone = '';
        $this->email = '';
        $this->condition = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
