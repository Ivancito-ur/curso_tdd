<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('repositories.store') }}" method="POST" class="max-w-md">
                    @csrf
                    @method('POST')

                    <label class="block font-medium text-sm text-gray-700">URL*</label>
                    <input class="form-input w-full rounded-md shadow-sm" type="text" name="url">
                    
                    <label class="block font-medium text-sm text-gray-700">DESCRIPCIÓN*</label>
                    <textarea class="form-input w-full rounded-md shadow-sm" type="text" name="description" > </textarea>

                    <hr class="my-4">

                    <input type="submit" value="Guardar" class="bg-blue-500 font-bold py-2 px-4 rounded">
                </form>
            </div>
        </div>
    </div>
</x-app-layout>