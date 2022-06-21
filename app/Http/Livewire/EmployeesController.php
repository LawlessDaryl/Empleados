<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; //subir imagenes la backend
use Livewire\WithPagination; //

class EmployeesController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $user_id,$name, $search, $lastname,$phone,$address, $employee_id, $pageTitle, $componentName, $person_id, $position_id, $image;
    private $pagination = 5;

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empleados';
        $this->selected_id = 0;
        $this->persona_id = 0;
    }

    public function render()
    {
        /* if (strlen($this->search) > 0) {
            $employe = Employee::join('people as p', 'p.id', 'employees.person_id')
                ->select('employees.*', 'employees.id as emp_id', 'p.*', 'p.id as person_id')
                ->where('p.name', 'like', '%' . $this->search . '%')
                ->orWhere('p.lastname', 'like', '%' . $this->search . '%')
                ->orWhere('p.phone', 'like', '%' . $this->search . '%')
                ->orderBy('p.id', 'desc')
                ->paginate($this->pagination);
        } else {
            $employe = Employee::join('people as p', 'p.id', 'employees.person_id')
                ->select('employees.*', 'employees.id as emp_id', 'p.*', 'p.id as person_id')                
                ->orderBy('p.id', 'desc')
                ->paginate($this->pagination);
        } */

        $employe = Employee::orderBy('id');
        return view('livewire.employee.component', [
            'data' => $employe
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function store(){
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'position_id' => 'required',
        ];
        $messages = [
            'name.required' => 'El nombre de la persona es requerido.',
            'lastname.required' => 'El apellido de la persona es requerido.',           
            'phone.required' => 'El telefono es requerido.',                  
            'position_id.required' => 'El cargo es requerido.',
        ];
        $this->validate($rules, $messages);


        Employee::create([
            'person_id' => $this->person_id,
            'position_id' => $this->position_id,
                    
        ]);
        $this->resetUI();
        $this->emit('item-added', 'Empleado registrado');
    }

    public function Edit(Employee $p)
    {        
        //person
        $this->person_id = $p->id;
        $this->name = $p->name;
        $this->lastname = $p->lastname;
        $this->phone = $p->phone;
        $this->address = $p->address;

        $emp = Employee::where('id', $this->person_id)->get();

        //employee
        $this->employee_id = $emp->id;                
        $this->position = $emp->position_id;        


        $this->emit('show-modal', 'show modal!');
    }

    public function Update(){
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'position_id' => 'required',
        ];
        $messages = [
            'name.required' => 'El nombre de la persona es requerido.',
            'lastname.required' => 'El apellido de la persona es requerido.',           
            'phone.required' => 'El telefono es requerido.',                  
            'position_id.required' => 'El cargo es requerido.',
        ];
        $this->validate($rules, $messages);

        $e = Employee::find($this->employee_id);
        $e->update([
             //employee
             'position' => $this-> position_id
        ]);
        $e->save();

        
        $this->resetUI();
        $this->emit('item-updated', 'Empleado actualizado');

    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Employee $person)
    {
        $e = Employee::find($this->employee_id);
        $e->delete();

        
        $person->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'persona eliminada');
    }


}


