<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ListUsers extends Component
{
    public $title;
    public $content;

    public function sdsasfsaf()
    {
        $this->title = 'ini adalah judul';
    }

    public function render()
    {
        return view('livewire.list-users')
        ->extends('layouts.app')
        ->section('content');
    }
}
