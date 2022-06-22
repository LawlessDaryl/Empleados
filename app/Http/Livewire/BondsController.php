<?php

namespace App\Http\Livewire;

use App\Models\Bond;
use App\Models\Bond_user;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class BondsController extends Component
{
    use WithPagination; 

    public $minimum, $maximum, $percentage,
    $amount, $bond_id,
    $user_id,$user_name, $lastname,$condition, $position_id,
    $position_name,

     $search, $selected_id, $pageTittle, $componentName, $buscarCliente, $condi;
    private $pagination = 7;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->componentName = 'Bonos';
        $this->pageTitle = 'Listado';
        $this->selected_id = 0;
        $this->condi = 'Activos';
    }

    public function render()
    {

        if (strlen($this->search) > 0){
            $data = Bond_user::join('bonds as b', 'b.id', 'bond_users.bond_id')
            ->join('users as u', 'u.id', 'bond_users.user_id')
            ->join('positions','positions.id', 'users.position_id')
            ->select('positions.id as position_id', 'positions.name as posicion',
            'u.id as usuario_id','u.name as user_name', 'u.last_name', 'u.condition',
            'bond_users.id as bono_usuario_id', 'bond_users.amount', 'bond_users.description',
            'bonds.id as bond_id', 'bonds.percentage')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->orWhere('users.last_name', 'like', '%' . $this->search . '%')
            ->orWhere('bond_users.amount', 'like', '%' . $this->search . '%')
            ->orWhere('bonds.percentage', 'like', '%' . $this->search . '%')
            ->orWhere('positions.name', 'like', '%' . $this->search . '%')
            ->orderBy('bond_employees.id', 'desc')
            ->paginate($this->pagination);
        }else{
            if ($this->condi == 'Activos') {
                $data = Bond_user::join('bonds as b', 'b.id', 'bond_users.bond_id')
                ->join('users as u', 'u.id', 'bond_users.user_id')
                ->join('positions','positions.id', 'u.position_id')
                ->where('u.condition', 'active')
                ->select('positions.id as position_id', 'positions.name as posicion',
                'u.id as usuario_id','u.name as user_name', 'u.lastname', 'u.condition',
                'bond_users.id as bono_usuario_id', 'bond_users.amount', 'bond_users.description',
                'b.id as bond_id', 'b.percentage')
                ->orderBy('bond_users.id', 'desc')
                ->paginate($this->pagination);
            }else if ($this->condi == 'Inactivos') {
                $data = Bond_user::join('bonds as b', 'b.id', 'bond_users.bond_id')
                ->join('users as u', 'u.id', 'bond_users.user_id')
                ->join('positions','positions.id', 'u.position_id')
                ->where('u.condition', 'inactive')
                ->select('positions.id as position_id', 'positions.name as posicion',
                'u.id as usuario_id','u.name as user_name', 'u.lastname', 'u.condition',
                'bond_users.id as bono_usuario_id', 'bond_users.amount', 'bond_users.description',
                'b.id as bond_id', 'b.percentage')
                ->orderBy('bond_users.id', 'desc')
                ->paginate($this->pagination);
            }            
        }
        

        $datos = [];
        if (strlen($this->buscarCliente) > 0) {
            $datos = User::where('name', 'like', '%' . $this->buscarCliente . '%')
                ->orWhere('lastname', 'like', '%' . $this->buscarCliente . '%')
                ->orWhere('telefono', 'like', '%' . $this->buscarCliente . '%')
                ->orderBy('name', 'desc')->get();
            if ($datos->count() > 0) {
                $this->condicion = 1;
            } else {
                $this->condicion = 0;
            }
        } else {
            $this->condicion = 0;
        }

        return view('livewire.bonds.component', [
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
            'minimum' => 'required|unique:bonds',
            'maximum' => 'required|unique:bonds',
            'user_name' => 'required',
            'last_name' => 'required',

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

        Bond::create([
            'minimum' => $this->minimum,
            'maximum' => $this->maximum,
            'percentage' => $this->percentage,
            'observation' => $this->observation,
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
