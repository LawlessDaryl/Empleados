<?php

namespace App\Http\Livewire;

use App\Models\Bond;
use Livewire\Component;
use Livewire\WithPagination;

class BondsController extends Component
{
    use WithPagination; 

    public $minimum, $maximum, $percentage, $observation,
     $search, $selected_id, $pageTittle, $componentName;
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
    }

    public function render()
    {

        if (strlen($this->search) > 0)
            $data = Bond::where('minimum', 'like', '%' . $this->search . '%')
            ->orWhere('maximum', 'like', '%' . $this->search . '%')
            ->orWhere('percentage', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);
        else
            $data = Bond::orderBy('id', 'desc')->paginate($this->pagination);

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
            'percentage' => 'required|unique:bonds',

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
