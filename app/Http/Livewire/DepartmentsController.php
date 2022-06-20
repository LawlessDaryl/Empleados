<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentsController extends Component
{
    use WithPagination; 

    public $name, $search, $description, $selected_id, $pageTittle, $componentName;
    private $pagination = 8;

    public function render()
    {
        $data = Department::all();

        return view('livewire.departments.component', [$data])
        -> extends('layouts.theme.app')
        ->section('content');

        
    }
}
