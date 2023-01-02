<div class="">

    <div class="mb-5 shadow sm:rounded-md sm:overflow-hidden">

        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Permission Filter</h3>
            </div>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-3 ">
                    <label for="first-name" class="block text-sm font-medium text-gray-700">Portal</label>
                    <select wire:model="portal"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value=""></option>
                        @foreach($portals as $p )
                            <option value="{{$p['portal']}}">{{ucwords($p['portal'])}}</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-sm text-gray-400" id="email-description">You can search by specific
                        portal.</p>
                </div>
                <div class="col-span-3 ">
                    <label for="first-name" class="block text-sm font-medium text-gray-700">Search keywords</label>
                    <input type="text" wire:model.debounce.500ms="keyword" autocomplete="given-name"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <p class="mt-2 text-sm text-gray-400" id="email-description">You can search by permission name or
                        section</p>
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
                {{--                <tr>--}}
                {{--                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">--}}
                {{--                        {{ $loop->iteration }}--}}
                {{--                    </td>--}}
                {{--                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"--}}
                {{--                        style="width: 40%; white-space: initial">--}}
                {{--                        {{ ucwords($s['description']) }}--}}
                {{--                    </td>--}}

                {{--                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">--}}
                {{--                        {{ ucwords($s['portal']) }}--}}
                {{--                    </td>--}}
                {{--                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">--}}
                {{--                        {{ ucwords($s['section']) }}--}}
                {{--                    </td>--}}

                {{--                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">--}}
                {{--                        @if($user->hasPermissionTo($s['name']))--}}
                {{--                            <button class="text-red-600 text-bold hover:text-red-800" type="button"--}}
                {{--                                    wire:click="revoke('{{ $s['name'] }}')">Revoke--}}
                {{--                            </button>--}}
                {{--                        @else--}}
                {{--                            <button class="text-green-600 text-bold hover:text-green-800" type="button"--}}
                {{--                                    wire:click="assign('{{ $s['name'] }}')">Assign--}}
                {{--                            </button>--}}
                {{--                        @endif--}}
                {{--                    </td>--}}

                {{--                </tr>--}}
                {{--                <livewire:permission-tr :permission="$s" :user="$user" :wire:key="$s['id']">--}}
                @livewire('permission-tr', ['permission' => $s, 'user' => $user, 'sr' => $loop->iteration], key($s['id']))

            @endforeach
            </tbody>
        </table>

        @if($permissions->isNotEmpty())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-md">
                {{ $permissions->links() }}
            </div>
        @endif
    </div>


</div>
