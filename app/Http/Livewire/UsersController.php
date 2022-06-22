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

    public $search, $selected_id, $pageTitle, $componentName,
    $user_name,
    $email,
    $password,
    $condition,
    $person_id;

    private $pagination = 5;

    Public function mount(){
        $this->pagoTitle = 'Listado';
        $this->componentName = 'Usuarios';
    }

    /* bcrypt($this->password) */
    public function render()
    {
        $data = User::all();
        return view('livewire.user.users',['user' => $data ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
