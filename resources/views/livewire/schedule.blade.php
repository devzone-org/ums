@if(env('UMS_BOOTSTRAP') == 'true')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Schedule</h5>
                        </div>
                        <div class="card-body table-responsive p-0">
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
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schedule as $key => $s)
                                    <tr>
                                        <td style="padding-top: 20px; padding-bottom: 20px" class="align-middle">{{ ucfirst($s['day']) }}</td>
                                        <td class="align-middle">
                                            <input type="time" wire:model.defer="schedule.{{ $key }}.from" autocomplete="off" class="custom-select">
                                        </td>
                                        <td class="align-middle">
                                            <input type="time" wire:model.defer="schedule.{{ $key }}.to" autocomplete="off" class="custom-select">
                                        </td>
                                        <td class="align-middle">
                                            <select wire:model.defer="schedule.{{ $key }}.status"
                                                    class="custom-select">
                                                <option value=""></option>
                                                <option value="t">On</option>
                                                <option value="f">Off</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="col-xs-12 col-sm-12 border-top">
                                <div class="form-group mt-3 mx-3">
                                    <button type="button" wire:click="updateSchedule" class="btn btn-primary"
                                            wire:loading.attr="disabled">Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@else
    <div class="">

        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Schedule</h3>
                </div>
                @include('ums::include.messages')
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Day
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        From
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        To
                    </th>


                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>

                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($schedule as $key => $s)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ ucfirst($s['day']) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <input type="time"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   wire:model.defer="schedule.{{ $key }}.from">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <input type="time"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   wire:model.defer="schedule.{{ $key }}.to">
                        </td>


                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    wire:model.defer="schedule.{{ $key }}.status">
                                <option value=""></option>
                                <option value="t">On</option>
                                <option value="f">Off</option>
                            </select>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="button" wire:click="updateSchedule"
                        class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update
                </button>
            </div>
        </div>

    </div>
@endif