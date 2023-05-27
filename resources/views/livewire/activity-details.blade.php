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
                        class="columns-8 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Activity
                    </th>
                    @php
                        $created_by = \App\Models\User::find($activity['causer_id']);
                    @endphp
                    <th scope="col"
                        class="columns-2 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Created By
                    </th>
                    <th scope="col"
                        class="columns-2 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Created At
                    </th>

                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($user_activity as $activity)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{$activity['description']}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{$created_by->name}} {{$created_by->father_name ?? ''}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{date('d M, Y h:i A', strtotime($activity['created_at']))}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif