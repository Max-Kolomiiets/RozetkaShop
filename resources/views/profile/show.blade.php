<x-app-layout>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-20 sm:mt-0"  style="margin-top: 200px">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif
        </div>
    </div>
</x-app-layout>
