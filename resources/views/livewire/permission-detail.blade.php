@if(env('UMS_BOOTSTRAP') == 'true')

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h5 class="card-title">Search Users</h5>
                        </div>

                        <div class="card-body">
                            <form wire:submit.prevent="search()">
                                <div class="row">
                                    @if(!empty($success))
                                        <div class="col-12">
                                            <div class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-hidden="true">
                                                    ×
                                                </button>
                                                {{ $success }}
                                            </div>
                                        </div>
                                    @endif
                                    @if($errors->any())
                                        <div class="col-12">
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-hidden="true">
                                                    ×
                                                </button>
                                                @foreach($errors->all() as $error)
                                                    <li>{{$error}}</li>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-sm-12 col-xs-12 no-padding">
                                        <div class="row">

                                            <div class="col-xs-6 col-sm-4">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" wire:model.defer="email" id="email"
                                                           autocomplete="off"
                                                           class="form-control  @error('email')  is-invalid @enderror">
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-4">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" wire:model.defer="name" id="name"
                                                           autocomplete="off"
                                                           class="form-control year @error('name')  is-invalid @enderror">
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-4">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select wire:model.defer="status" id="status"
                                                            class="custom-select  @error('status')  is-invalid @enderror">
                                                        <option value=""></option>
                                                        <option value="t">Active</option>
                                                        <option value="f">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-4">
                                                <div class="form-group">
                                                    <button type="button" wire:click="clear" class="btn btn-danger"
                                                            wire:loading.attr="disabled">Reset
                                                    </button>
                                                    <button type="submit" class="btn btn-primary"
                                                            wire:loading.attr="disabled">Search
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Permission</h5>
                        </div>
                        <div class="card-body table-responsive p-0">

                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Portal</th>
                                    <th>Section</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="align-middle">{{ ucwords($permission['description']) }}</td>
                                    <td class="align-middle">{{ ucwords($permission['portal']) }}</td>
                                    <td class="align-middle">{{ ucwords($permission['section']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">
                                Assigned Users
                                <span class="text-primary text-sm">( Total #{{count($assigned_users)}} )</span>
                            </h5>
                        </div>
                        <div class="card-body table-responsive p-0">

                            <table class="table   table-striped table-sm  ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($assigned_users as $u)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $u['name'] }}</td>
                                        <td class="align-middle">{{ $u['email'] }}</td>
                                        <td class="align-middle">
                                            @if($u['status'] == 't')
                                                <span class="badge bg-success text-sm">Active</span>
                                            @else
                                                <span class="badge bg-danger text-sm">In-active</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <a wire:click="revoke('{{ $u['id'] }}')" class="text-danger"
                                               style="cursor: pointer">
                                                Revoke
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">
                                Unassigned Users
                                <span class="text-primary text-sm">( Total #{{count($unassigned_users)}} )</span>
                            </h5>
                        </div>
                        <div class="card-body table-responsive p-0">

                            <table class="table   table-striped table-sm  ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($unassigned_users as $u)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $u['name'] }}</td>
                                        <td class="align-middle">{{ $u['email'] }}</td>
                                        <td class="align-middle">
                                            @if($u['status'] == 't')
                                                <span class="badge bg-success text-sm">Active</span>
                                            @else
                                                <span class="badge bg-danger text-sm">In-active</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <a wire:click="assign('{{ $u['id'] }}')" class="text-success"
                                               style="cursor: pointer">
                                                Assign
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@else
    <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">

        <form wire:submit.prevent="search()">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-4 px-4 space-y-4 sm:p-4 border-b">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Search Users</h3>
                </div>
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">

                    <div class="grid grid-cols-6 gap-6 ">
                        <div class="col-span-6 sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model.defer="email" id="email" autocomplete="off"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" wire:model.defer="name" id="name" autocomplete="off"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>


                        <div class="col-span-6 sm:col-span-2  ">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model.defer="status" id="status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value=""></option>
                                <option value="t">Active</option>
                                <option value="f">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="button" wire:click="clear"
                            class="mr-2 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm   font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Reset
                    </button>
                    <button type="submit"
                            class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-4 px-4 space-y-4 sm:p-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Permission</h3>
            </div>


            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Portal
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Section
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                        style="width: 40%; white-space: initial">
                        {{ ucwords($permission['description']) }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ucwords($permission['portal']) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ucwords($permission['section']) }}
                    </td>


                </tr>
                </tbody>
            </table>
        </div>


        <div class="shadow sm:rounded-md sm:overflow-hidden">

            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <div class="bg-white p-4 flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium  align-middle text-gray-900">Assigned Users
                                    <span
                                            class="text-indigo-500 text-sm">( Total #{{count($assigned_users)}} )</span>
                                </h3>

                            </div>
                            @if ($errors->any())
                                <div class="p-4 bg-white">
                                    <div class="rounded-md bg-red-50 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <!-- Heroicon name: x-circle -->
                                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800">
                                                    @php
                                                        $count = count($errors->all());
                                                    @endphp
                                                    There {{ $count > 1 ? "were {$count} errors": "was {$count} error" }}
                                                    with your
                                                    submission
                                                </h3>
                                                <div class="mt-2 text-sm text-red-700">
                                                    <ul class="list-disc pl-5 space-y-1">

                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

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
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>

                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($assigned_users as $u)
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            {{ $loop->iteration }}
                                        </td>


                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            {{ $u['name'] }}
                                        </td>

                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            {{ $u['email'] }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($u['status'] == 't')
                                                <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                              Active
                                            </span>
                                            @else
                                                <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                              Inactive
                                            </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex  flex-row-reverse">
                                            <button class="text-red-600 text-bold hover:text-red-800" type="button"
                                                    wire:click="revoke('{{ $u['id'] }}')">Revoke
                                            </button>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{--    unassigned users--}}
        <div class="shadow sm:rounded-md sm:overflow-hidden">

            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <div class="bg-white p-4 flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium  align-middle text-gray-900">Unassigned Users
                                    <span
                                            class="text-indigo-500 text-sm">( Total #{{count($unassigned_users)}} )</span>
                                </h3>

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
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>

                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($unassigned_users as $u)
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            {{ $loop->iteration }}
                                        </td>


                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            {{ $u['name'] }}
                                        </td>

                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            {{ $u['email'] }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($u['status'] == 't')
                                                <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                              Active
                                            </span>
                                            @else
                                                <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                              Inactive
                                            </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex  flex-row-reverse">
                                            <button class="text-green-600 text-bold hover:text-green-800" type="button"
                                                    wire:click="assign('{{ $u['id'] }}')">Assign
                                            </button>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endif