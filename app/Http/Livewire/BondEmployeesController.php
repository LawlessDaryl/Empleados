<?php

namespace App\Http\Livewire;

use App\Models\Bond_employee;
use Livewire\Component;
use Livewire\WithPagination;

class BondEmployeesController extends Component
{
    use WithPagination; 

    public $name, $amount, $description, $employee_id, $bond_id,
     $search, $selected_id, $pageTittle, $componentName;
    private $pagination = 7;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->componentName = 'Bonos Empleados';
        $this->pageTitle = 'Listado';
        $this->selected_id = 0;
    }

    public function render()
    {

        if (strlen($this->search) > 0)
            $data = Bond_employee::join('bonds as b', 'b.id', 'bond_employees.bond_id')
            ->join('employees as e', 'e.id', 'bond_employees.employee_id')
            ->join('users as u', 'u.id', 'employees.user.id')
            ->select('u.id as usuario_id','u.name as nombre_empleado', 'u.last_name', 'u.email', 'e.id as empleado_id', 'e.user_id', 'e.position_id',
            'bond_employees.id as bono_empleado_id', 'bond_employees.amount as monto', 'bond_employees.description', 'bond_employees.employee_id', 'bond_employees.bond_id',
            'bonds.id as bond_id', 'bonds.percentage')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->orWhere('users.last_name', 'like', '%' . $this->search . '%')
            ->orWhere('users.email', 'like', '%' . $this->search . '%')
            ->orWhere('bond_employees.amount', 'like', '%' . $this->search . '%')
            ->orWhere('bond_employees.description', 'like', '%' . $this->search . '%')
            ->orWhere('bonds.percentage', 'like', '%' . $this->search . '%')
            ->orderBy('bond_employees.id', 'desc')
            ->paginate($this->pagination);
        else
        $data = Bond_employee::join('bonds as b', 'b.id', 'bond_employees.bond_id')
        ->join('employees as e', 'e.id', 'bond_employees.employee_id')
        ->join('users as u', 'u.id', 'employees.user.id')
        ->select('u.id as usuario_id','u.name as nombre_empleado', 'u.last_name', 'u.email', 'e.id as empleado_id', 'e.user_id', 'e.position_id',
        'bond_employees.id as bono_empleado_id', 'bond_employees.amount as monto', 'bond_employees.description', 'bond_employees.employee_id', 'bond_employees.bond_id',
        'bonds.id as bond_id', 'bonds.percentage')
        ->orderBy('bond_employees.id', 'desc')
            ->paginate($this->pagination);

        return view('livewire.bonds_employees.component', [
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

    public function CalcularBono()
    {
        $this->bonoCalculado = 0;
    }
    public function Store()
    {
        $rules = [
            'empleado' => 'required',
            'bono' => 'required'

        ];
        $messages = [
            'empleado.required' => 'El empleado es requerido',
            'bono.required' => 'El empleado es requerido'
        ];
        $this->validate($rules, $messages);

        
        $this->CalcularBono();

        Bond_employee::create([
            'amount' => $this->amount,
            'description' => $this->description,
            'employee_id' => $this->employee_id,
            'bond_id' => $this->bond_id,
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Bono Registrado');
    }

    public function Edit(Bond $depart)
    {
        $this->selected_id = $depart->id;
        $this->minimum = $depart->minimum;
        $this->maximum = $depart->maximum;
        $this->observation = $depart->observation;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'minimum' => "required|unique:bonds,minimum,{$this->selected_id}",
            'maximum' => "required|unique:bonds,maximum,{$this->selected_id}",
            'percentage' => "required|unique:bonds,percentage,{$this->selected_id}",
        ];
        $messages = [
            'minimum.required' => 'El valor es requerido',
            'minimum.unique' => 'Ya existe un registro ese valor',
            'maximum.required' => 'El valor es requerido',
            'maximum.unique' => 'Ya existe un registro ese valor',
            'percentage.required' => 'El valor es requerido',
            'percentage.unique' => 'Ya existe un registro ese valor'
        ];
        $this->validate($rules, $messages);

        $dep = Bond::find($this->selected_id);
        $dep->update([
            'minimum' => $this->minimum,
            'maximum' => $this->maximum,
            'percentage' => $this->percentage,
            'observation' => $this->observation,
        ]);
        $dep->save();

        $this->resetUI();
        $this->emit('item-updated', 'Registro Actualizado');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Bond $depart)
    {
        $depart->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Registro Eliminado');
    }

    public function resetUI()
    {
        $this->minimum = '';
        $this->maximum = '';
        $this->percentage = '';
        $this->observation = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
