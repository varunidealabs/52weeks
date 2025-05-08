<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Journal;

class LifeCalendar extends Component
{
    public $weeks = [];
    public $selectedJournal = null;
    public $currentWeek;
    public $currentYear;
    
    public function mount()
    {
        $user = auth()->user();
        $now = Carbon::now();
        $this->currentWeek = $now->weekOfYear;
        $this->currentYear = $now->year;
        
        // Calculate from user's account creation date
        $accountCreated = Carbon::parse($user->created_at);
        $creationYear = $accountCreated->year;
        $creationWeek = $accountCreated->weekOfYear;
        
        // Get all journals
        $journals = $user->journals;
        $journalData = [];
        foreach ($journals as $journal) {
            $journalData["{$journal->year}-{$journal->week_number}"] = $journal;
        }
        
        // Calculate how many weeks have passed since account creation
        $totalWeeksSinceCreation = $accountCreated->diffInWeeks($now);
        
        // Create the calendar grid for 52*60 weeks (60 years)
        for ($week = 0; $week < 3120; $week++) { // 52 * 60
            $yearOffset = floor($week / 52);
            $weekNumber = ($week % 52) + 1;
            $currentYearCalculated = $creationYear + $yearOffset;
            
            $weekStatus = 'future';
            $hasJournal = false;
            
            // Check if this week has already passed
            if ($week <= $totalWeeksSinceCreation) {
                $weekStatus = 'no-journal';
                
                // Check if there's a journal entry for this week
                $key = "{$currentYearCalculated}-{$weekNumber}";
                if (isset($journalData[$key])) {
                    $hasJournal = true;
                    $weekStatus = $journalData[$key]->status;
                }
            }
            
            // Check if this is the current week
            if ($currentYearCalculated === $this->currentYear && $weekNumber === $this->currentWeek) {
                $weekStatus = 'current';
            }
            
            $this->weeks[] = [
                'week' => $weekNumber,
                'year' => $currentYearCalculated,
                'status' => $weekStatus,
                'hasJournal' => $hasJournal,
            ];
        }
    }

    public function openWeek($weekNumber, $year)
    {
        // Current date check
        $now = Carbon::now();
        $currentWeek = $now->weekOfYear;
        $currentYear = $now->year;
        
        // Is this a future week?
        if ($year > $currentYear || ($year == $currentYear && $weekNumber > $currentWeek)) {
            // Show message for future weeks
            session()->flash('futureMessage', "You can't journal for future weeks yet!");
            return;
        }
        
        // Is this current week?
        if ($weekNumber === $currentWeek && $year === $currentYear) {
            // Use direct navigation instead of event dispatching
            return redirect()->route('journal.editor', ['week' => $weekNumber, 'year' => $year]);
        }
        
        // Must be a past week - check if journal exists
        $journal = Journal::where('user_id', auth()->id())
            ->where('week_number', $weekNumber)
            ->where('year', $year)
            ->first();
        
        if ($journal) {
            $this->selectedJournal = $journal;
        } else {
            // No journal entry found for this past week
            session()->flash('pastMessage', "No journal entry found for Week $weekNumber, $year");
        }
    }

    public function closeJournal()
    {
        $this->selectedJournal = null;
    }
    
    public function dismissMessage()
    {
        // Clear session messages to fix the error
        session()->forget(['futureMessage', 'pastMessage']);
    }

    public function render()
    {
        return view('livewire.dashboard.life-calendar');
    }
}