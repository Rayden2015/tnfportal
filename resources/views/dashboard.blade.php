<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 flex flex-col items-center">
                    <div class="text-blue-600 text-3xl mb-2"><i class="fas fa-project-diagram"></i></div>
                    <div class="text-lg font-semibold">Projects</div>
                    <div class="text-2xl font-bold mt-2">{{ $projectCount ?? '-' }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 flex flex-col items-center">
                    <div class="text-green-600 text-3xl mb-2"><i class="fas fa-users"></i></div>
                    <div class="text-lg font-semibold">Donors</div>
                    <div class="text-2xl font-bold mt-2">{{ $donorCount ?? '-' }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 flex flex-col items-center">
                    <div class="text-yellow-600 text-3xl mb-2"><i class="fas fa-hand-holding-heart"></i></div>
                    <div class="text-lg font-semibold">Volunteers</div>
                    <div class="text-2xl font-bold mt-2">{{ $volunteerCount ?? '-' }}</div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    <span class="text-xl font-semibold">{{ __("You're logged in!") }}</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
