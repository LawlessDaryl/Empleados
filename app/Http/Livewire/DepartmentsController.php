<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentsController extends Component
{
    use WithPagination; 

    public $name, $search, $description, $selected_id, $pageTittle, $componentName;
    private $pagination = 20;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->componentName = 'Departamentos';
        $this->pageTitle = 'Listado';
        $this->selected_id = 0;
    }

    public function render()
    {

        if (strlen($this->search) > 0)
            $data = Department::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Department::orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.departments.component', [
            'data' => $data,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:departments',

        ];
        $messages = [
            'name.required' => 'El nombre del departamento es requerido.',
            'name.unique' => 'Ya existe un departamento con ese nombre.',
        ];
        $this->validate($rules, $messages);

        $so=Department::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $so->save();

        $this->resetUI();
        $this->emit('item-added', 'Departamento Registrado');
    }

    public function Edit(Department $depart)
    {
        $this->selected_id = $depart->id;
        $this->name = $depart->name;
        $this->description = $depart->description;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|unique:departments,name,{$this->selected_id}",
            
        ];
        $messages = [
            'name.required' => 'El nombre del departamento es requerido.',
            'name.unique' => 'Ya existe un departamento con ese nombre.',
            
        ];
        $this->validate($rules, $messages);

        $dep = Department::find($this->selected_id);
        $dep->update([
            'name' => $this->name,
            'description' => $this->description
        ]);
        $dep->save();

        $this->resetUI();
        $this->emit('item-updated', 'Departamento Actualizado');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Department $depart)
    {
        $depart->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Departamento Eliminado');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->description = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
