@if(env('UMS_BOOTSTRAP') == 'true')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">User Information</h5>
                        </div>

                        <div class="card-body">
                            <form wire:submit.prevent="updateUserDetails">
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

                                    <div class="col-xs-6 col-sm-4">
                                        <div class="form-group">
                                            <label for="first-name">First Name</label>
                                            <input type="text" wire:model.lazy="user_details.first_name"
                                                   class="form-control  @error('user_details.first_name')  is-invalid @enderror"
                                                   id="first-name" autocomplete="given-name">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-4">
                                        <div class="form-group">
                                            <label for="middle-name">Middle Name</label>
                                            <input type="text" wire:model.lazy="user_details.middle_name"
                                                   class="form-control"
                                                   id="middle-name" autocomplete="given-name">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-4">
                                        <div class="form-group">
                                            <label for="family-name">Family Name</label>
                                            <input type="text" wire:model.lazy="user_details.family_name"
                                                   class="form-control"
                                                   id="family-name" autocomplete="given-name">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-4">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" wire:model.lazy="user.email" id="email" disabled
                                                   class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-4">
                                        <div class="form-group">
                                            <label for="contact-no">Contact #</label>
                                            <input type="text" wire:model.lazy="user_details.contact_no"
                                                   class="form-control"
                                                   id="contact-no" autocomplete="given-name">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-4">
                                        <div class="form-group">
                                            <label for="personal-id-no">Personal ID #</label>
                                            <input type="text" wire:model.lazy="user_details.personal_id_no"
                                                   class="form-control"
                                                   id="personal-id-no" autocomplete="given-name">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" wire:model.lazy="user_details.address"
                                                   class="form-control"
                                                   id="address" autocomplete="given-name">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-12">
                                        <div class="form-group ">
                                            <label for="photo">Photo</label>
                                            <div class="d-flex justify-content-center">
                                                @if(!empty($photo))
                                                    <div style="width: 80px;height: 80px;border-radius: 50%;overflow: hidden">
                                                        <img class="img-circle w-100 h-100 border"
                                                             src="{{ $photo->temporaryUrl() }}">
                                                    </div>
                                                @elseif(!empty($user['attachment']))
                                                    <div style="width: 80px;height: 80px;border-radius: 50%;overflow: hidden">
                                                        <img class="img-circle w-100 h-100 border"
                                                             src="{{ env('AWS_URL'). $user['attachment'] }}">
                                                    </div>
                                                @else
                                                    <div style="width: 80px;height: 80px;border-radius: 50%;overflow: hidden">
                                                        <img class="w-100 h-100 img-circle"
                                                             src="{{ asset('img/default-profile.jpg') }}" alt="">
                                                    </div>
                                                @endif

                                                @if(auth()->user()->can('1.edit-profile-photo'))
                                                        <div class="px-3 pt-4 btn btn-sm">
                                                            <label for="file-upload" class=" py-1 px-3 border bg-light rounded">
                                                                <span>Change</span>
                                                                <input id="file-upload" wire:model="photo" name="file-upload"
                                                                       accept="image/png, image/jpeg" type="file"
                                                                       class="sr-only">
                                                            </label>
                                                        </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <textarea wire:model.lazy="user_details.remarks" rows="3"
                                                      class="form-control"
                                                      id="remarks" autocomplete="given-name"></textarea>
                                        </div>
                                    </div>

                                    @if(config('user-management.link_user_account'))
                                        <div class="col-xs-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Linked - Account</label>
                                                <input type="text"
                                                       class="form-control" disabled
                                                       @if(!empty($user['account_id'])) value="{{ $user['account_name'] }}" @endif>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-12">
                                        <div class="form-group mb-0">
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
        <form wire:submit.prevent="updateUser">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4   sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Profile</h3>
                    </div>
                    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                Name
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <input type="text" wire:model.lazy="user.name" id="first-name" autocomplete="given-name"
                                       class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="father-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                Father Name
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <input type="text" wire:model.lazy="user.father_name" id="father-name"
                                       autocomplete="given-name"
                                       class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                Email
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2 text-sm  sm:mt-px sm:pt-2">
                                {{ $user['email'] }}
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="photo" class="block text-sm font-medium text-gray-700">
                                Photo
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="flex items-center">
                                    @if(!empty($photo))
                                        <img class="h-12 w-12 rounded-full overflow-hidden"
                                             src="{{ $photo->temporaryUrl() }}">
                                    @elseif(!empty($user['attachment']))
                                        <img class="h-12 w-12 rounded-full overflow-hidden"
                                             src="{{ env('AWS_URL'). $user['attachment'] }}">
                                    @else
                                        <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                  <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                    <path
                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"></path>
                  </svg>
                </span>
                                    @endif


                                    @if(auth()->user()->can('1.edit-profile-photo'))
                                            <label for="file-upload"
                                                   class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <span>Change</span>
                                                <input id="file-upload" wire:model="photo" name="file-upload"
                                                       accept="image/png, image/jpeg" type="file" class="sr-only">
                                            </label>
                                    @endif

                                </div>
                            </div>
                        </div>

                        @if(config('user-management.link_user_account'))
                            <div
                                    class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Receivable Account
                                </label>
                                <div class="mt-1 sm:mt-0  text-sm sm:col-span-2  sm:mt-px sm:pt-2">
                                    @if(!empty($user['account_id']) )
                                        {{ $user['account_name'] }}
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    @include('ums::include.messages')
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" wire:loading.attr="disabled"
                            class="disabled:opacity-50 bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
@endif
