@if(env('UMS_BOOTSTRAP') == 'true')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h5 class="card-title">Permission Filter</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 no-padding">
                                    <div class="row">

                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select wire:model.defer="status" id="status"
                                                        class="custom-select">
                                                    <option value=""></option>
                                                    @foreach($portals as $p )
                                                        <option value="{{$p['portal']}}">{{ucwords(str_replace('_', ' ', $p['portal']))}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <button type="button" wire:click="updateData" class="btn btn-primary"
                                                        wire:loading.attr="disabled">
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                        <p class="mx-2 text-sm text-secondary">
                                            You can search by specific portal.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h5 class="card-title">Permissions</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col px-1">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-striped table-sm">
                                            <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>User Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="align-middle">{{ucwords($user->name)}}</td>
                                                <td class="align-middle">{{$user->email}}</td>
                                                <td class="align-middle">
                                                    @if($user->status == 't')
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-10 w-100">
                            <form wire:submit.prevent="savePermissionsData">
                                <div class="d-flex">
                                    <div class="col-xs-5 w-50 px-3 pt-1">

                                        <div class="alert alert-danger p-4">
                                            <strong>List of all unassigned permissions.</strong>
                                        </div>
                                        <div class="divider d-flex justify-content-center">
                                            <button type="button" wire:click="selectOnly"
                                                    class="btn btn-default w-100 p-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 5%"
                                                     viewBox="0 0 20 20"
                                                     fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="form-group w-100">
                                            <input type="text" wire:model.debounce.500ms="unassigned_keyword"
                                                   autocomplete="given-name" class="w-100 rounded">
                                            <select wire:model="adding_permissions_ids"
                                                    id="adding_permissions_ids"
                                                    multiple size="15" id="section_list" class="w-100">
                                                @if(!empty($unassigned_permissions))
                                                    @foreach(collect($unassigned_permissions)->groupBy('section')->toArray() as $x => $un_per)
                                                        <optgroup label="{{ucwords(str_replace('_', ' ', $x))}}">
                                                            @foreach(collect($un_per)->sortBy('description') as $data1)
                                                                <option value="{{$data1['name']}}">
                                                                    {{$loop->iteration . "."}} {{ucwords($data1['description'])}}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-5 w-50 px-3 pt-1">

                                        <div class="alert alert-success p-4">
                                            <strong>List of all unassigned permissions.</strong>
                                        </div>
                                        <div class="divider d-flex justify-content-center">
                                            <button type="button" wire:click="unselectOnly"
                                                    class="btn btn-default w-100 p-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 5%"
                                                     viewBox="0 0 20 20"
                                                     fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" wire:model.debounce.500ms="assigned_keyword"
                                                   autocomplete="given-name" class="w-100 rounded">
                                            <select wire:model="removing_permissions_ids"
                                                    id="removing_permissions_ids"
                                                    multiple size="15" class="w-100">
                                                @if(!empty($assigned_permissions))
                                                    @foreach(collect($assigned_permissions)->groupBy('section')->toArray() as $y => $per)
                                                        <optgroup label="{{ucwords(str_replace('_', ' ', $y))}}">
                                                            @foreach(collect($per)->sortBy('description') as $data2)
                                                                <option value="{{$data2['name']}}">
                                                                    {{$loop->iteration . "."}} {{ucwords($data2['description'])}}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-4 px-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary"
                                                    wire:loading.attr="disabled">Save
                                            </button>
                                            <button type="button" id="reset" wire:click="updateData"
                                                    class="btn btn-danger"
                                                    wire:loading.attr="disabled">Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@else
    <div class="">

        <div class="mb-5 shadow sm:rounded-md sm:overflow-hidden">

            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Permission Filter</h3>
                </div>
                <div class="grid grid-cols-6 gap-6 w-full">
                    <div class="col-span-6">
                        <label for="portal" class="block text-sm font-medium text-gray-700">Portal</label>
                        <select wire:model="portal" id="portal"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value=""></option>
                            @foreach($portals as $p )
                                <option value="{{$p['portal']}}">{{ucwords(str_replace('_', ' ', $p['portal']))}}</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-sm text-gray-400" id="email-description">You can search by specific
                            portal.</p>
                    </div>
                </div>

            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="button" wire:click="updateData"
                        class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Search
                </button>
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
                <thead class="bg-gray-50 px-4">
                <tr>
                    <th scope="col"
                        class="px-7 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        User Name
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        User Email
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        User Status
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-7 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ucwords($user->name)}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{$user->email}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($user->status == 't')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Inactive
                        </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="px-7 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                </tr>
                </tbody>
            </table>
            <div class="flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full align-middle md:px-6 lg:px-8 ">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5">
                            <form wire:submit.prevent="savePermissionsData">
                                <div class="px-4 py-6 space-y-6 bg-white sm:p-6 sm:pt-0">
                                    <div class="flex justify-between gap-x-4">
                                        <div class="w-1/2">
                                            <div class="bg-red-600 text-red-100 font-bold rounded p-5 justify-center items-center">
                                                List of all unassigned permissions.
                                            </div>
                                            <div class="bg-gray-100 flex justify-between items-center divide-x">
                                                <button type="button" wire:click="selectOnly"
                                                        class="flex justify-center items-center w-full p-5 text-gray-900 hover:bg-gray-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                         viewBox="0 0 20 20"
                                                         fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div>
                                                <input type="text" wire:model.debounce.500ms="unassigned_keyword"
                                                       autocomplete="given-name"
                                                       class="mb-0.5 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <label for="adding_permissions_ids" class="sr-only"></label>
                                                <select wire:model="adding_permissions_ids"
                                                        id="adding_permissions_ids"
                                                        multiple
                                                        class="h-72 block w-full px-3 py-4 border border-gray-100 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    @if(!empty($unassigned_permissions))
                                                        @foreach(collect($unassigned_permissions)->groupBy('section')->toArray() as $x => $un_per)
                                                            <optgroup label="{{ucwords(str_replace('_', ' ', $x))}}">
                                                                @foreach(collect($un_per)->sortBy('description') as $data1)
                                                                    <option value="{{$data1['name']}}">
                                                                        {{$loop->iteration . "."}} {{ucwords($data1['description'])}}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="w-1/2">
                                            <div class="bg-green-600 text-green-100 font-bold rounded p-5 justify-center items-center">
                                                List of all assigned permissions.
                                            </div>
                                            <div class="bg-gray-100 flex justify-between items-center divide-x">
                                                <button type="button" wire:click="unselectOnly"
                                                        class="flex justify-center items-center w-full p-5 text-gray-900 hover:bg-gray-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                         viewBox="0 0 20 20"
                                                         fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div>
                                                <input type="text" wire:model.debounce.500ms="assigned_keyword"
                                                       autocomplete="given-name"
                                                       class="mb-0.5 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <label for="removing_permissions_ids" class="sr-only"></label>
                                                <select wire:model="removing_permissions_ids"
                                                        id="removing_permissions_ids"
                                                        multiple
                                                        class="h-72 block w-full px-3 py-4 border border-gray-100 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                                    @if(!empty($assigned_permissions))
                                                        @foreach(collect($assigned_permissions)->groupBy('section')->toArray() as $y => $per)
                                                            <optgroup label="{{ucwords(str_replace('_', ' ', $y))}}">
                                                                @foreach(collect($per)->sortBy('description') as $data2)
                                                                    <option value="{{$data2['name']}}">
                                                                        {{$loop->iteration . "."}} {{ucwords($data2['description'])}}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="px-4 py-3 pb-5 text-right bg-gray-50 sm:px-6">
                                    <button type="submit"
                                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm disabled:opacity-25 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save
                                    </button>

                                    <button type="button" id="reset" wire:click="updateData"
                                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm disabled:opacity-25 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif