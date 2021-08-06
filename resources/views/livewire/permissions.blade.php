<div class="">

    <div class="mb-5 shadow sm:rounded-md sm:overflow-hidden">

        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Permission Filter</h3>
            </div>
              <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 ">
                    <label for="first-name" class="block text-sm font-medium text-gray-700">Search keywords</label>
                    <input type="text" wire:model.debounce.500ms="keyword" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <p class="mt-2 text-sm text-gray-400" id="email-description">You can search by permission name, section or portal name.</p>
                </div>



            </div>
        </div>



    </div>
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Permissions</h3>
            </div>
            @include('ums::include.messages')
        </div>


        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    #
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Portal
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Section
                </th>



                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>

            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($permissions as $key => $s)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ucwords($s['description']) }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ucwords($s['portal']) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ucwords($s['section']) }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($user->hasPermissionTo($s['name']))
                            <button class="text-red-600 text-bold hover:text-red-800" type="button" wire:click="revoke('{{ $s['name'] }}')">Revoke</button>
                        @else
                            <button  class="text-green-600 text-bold hover:text-green-800"  type="button" wire:click="assign('{{ $s['name'] }}')">Assign</button>
                        @endif
                    </td>


                </tr>

            @endforeach
            </tbody>
        </table>


    </div>



</div>
