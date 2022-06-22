<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; //subir imagenes la backend
use Livewire\WithPagination; //

class UsersController extends Component
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
    $password,
    $selected_id;
    protected $datos;

    private $pagination = 5;

    Public function mount(){
        $this->pagoTitle = 'Listado';
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
        $data = Employee::join('users','users.id','=','employees.user_id')
            ->join('positions', 'positions.id','employees.position_id')
            ->select('employees.id as idemp','users.id as iduser',
            'users.name as username',
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
            ->select('employees.id as idemp','users.id as iduser',
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
}
