<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
        {{$sr}}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" style="width: 40%; white-space: initial">
        {{ ucwords($s['description']) }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ ucwords($s['portal']) }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ ucwords($s['section']) }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        @if($user->hasPermissionTo($s['name']))
            <button class="text-red-600 text-bold hover:text-red-800" type="button"
                    wire:click="revoke('{{ $s['name'] }}')">Revoke
            </button>
        @else
            <button class="text-green-600 text-bold hover:text-green-800" type="button"
                    wire:click="assign('{{ $s['name'] }}')">Assign
            </button>
        @endif
    </td>
</tr>
