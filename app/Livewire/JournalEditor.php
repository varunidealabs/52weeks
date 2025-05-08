<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Journal;
use Carbon\Carbon;

class JournalEditor extends Component
{
    public $currentWeek;
    public $currentYear;
    public $title = '';
    public $content = '';
    public $existingJournal = null;
    public $isSaving = false;

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

    // Simplified, faster save method
    public function saveJournal($title, $content)
    {
        $this->isSaving = true; // Set saving state
        
        // Skip validation to reduce processing time
        $title = trim($title) ?: "Week {$this->currentWeek}, {$this->currentYear}";
        
        // Use transaction for faster DB operations
        \DB::beginTransaction();
        
        try {
            if ($this->existingJournal) {
                $this->existingJournal->update([
                    'title' => $title,
                    'description' => $content,
                    'status' => 'good',
                ]);
            } else {
                Journal::create([
                    'user_id' => auth()->id(),
                    'title' => $title,
                    'description' => $content,
                    'week_number' => $this->currentWeek,
                    'year' => $this->currentYear,
                    'status' => 'good',
                ]);
            }
            
            \DB::commit();
            session()->flash('message', 'Journal saved successfully!');
            
            // Direct redirect for faster response
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            \DB::rollback();
            session()->flash('error', 'Failed to save journal. Please try again.');
            $this->isSaving = false;
        }
    }

    public function render()
    {
        return view('livewire.journal-editor')
            ->layout('components.layouts.app-simple');
    }
}