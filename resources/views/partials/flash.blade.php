@php
  $flashSuccess = session('success') ?? session('status');
  $flashError = session('error');
  $flashWarning = session('warning');
@endphp

<div id="flashStack" class="flash-stack" aria-live="polite" aria-atomic="true">
  @if ($flashSuccess)
    <div class="flash-toast flash-toast--success" data-auto-dismiss role="status">
      <span class="flash-toast__icon" aria-hidden="true">✓</span>
      <div class="flash-toast__body">{{ $flashSuccess }}</div>
      <button type="button" class="flash-toast__close" data-flash-close aria-label="Close">✕</button>
    </div>
  @endif

  @if ($flashError)
    <div class="flash-toast flash-toast--error" data-auto-dismiss role="alert">
      <span class="flash-toast__icon" aria-hidden="true">!</span>
      <div class="flash-toast__body">{{ $flashError }}</div>
      <button type="button" class="flash-toast__close" data-flash-close aria-label="Close">✕</button>
    </div>
  @endif

  @if ($flashWarning)
    <div class="flash-toast flash-toast--warning" data-auto-dismiss role="status">
      <span class="flash-toast__icon" aria-hidden="true">i</span>
      <div class="flash-toast__body">{{ $flashWarning }}</div>
      <button type="button" class="flash-toast__close" data-flash-close aria-label="Close">✕</button>
    </div>
  @endif

  @if ($errors->any())
    <div class="flash-toast flash-toast--error" role="alert">
      <span class="flash-toast__icon" aria-hidden="true">!</span>
      <div class="flash-toast__body">
        <ul class="flash-toast__list">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      <button type="button" class="flash-toast__close" data-flash-close aria-label="Close">✕</button>
    </div>
  @endif
</div>
