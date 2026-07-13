<x-admin-layout>
    <x-slot name="header">Lead Management</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Captured Leads</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Source</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Captured</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">newclient@example.com</td>
                        <td class="px-6 py-4">Landing Page</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-amber-100 text-amber-800">New</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500">5 mins ago</td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-brand-600 hover:text-brand-800 font-medium">Contact</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
