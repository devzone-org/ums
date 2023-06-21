@if(env('UMS_BOOTSTRAP') == 'true')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Activity</h5>
                        </div>
                        <div class="card-body table-responsive p-0">
                            @if(!empty($user_activity))
                                <table class="table table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th class="align-middle text-left">#</th>
                                        <th class="col-8 align-middle text-center">Activity</th>
                                        <th class="col-2 align-middle text-center">Created By</th>
                                        <th class="col-2 align-middle text-center">Created At</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user_activity as $activity)
                                        <tr>
                                            <td class="align-middle text-left">{{$loop->iteration}}.</td>
                                            <td class="align-middle">{{$activity['description']}}</td>
                                            @php
                                                $created_by = \App\Models\User::find($activity['causer_id']);
                                            @endphp
                                            <td class="align-middle text-center">{{$created_by->name}} {{$created_by->father_name ?? ''}}</td>
                                            <td class="align-middle text-center">{{date('d M, Y h:i A', strtotime($activity['created_at']))}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="p-2">
                                    <div class="alert alert-danger mb-0">
                                        No record found.
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@else

    <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">

        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Activity</h3>
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
                        Activity
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Created By
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Created At
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @if(!empty($user_activity))
                    @foreach($user_activity as $activity)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-initial text-sm text-gray-500">
                                {{$activity['description']}}
                            </td>
                            @php
                                $created_by = \App\Models\User::find($activity['causer_id']);
                            @endphp
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{$created_by->name}} {{$created_by->father_name ?? ''}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{date('d M, Y h:i A', strtotime($activity['created_at']))}}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10" class="text-sm text-red-500">
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
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endif