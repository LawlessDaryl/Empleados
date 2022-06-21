<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Person;
use App\Models\Employee;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; //subir imagenes la backend
use Livewire\WithPagination; //

class EmployeesController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $user_id,$name, $search, $lastname,$phone,$address, $employee_id, $pageTitle, $componentName, $person_id, $position_id;
    private $pagination = 5;

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empleados';
        $this->selected_id = 0;
        $this->persona_id = 0;
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
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
        }
        return view('livewire.employee.component', [
            'data' => $employe,
            'person' => Person::orderBy('name', 'asc')->get()
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
        $message = [
            'name.required' => 'El nombre de la persona es requerido.',
            'lastname.required' => 'El apellido de la persona es requerido.',           
            'phone.required' => 'El telefono es requerido.',                  
            'position_id.required' => 'El cargo es requerido.',
        ];
        $this->validate($rules, $messages);

        Person::create([
            'name' => $this->name,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'address' => $this->address,            
        ]);

        Employee::create([
            'person_id' => $this->person_id,
            'position_id' => $this->position_id,
                    
        ]);
        $this->resetUI();
        $this->emit('item-added', 'Empleado registrado');
    }

    public function Edit(Person $p)
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
        $message = [
            'name.required' => 'El nombre de la persona es requerido.',
            'lastname.required' => 'El apellido de la persona es requerido.',           
            'phone.required' => 'El telefono es requerido.',                  
            'position_id.required' => 'El cargo es requerido.',
        ];
        $this->validate($rules, $messages);

        $per = Person::find($this->person_id);
        $per->update([
            //person
            'name' => $this->name,
            'lastname' => $this->lastname,
            'phone' => $this-> phone,
            'address' => $this->address,
           
        ]);
        $per->save();
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

    public function Destroy(Person $person)
    {
        $e = Employee::find($this->employee_id);
        $e->delete();

        $use = User::where('id', $person_id);
        $use->update([
            //person
            'condition' => 'inactive',
        
        ]);

        $use -> save();
        
        $person->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'persona eliminada');
    }


}


