@if(env('UMS_BOOTSTRAP') == 'true')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Password</h5>
                        </div>

                        <div class="card-body">
                            <form wire:submit.prevent="changePassword">
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

                                    <div class="col-xs-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="current_password">Current Password</label>
                                            <input type="password" wire:model.defer="current_password"
                                                   id="current_password"
                                                   autocomplete="off" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="new_password">New Password</label>
                                            <input type="password" wire:model.defer="password" id="new_password"
                                                   autocomplete="off" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input type="password" wire:model.defer="password_confirmation"
                                                   id="password_confirmation"
                                                   autocomplete="off" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary">
                                                Save
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

    <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
        <form wire:submit.prevent="changePassword">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Change Password</h3>
                    </div>

                    @include('ums::include.messages')
                    <div class="grid grid-cols-6 gap-6 ">
                        <div class="col-span-6 sm:col-span-4 mt-5">
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current
                                Password</label>
                            <input type="password" wire:model.defer="current_password" id="current_password"
                                   autocomplete="off"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="new_password" class="block text-sm font-medium text-gray-700">New
                                Password</label>
                            <input type="password" wire:model.defer="password" id="new_password" autocomplete="off"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm
                                Password</label>
                            <input type="password" wire:model.defer="password_confirmation" id="password_confirmation"
                                   autocomplete="off"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>


                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit"
                            class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>

@endif
