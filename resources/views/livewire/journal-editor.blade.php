<!-- resources/views/livewire/journal-editor.blade.php -->
<!DOCTYPE html>
<html lang="en" class="{{ auth()->user()->isDarkMode ?? 'light' }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Journal Entry - Week {{ $currentWeek }}, {{ $currentYear }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @fluxAppearance
</head>
<body class="min-h-screen">
  <div class="flex justify-center items-center py-16 px-6 min-h-screen bg-gray-50 dark:bg-gray-900"> <!-- Added better vertical spacing -->
    @if (session()->has('error'))
      <div class="notification error-notification">
        {{ session('error') }}
      </div>
    @endif

    <div class="entry-card w-full max-w-3xl"> <!-- Increased from 640px -->
      <h1 class="entry-title font-semibold" contenteditable="true" data-placeholder="Week {{ $currentWeek }}, {{ $currentYear }}" id="title-editor">{{ $title ?? '' }}</h1>
      <div class="entry-body" contenteditable="true" data-placeholder="How was your week? What did you learn? What moments stood out?" id="content-editor">{{ $content ?? '' }}</div>
      <div class="entry-toolbar">
        <div class="left">
          <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors rounded-md">
            Cancel <span class="key">Esc</span>
          </a>
        </div>
        <div class="right">
          <button id="save-btn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
            Finish <span class="key">⌘ + Enter</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const saveBtn = document.getElementById('save-btn');
      const titleEl = document.getElementById('title-editor');
      const bodyEl = document.getElementById('content-editor');
      
      // Initialize placeholder state
      if (!titleEl.innerText.trim()) titleEl.innerHTML = '';
      if (!bodyEl.innerText.trim()) bodyEl.innerHTML = '';
      
      // Optimize saving to make it faster
      saveBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const title = titleEl.innerText.trim() || `Week {{ $currentWeek }}, {{ $currentYear }}`;
        const content = bodyEl.innerText.trim();
        
        if (!content) {
          alert('Journal content cannot be empty');
          return;
        }
        
        // Show saving status
        saveBtn.innerHTML = 'Saving...';
        saveBtn.disabled = true;
        
        // Call Livewire method directly
        Livewire.dispatch('saveJournal', { title, content });
        
        // Add a timeout to redirect if Livewire is slow
        setTimeout(function() {
          window.location.href = "{{ route('dashboard') }}";
        }, 1000); // Fallback redirect after 1 second
      });
      
      // Keyboard shortcuts
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          window.location.href = "{{ route('dashboard') }}";
        } else if ((e.metaKey || e.ctrlKey) && e.key === 'Enter') {
          e.preventDefault();
          saveBtn.click();
        }
      });
    });
  </script>
  @fluxScripts
</body>
</html>