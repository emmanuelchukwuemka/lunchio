<x-admin-layout>
    <x-slot name="header">Roles & Permissions</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-semibold text-slate-900">Roles</h3>
                <p class="text-xs text-slate-500 mt-1">Structural roles used across the platform. Assign roles to individual users from the Users page.</p>
            </div>
            <ul class="divide-y divide-slate-100">
                @foreach($roles as $role)
                    <li class="px-6 py-4 flex justify-between items-center">
                        <span class="font-medium text-slate-900">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                        <span class="text-sm text-slate-500">{{ $role->users_count }} user{{ $role->users_count === 1 ? '' : 's' }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-semibold text-slate-900">Team Member Permissions</h3>
                <p class="text-xs text-slate-500 mt-1">Granular permissions founders can assign to their own team members.</p>
            </div>
            <ul class="divide-y divide-slate-100">
                @foreach($permissions as $permission)
                    <li class="px-6 py-4 flex justify-between items-center">
                        <span class="font-medium text-slate-900">{{ ucwords(str_replace('-', ' ', $permission->name)) }}</span>
                        <span class="text-sm text-slate-500">{{ $permission->users_count }} assigned</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-admin-layout>
