<!-- resources/views/livewire/journal-editor.blade.php -->
<!DOCTYPE html>
<html lang="en" class="{{ request()->user()->isDarkMode ?? 'light' }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Journal Entry</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @fluxAppearance
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: #f5f5f5;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;
    }
    .dark body {
      background: #1a1a1a;
    }
    .entry-card {
      background: #fff;
      width: 100%;
      max-width: 640px;
      padding: 20px;
      border: 1px dashed #ddd;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .dark .entry-card {
      background: #2a2a2a;
      border-color: #444;
      box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    }
    .entry-title {
      font-size: 1.5rem;
      line-height: 1.2;
      color: #333;
      outline: none;
    }
    .dark .entry-title {
      color: #f0f0f0;
    }
    .entry-title[contenteditable]:empty:before {
      content: attr(data-placeholder);
      color: #ccc;
      font-style: normal;
    }
    .dark .entry-title[contenteditable]:empty:before {
      color: #666;
    }
    .entry-body {
      flex: 1;
      min-height: 200px;
      font-size: 1rem;
      line-height: 1.6;
      color: #333;
      outline: none;
    }
    .dark .entry-body {
      color: #e0e0e0;
    }
    .entry-body[contenteditable]:empty:before {
      content: attr(data-placeholder);
      color: #ccc;
      font-style: normal;
    }
    .dark .entry-body[contenteditable]:empty:before {
      color: #666;
    }
    .entry-toolbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.9rem;
      color: #888;
    }
    .dark .entry-toolbar {
      color: #999;
    }
    .entry-toolbar .left,
    .entry-toolbar .right { display: flex; align-items: center; gap: 8px; }
    .entry-toolbar button {
      background: none;
      border: none;
      color: #007aff;
      cursor: pointer;
      font-weight: 500;
    }
    .dark .entry-toolbar button {
      color: #64b5f6;
    }
    .entry-toolbar .key {
      display: inline-block;
      padding: 2px 4px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background: #f0f0f0;
      font-size: 0.8rem;
    }
    .dark .entry-toolbar .key {
      border-color: #555;
      background: #333;
      color: #ccc;
    }
  </style>
</head>
<body>
  <div class="entry-card">
    <h1 class="entry-title" contenteditable="true" data-placeholder="Week {{ $currentWeek }}, {{ $currentYear }}">{{ $title ?? '' }}</h1>
    <div class="entry-body" contenteditable="true" data-placeholder="How was your week? What did you learn? What moments stood out?">{{ $content ?? '' }}</div>
    <div class="entry-toolbar">
      <div class="left"><button id="cancel-btn">Cancel <span class="key">Esc</span></button></div>
      <div class="right"><button id="save-btn">Finish <span class="key">⌘ + Enter</span></button></div>
    </div>
  </div>
  <script>
    const cancelBtn = document.getElementById('cancel-btn');
    const saveBtn = document.getElementById('save-btn');
    const titleEl = document.querySelector('.entry-title');
    const bodyEl = document.querySelector('.entry-body');
    
    function saveEntry() {
      const title = titleEl.innerText.trim() || `Week {{ $currentWeek }}, {{ $currentYear }}`;
      const content = bodyEl.innerText.trim();
      @this.saveJournal(title, content);
    }
    
    function cancelEntry() {
      window.location.href = "{{ route('dashboard') }}";
    }
    
    cancelBtn.addEventListener('click', cancelEntry);
    saveBtn.addEventListener('click', saveEntry);
    
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') cancelEntry();
      else if ((e.metaKey || e.ctrlKey) && e.key === 'Enter') saveEntry();
    });
  </script>
  @fluxScripts
</body>
</html>