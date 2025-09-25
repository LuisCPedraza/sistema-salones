<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Métricas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-card>
                <h3 class="text-lg font-semibold">Usuarios</h3>
                <p class="text-2xl font-bold">{{ $usuarios->count() }}</p>
                <x-button class="mt-4">Ver todos</x-button>
            </x-card>

            <x-card>
                <h3 class="text-lg font-semibold">Grupos</h3>
                <p class="text-2xl font-bold">{{ $grupos->count() }}</p>
                <x-button variant="secondary" class="mt-4">Gestionar</x-button>
            </x-card>

            <x-card>
                <h3 class="text-lg font-semibold">Salones</h3>
                <p class="text-2xl font-bold">{{ $salones->count() }}</p>
                <x-button variant="secondary" class="mt-4">Ver salones</x-button>
            </x-card>
        </div>

        <!-- Tabla de usuarios -->
        <x-card>
            <h3 class="text-lg font-semibold mb-4">Últimos usuarios registrados</h3>
            <x-table :headers="['ID','Nombre','Email','Rol','Acciones']">
                @foreach ($usuarios as $usuario)
                    <tr class="border-t hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-4 py-2">{{ $usuario->id }}</td>
                        <td class="px-4 py-2">{{ $usuario->name }}</td>
                        <td class="px-4 py-2">{{ $usuario->email }}</td>
                        <td class="px-4 py-2">{{ $usuario->role->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <x-button variant="secondary" class="text-sm">Editar</x-button>
                            <x-button variant="danger" class="text-sm">Eliminar</x-button>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </x-card>

        <x-card>
            <h3 class="text-lg font-semibold mb-2">¡Hola!</h3>
            <p>Usuarios: {{ $usuarios->count() }} | Grupos: {{ $grupos->count() }} | Salones: {{ $salones->count() }}</p>
            <x-button class="mt-4">Acción</x-button>
        </x-card>        
        
    </div>    
</x-app-layout>
