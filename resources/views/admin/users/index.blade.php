<x-admin-layout>
    <x-slot name="header">
        User Management
    </x-slot>

    <div class="mb-10 flex flex-col xl:flex-row xl:items-end justify-between gap-6 border-b border-slate-200 pb-8">
        <div>
            <h2 class="text-xl font-medium text-slate-900">All System Users</h2>
            <p class="mt-2 text-sm text-slate-500">Manage customers, staff members, and administrators.</p>
        </div>
        
        <!-- Add User Form -->
        <div class="bg-slate-50 p-4 rounded-md border border-slate-200 w-full xl:w-auto">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Add New User</h3>
            <form action="{{ route('admin.users.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="text" name="name" placeholder="Full Name" required class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                <input type="email" name="email" placeholder="Email Address" required class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                <input type="password" name="password" placeholder="Password" required class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                <select name="role" required class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-md hover:bg-slate-800 transition">Create</button>
            </form>
            @if($errors->any())
                <div class="mt-2 text-xs text-red-600 font-medium">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-left">
            <thead>
                <tr class="border-b border-slate-200">
                    <th scope="col" class="py-3 pr-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">User</th>
                    <th scope="col" class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Joined</th>
                    <th scope="col" class="relative py-3 pl-6"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                    <tr class="group transition-colors hover:bg-slate-50/50">
                        <td class="py-4 pr-6 align-middle">
                            <div class="text-sm font-medium text-slate-900">{{ $user->name }}</div>
                            @if($user->company_name)
                                <div class="text-xs text-slate-500 mt-0.5">{{ $user->company_name }}</div>
                            @endif
                        </td>
                        <td class="py-4 px-6 align-middle">
                            <div class="text-sm text-slate-600">{{ $user->email }}</div>
                        </td>
                        <td class="py-4 px-6 align-middle">
                            <div class="flex items-center gap-2">
                                @php
                                    $userRole = $user->roles->first()?->name ?? 'None';
                                    $roleBadgeColors = [
                                        'admin' => 'bg-purple-100 text-purple-800',
                                        'staff' => 'bg-blue-100 text-blue-800',
                                        'outside_expert' => 'bg-amber-100 text-amber-800',
                                        'customer' => 'bg-slate-100 text-slate-800',
                                    ];
                                    $badgeClass = $roleBadgeColors[$userRole] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $userRole)) }}
                                </span>
                            </div>
                        </td>
                        <td class="py-4 px-6 align-middle">
                            <div class="text-sm text-slate-500">{{ $user->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="py-4 pl-6 align-middle text-right">
                            <form action="{{ route('admin.users.role.update', $user) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="text-xs py-1.5 pl-2 pr-6 border-slate-300 rounded shadow-sm focus:ring-brand-500 focus:border-brand-500" onchange="this.form.submit()">
                                    <option value="" disabled {{ !$user->roles->count() ? 'selected' : '' }}>Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
        <div class="mt-8 pt-4 border-t border-slate-200">
            {{ $users->links() }}
        </div>
    @endif
</x-admin-layout>
