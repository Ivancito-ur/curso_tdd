<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <table class="bg-blue-200">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enlace</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody class="px-6 py-6">
                        @forelse ($repositories as $repository)
                            <tr>
                                <td class="border px-6 py-6">{{ $repository->id }}</td>
                                <td class="border px-6 py-6">{{ $repository->url }}</td>
                                <td class="border px-6 py-6">
                                    <a href="{{ route('repositories.show', $repository) }}">Ver</a>
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('repositories.edit', $repository) }}">Editar</a>
                                </td>
                                <td class="border px-4 py-2">
                                    <form action="{{ route('repositories.destroy', $repository)}}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <input type="submit" value="Eliminar" class="rounded-md bg-red-600 text-white py-4 px-6 text-lg">
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4">{{ 'No hay repositorios creados.' }}</td>
                                </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-6">
                    <a href="{{route('repositories.create')}}" class="rounded-md bg-red-600 text-white py-4 px-6 text-lg"> Crear </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
