
<div class="flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <x-filament-panels::page.simple>
            @if (filament()->hasRegistration())
                <x-slot name="subheading">
                    {{ __('filament-panels::pages/auth/login.actions.register.before') }}
                    {{ $this->registerAction }}
                </x-slot>
            @endif

            <x-filament-panels::form id="form" wire:submit="authenticate">
                {{ $this->form }}

                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
                />
            </x-filament-panels::form>
        </x-filament-panels::page.simple>
    </div>
</div>

