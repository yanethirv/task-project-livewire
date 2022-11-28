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

    public function edit(ModelsTask $task)
    {
        $this->task = $task;
    }

    public function save()
    {
        //dd($this->task);

        $this->validate();

        $this->task->save();

        $this->mount();

        $this->emitUp('taskSaved', 'Task created succesfully!');
    }

    public function delete($id)
    {
        $taskToDelete = ModelsTask::find($id);

        if (!is_null($taskToDelete)) {
            $taskToDelete->delete();

            $this->emitUp('taskSaved', 'Task deleted succesfully!');

            $this->mount();
        }
    }

    public function render()
    {
        return view('livewire.task');
    }
}
