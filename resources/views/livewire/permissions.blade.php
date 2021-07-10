<div class="">

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
                        {{ ucwords($s['name']) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($user->hasPermissionTo($s['name']))
                            <button class="text-red-600 hover:text-red-800" type="button" wire:click="revoke('{{ $s['name'] }}')">Revoke</button>
                        @else
                            <button  class="text-green-600 hover:text-green-800"  type="button" wire:click="assign('{{ $s['name'] }}')">Assign</button>
                        @endif
                    </td>


                </tr>

            @endforeach
            </tbody>
        </table>


    </div>

</div>
