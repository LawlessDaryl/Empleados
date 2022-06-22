<?php

namespace App\Http\Livewire;

use App\Models\Vacation;
use Livewire\Component;
use Livewire\WithPagination;

class VacationsController extends Component
{
    use WithPagination; 

    public $minimum_years, $maximum_years, $free_days, $observation, $search, $description, $selected_id, $pageTittle, $componentName;
    private $pagination = 8;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->componentName = 'Vacaciones';
        $this->pageTitle = 'Tabla Rango Vacaciones';
        $this->selected_id = 0;
    }

    public function render()
    {
        $data = vacation::all();

        if (strlen($this->search) > 0)
            $vacaciones = Vacation::where('minimun_years', 'like', '%' . $this->search . '%')
            ->orWhere('maximum_years', 'like', '%' . $this->search . '%')
            ->orWhere('free_days', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);
        else
            $vacaciones = vacation::orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.vacation.component', [
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
            'minimum_years' => 'required|unique:vacation',
            'maximum_years' => 'required|unique:vacation',
            'free_days' => 'required|unique:vacation',
            'observation' => 'required|unique:vacation',

        ];
        $messages = [
            'minimum_years' => 'El minimo de años es requerido.',
            'minimum_years.unique' => 'Ya existe ese minimo de años.',
            'maximum_years' => 'El maximo de años es requerido.',
            'maximum_years.unique' => 'Ya existe ese maximo de años.',
            'free_days' => 'Los dias de vacacion son requeridos.',
            'free_days.unique' => 'Ya existe esos dias de vacacion.',
            'observation' => 'Las observaciones son requeridas.',
            'observation' => 'Ya existe esas observaciones.',
        ];
        $this->validate($rules, $messages);

        vacation::create([
            'minimum_years' => $this->minimum_years,
            'maximum_years' => $this->maximum_years,
            'free_days' => $this->free_days,
            'observation' => $this->observation,
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Vacacion registrada');
    }

    public function Edit(vacation $vacat)
    {
        $this->selected_id = $vacat->id;
        $this->minimum_years = $vacat->minimum_years;
        $this->maximum_years = $vacat->maximum_years;
        $this->free_days = $vacat->free_days;
        $this->observation = $vacat->observation;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'minimum_years' => "required|unique:vacation,minimum_years,{$this->selected_id}",
            'maximum_years' => "required|unique:vacation,maximum_years,{$this->selected_id}",
            'free_days' => "required|unique:vacation,free_days,{$this->selected_id}",
            'observation' => "required|unique:vacation,observation,{$this->selected_id}",
            
        ];
        $messages = [
            'minimum_years' => 'El minimo de años es requerido.',
            'minimum_years.unique' => 'Ya existe ese minimo de años.',
            'maximum_years' => 'El maximo de años es requerido.',
            'maximum_years.unique' => 'Ya existe ese maximo de años.',
            'free_days' => 'Los dias de vacacion son requeridos.',
            'free_days.unique' => 'Ya existe esos dias de vacacion.',
            'observation' => 'Las observaciones son requeridas.',
            'observation' => 'Ya existe esas observaciones.', 
        ];
        $this->validate($rules, $messages);

        $dep = vacation::find($this->selected_id);
        $dep->update([
            'minimum_years' => $this->minimum_years,
            'maximum_years' => $this->maximum_years,
            'free_days' => $this->free_days,
            'observation' => $this->observation,
        ]);
        $dep->save();

        $this->resetUI();
        $this->emit('item-updated', 'Minimo de años actualizado');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(vacation $vacat)
    {
        $depart->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Minimo de años Eliminado');
    }

    public function resetUI()
    {
        $this->minimum_years = '';
        $this->maximum_years = '';
        $this->free_days = '';
        $this->observation = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
