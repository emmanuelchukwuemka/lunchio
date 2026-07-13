<x-admin-layout>
    <x-slot name="header">System Audit Logs</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Audit Trail</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Action</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">IP Address</th>
                        <th class="px-6 py-4">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">User logged in</td>
                        <td class="px-6 py-4 text-slate-500">admin@launchio.test</td>
                        <td class="px-6 py-4 text-slate-500">127.0.0.1</td>
                        <td class="px-6 py-4 text-slate-500">Just now</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
