@if(env('UMS_BOOTSTRAP') == 'true')

    <div class="content">
        <div class="container-fluid">
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
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h5 class="card-title">Edit User</h5>
                        </div>

                        <div class="card-body">
                            <form wire:submit.prevent="addUser">
                                <div class="row">
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

                                            <div class="col-xs-12 col-sm-12">
                                                <div class="form-group mb-0">
                                                    <button type="submit" class="btn btn-primary"
                                                            wire:loading.attr="disabled">Update
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
                            <h5 class="card-title">Edit Password</h5>
                        </div>

                        <div class="card-body">
                            <form wire:submit.prevent="editPass">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12 no-padding">
                                        <div class="row">

                                            <div class="col-xs-6 col-sm-4">
                                                <div class="form-group">
                                                    <label for="email">New Password</label>
                                                    <input type="password" wire:model.defer="password" id="new_password"
                                                           autocomplete="off"
                                                           class="form-control  @error('password')  is-invalid @enderror">
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-4">
                                                <div class="form-group">
                                                    <label for="name">Confirm Password</label>
                                                    <input type="password" wire:model.defer="password_confirmation"
                                                           id="password_confirmation"
                                                           autocomplete="off"
                                                           class="form-control year @error('password_confirmation')  is-invalid @enderror">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12">
                                                <div class="form-group mb-0">
                                                    <button type="submit" class="btn btn-primary"
                                                            wire:loading.attr="disabled">Update
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
    <div class="">
        <form wire:submit.prevent="addUser">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Edit User</h3>
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
                        Update
                    </button>
                </div>
            </div>
        </form>


        <form wire:submit.prevent="editPass">
            <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Password</h3>
                    </div>


                    <div class="grid grid-cols-6 gap-6 ">


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
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
@endif