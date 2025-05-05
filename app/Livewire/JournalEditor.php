<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Journal;

class JournalEditor extends Component
{
    public $currentWeek;
    public $currentYear;
    public $title = '';
    public $content = '';
    public $existingJournal = null;

    public function mount($week, $year)
    {
        $this->currentWeek = $week;
        $this->currentYear = $year;
        
        // Check if journal exists for this week
        $this->existingJournal = Journal::where('user_id', auth()->id())
            ->where('week_number', $week)
            ->where('year', $year)
            ->first();
        
        if ($this->existingJournal) {
            $this->title = $this->existingJournal->title;
            $this->content = $this->existingJournal->description;
        }
    }

    public function saveJournal($title, $content)
    {
        $this->validate([
            'content' => 'required|string|min:1',
        ]);

        if ($this->existingJournal) {
            $this->existingJournal->update([
                'title' => $title,
                'description' => $content,
                'status' => 'good', // Default status for now
            ]);
        } else {
            Journal::create([
                'user_id' => auth()->id(),
                'title' => $title,
                'description' => $content,
                'week_number' => $this->currentWeek,
                'year' => $this->currentYear,
                'status' => 'good', // Default status for now
            ]);
        }

        session()->flash('message', 'Journal saved successfully!');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.journal-editor');
    }
}