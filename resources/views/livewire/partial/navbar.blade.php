<div class="navbar bg-base-100 border-b-2 border-base-200 print:hidden">
    <div class="navbar-start">
        <label for="drawer" class="btn btn-ghost btn-circle">
            <x-tabler-menu class="size-5" />
        </label>
    </div>
    <div class="navbar-center">
        <a href="{{ route('home') }}" class="btn btn-ghost text-xl" wire:navigate>{{ env('APP_NAME') }}</a>
    </div>

</div>
