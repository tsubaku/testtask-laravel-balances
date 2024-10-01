<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h1 class="mb-0">Current Balance</h1>
                                </div>
                                <div class="card-body">
                                    <p id="balance" class="fs-4">{{ $balance ?? 0 }} EU</p>
                                </div>
                            </div>

                            <div class="card mt-4 shadow-sm">
                                <div class="card-header bg-secondary text-white">
                                    <h2 class="mb-0">Last Operations</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Date/Time</th>
                                        </tr>
                                        </thead>
                                        <tbody id="item-lists">
                                        @foreach ($operations as $operation)
                                            <tr class="{{ $operation->amount >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                                                <td>{{ $operation->amount }} EU</td>
                                                <td>{{ $operation->description }}</td>
                                                <td>{{ $operation->created_at->format('d.m.Y H:i:s') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <p>Auto refresh every 5 seconds</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="data-container" data-fetch-url="{{ route('fetch.data') }}"></div>

</x-app-layout>

@vite('resources/js/dashboard.js')

