
    <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
        <form wire:submit.prevent="update2fa">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Google 2FA </h3>
                    </div>

                    @include('ums::include.messages')
                    <div class="grid grid-cols-6 gap-6 ">
                        <div class="col-span-6 sm:col-span-3 mt-1">
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Google 2FA Enabled?</label>
                            <select
                                    wire:model.defer="google2fa"
                                    id="google2fa_enabled"
                                   autocomplete="off"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Please Select</option>
                                <option value="t">Yes</option>
                                <option value="f">No</option>
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
    </div>

