<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Operation History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card-body">
                        <form id="searchForm" name="searchForm" method="GET" action="{{ route('operation') }}"
                              class="mb-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Search by description"
                                       id="searchInput" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>

                            <div class="alert alert-msg d-none">
                                <ul></ul>
                            </div>
                        </form>

                        <div id="item-lists">
                            @include('components.operation-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

@vite('resources/js/operation.js')

