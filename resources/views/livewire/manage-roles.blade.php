
<div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
    <form wire:submit.prevent="addRole">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">

                <div class="grid grid-cols-6 gap-6 ">
                    <div class="col-span-6 sm:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" wire:model="role_name" id="role_name" x-on:keydown.enter.prevent
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('role_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit"
                        class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $is_edit ? 'Update' : 'Add' }}
                </button>
            </div>
        </div>
    </form>
    @include("ums::include.messages")
    <div class="shadow sm:rounded-md ">
        <div class="flex flex-col">
            <div class="-my-2 sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow  border-b border-gray-200 sm:rounded-lg">
                        <div class="bg-white p-4 flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Roles List</h3>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    #
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created At
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Assigned Permissions
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($roles as $key => $role)
                                <tr wire:key="role-{{ $role['id'] }}">
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        {{ $role['name'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        {{ date('d M, Y h:i:s a', strtotime($role['created_at'])) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        {{ $role['permissions_count'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative">
                                        <div x-data="{ open: false }" x-cloak
                                             @keydown.escape="open = false"
                                             @click.away="open = false"
                                             class="relative inline-block text-left">

                                            <button x-on:click="open = !open"
                                                    class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                                                    id="options-menu"
                                                    aria-haspopup="true"
                                                    x-bind:aria-expanded="open"
                                                    aria-expanded="true">
                                                <span class="sr-only">Open options</span>
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                                </svg>
                                            </button>

                                            <div x-show="open"
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100"
                                                 x-transition:leave-end="transform opacity-0 scale-95"
                                                 class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg z-20 bg-white ring-1 ring-black ring-opacity-5">

                                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                                    <p wire:click="editRole('{{ $role['id'] }}')"
                                                       x-on:click="open = false"
                                                       class="flex items-center gap-2 cursor-pointer px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                       role="menuitem">
                                                        <i class="fas fa-edit w-4 text-indigo-600"></i> Edit
                                                    </p>
                                                    <p wire:click="confirmDelete('{{ $role['id'] }}')"
                                                       x-on:click="open = false"
                                                       class="flex items-center gap-2 cursor-pointer px-4 py-2 text-sm text-red-700 hover:bg-gray-100 hover:text-red-800"
                                                       role="menuitem">
                                                        <i class="fas fa-trash-alt w-4 text-red-600"></i> Delete
                                                    </p>
                                                    <a href="/ums/roles/assign-permissions/{{ $role['id'] }}"
                                                       class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                       role="menuitem">
                                                        <i class="fas fa-user-shield w-4 text-green-600"></i> Assign Permission(s)
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-sm text-red-500">
                                        <div class="flex items-center justify-center py-5">
                                            <div class="flex justify-between">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                     viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                                <span class="ml-2">No Records Yet!</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div x-data="{ open_delete_modal: @entangle('open_modal') }" x-cloak x-show="open_delete_modal"
             class="fixed z-40 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" x-description="Background overlay, show/hide based on modal state."
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true"></span>
                <div x-show="open_delete_modal" x-description="Modal panel, show/hide based on modal state."
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
                     role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                        <button x-on:click="open_delete_modal = false" type="button"
                                class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" x-description="Heroicon name: x" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="sm:flex sm:items-start">
                        <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" x-description="Heroicon name: exclamation"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                Attention
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete?.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteRole" type="button"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Confirm
                        </button>
                        <button x-on:click="open_delete_modal = false;" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
