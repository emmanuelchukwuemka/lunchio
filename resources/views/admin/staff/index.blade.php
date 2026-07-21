<x-admin-layout>
    <x-slot name="header">Staff</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Launchio Team</h3>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-800">Manage All Users &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Active Orders</th>
                        <th class="px-6 py-4">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($staff as $member)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $member->name }}</td>
                            <td class="px-6 py-4">{{ $member->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium {{ $member->hasRole('admin') ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($member->roles->first()?->name ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $member->active_order_count }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $member->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">No staff members yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
