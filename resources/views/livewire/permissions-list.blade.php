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
                                    <div class="col-sm-12 col-xs-12 no-padding">
                                        <div class="row">


                                            <div class="col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="first-name">Search keywords</label>
                                                    <input type="text" wire:model.debounce.500ms="keyword" autocomplete="given-name"
                                                           class="form-control year @error('keyword')  is-invalid @enderror">
                                                    <p class="mt-2 text-muted" id="email-description">You can search by permission name,
                                                        section or portal name.</p>
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
                            <h5 class="card-title">All Permissions</h5>
                        </div>
                        <div class="card-body table-responsive p-0">

                            <table class="table table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Portal</th>
                                    <th>Section</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $key => $s)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ ucwords($s['description']) }}</td>
                                        <td class="align-middle">{{ ucwords($s['portal']) }}</td>
                                        <td class="align-middle">{{ ucwords($s['section']) }}</td>
                                        <td class="align-middle">
                                            <a href="/ums/permission-detail/{{$s['id']}}"
                                               class="text-primary ml-2">Detail
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

        <div class="mb-5 shadow sm:rounded-md sm:overflow-hidden">

            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Permission Filter</h3>
                </div>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 ">
                        <label for="first-name" class="block text-sm font-medium text-gray-700">Search keywords</label>
                        <input type="text" wire:model.debounce.500ms="keyword" autocomplete="given-name"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <p class="mt-2 text-sm text-gray-400" id="email-description">You can search by permission name,
                            section or portal name.</p>
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
                        Portal
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Section
                    </th>

                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>

                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($permissions as $key => $s)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                            style="width: 40%; white-space: initial">
                            {{ ucwords($s['description']) }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ucwords($s['portal']) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ucwords($s['section']) }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="/ums/permission-detail/{{$s['id']}}"
                               class="text-indigo-600 font-medium text-bold hover:text-indigo-800">Detail</a>
                        </td>


                    </tr>

                @endforeach
                </tbody>
            </table>


        </div>


    </div>
@endif