<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Journal;

class LifeCalendar extends Component
{
    public $weeks = [];
    public $selectedJournal = null;
    public $showJournalEditor = false;
    public $currentWeek;
    public $currentYear;
    public $journalContent = '';
    public $journalTitle = '';
    public $editWeek;
    public $editYear;

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
        $journal = Journal::where('user_id', auth()->id())
            ->where('week_number', $weekNumber)
            ->where('year', $year)
            ->first();

        // Check if it's current week
        if ($weekNumber === $this->currentWeek && $year === $this->currentYear) {
            $this->redirectToEditor($weekNumber, $year);
        } else {
            $this->selectedJournal = $journal;
            $this->showJournalEditor = false;
        }
    }

    public function redirectToEditor($week, $year)
    {
        return redirect()->route('journal.editor', ['week' => $week, 'year' => $year]);
    }

    public function closeJournal()
    {
        $this->selectedJournal = null;
        $this->showJournalEditor = false;
    }

    public function render()
    {
        return view('livewire.dashboard.life-calendar');
    }
}