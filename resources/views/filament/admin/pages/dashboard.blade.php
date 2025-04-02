<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 rounded-lg">
            @livewire(\App\Filament\Admin\Widgets\StatsInscritos::class)
        </div>
        <div class="md:col-span-1 rounded-lg">
            @livewire(\App\Filament\Admin\Widgets\StatsOverview::class)
        </div>
    </div>

    @livewire(\App\Filament\Admin\Widgets\TopInscritos::class)
</x-filament-panels::page>
