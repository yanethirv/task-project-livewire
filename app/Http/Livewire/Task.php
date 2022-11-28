<?php

namespace App\Http\Livewire;

use App\Models\Task as ModelsTask;
use Livewire\Component;

class Task extends Component
{
    public $tasks;
    public ModelsTask $task;

    protected $rules = ['task.title' => 'required|max:40'];

    public function mount()
    {
        $this->tasks = ModelsTask::orderBy('id', 'desc')->get();
        
        $this->task = new ModelsTask();
    }

    public function updatedTaskTitle()
    {
        $this->validate(['task.title' => 'max:40']);
    }

    public function save()
    {
        //dd($this->task);

        $this->validate();

        $this->task->save();

        $this->mount();

        session()->flash('message', 'Task created');
    }

    public function render()
    {
        return view('livewire.task');
    }
}
