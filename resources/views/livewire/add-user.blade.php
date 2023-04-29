@if(env('UMS_BOOTSTRAP') == 'true')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h5 class="card-title">Add User</h5>
                        </div>

                        <div class="card-body">
                            <form wire:submit.prevent="addUser">
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
                                                    <label for="father_name">Father Name</label>
                                                    <input type="text" wire:model.defer="father_name" id="father_name" autocomplete="off"
                                                           class="form-control year @error('father_name')  is-invalid @enderror">
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-4">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" wire:model.defer="password" id="password" autocomplete="off"
                                                           class="form-control year @error('password')  is-invalid @enderror">
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

                                            <div class="col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary"
                                                            wire:loading.attr="disabled">Save
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
        </div>
    </div>

@else
    <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
        <form wire:submit.prevent="addUser">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Add User</h3>
                    </div>

                    @include('ums::include.messages')

                    <div class="grid grid-cols-6 gap-6 ">
                        <div class="col-span-6 sm:col-span-3 mt-5">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model.defer="email" id="email" autocomplete="off"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="col-span-6 sm:col-span-3 mt-5">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" wire:model.defer="name" id="name" autocomplete="off"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="father_name" class="block text-sm font-medium text-gray-700">Father Name</label>
                            <input type="text" wire:model.defer="father_name" id="father_name" autocomplete="off"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>


                        <div class="col-span-6 sm:col-span-3  ">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" wire:model.defer="password" id="password" autocomplete="off"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>


                        <div class="col-span-6 sm:col-span-3  ">
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
                    <button type="submit"
                            class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
@endif