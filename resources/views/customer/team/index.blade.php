<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Team') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div>
                <h3 class="text-xl font-sora font-bold text-slate-900">Your Team</h3>
                <p class="text-slate-500 mt-1">Invite people to help run your business. Give them a login and choose exactly what they can do &mdash; they'll only ever see your business, never anyone else's.</p>
            </div>

            <!-- Add Team Member -->
            <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100 p-8">
                <h4 class="text-lg font-sora font-bold text-slate-900 mb-4">Add a Team Member</h4>
                <form action="{{ route('team.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Full Name</label>
                            <input type="text" name="name" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Login Email</label>
                            <input type="email" name="email" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Password</label>
                            <input type="text" name="password" required minlength="8" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">What can they do?</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($availablePermissions as $permission)
                                <label class="flex items-center gap-2 text-sm text-slate-700 bg-slate-50 rounded-lg px-3 py-2 border border-slate-100">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission }}" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                    {{ ucwords(str_replace('-', ' ', $permission)) }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="inline-flex items-center px-5 py-2.5 border border-transparent shadow-sm text-sm font-semibold rounded-md text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                        Create Team Member
                    </button>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </form>
            </div>

            <!-- Team List -->
            <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100">
                    <h4 class="text-lg font-sora font-bold text-slate-900">Team Members</h4>
                </div>

                @if($teamMembers->isEmpty())
                    <p class="text-sm text-slate-500 p-8 text-center">You haven't added any team members yet.</p>
                @else
                    <ul class="divide-y divide-slate-100">
                        @foreach($teamMembers as $member)
                            <li class="p-6">
                                <div class="flex items-center justify-between gap-4 flex-wrap">
                                    <div>
                                        <p class="font-medium text-slate-900">{{ $member->name }}</p>
                                        <p class="text-sm text-slate-500">{{ $member->email }}</p>
                                    </div>
                                    <form action="{{ route('team.destroy', $member) }}" method="POST" onsubmit="return confirm('Remove {{ $member->name }} from your team?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Remove</button>
                                    </form>
                                </div>

                                <form action="{{ route('team.permissions.update', $member) }}" method="POST" class="mt-4">
                                    @csrf
                                    @method('PATCH')
                                    @php $memberPermissions = $member->permissions->pluck('name')->toArray(); @endphp
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($availablePermissions as $permission)
                                            <label class="flex items-center gap-2 text-sm text-slate-700 bg-slate-50 rounded-lg px-3 py-2 border border-slate-100">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission }}" onchange="this.form.submit()" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500" @checked(in_array($permission, $memberPermissions))>
                                                {{ ucwords(str_replace('-', ' ', $permission)) }}
                                            </label>
                                        @endforeach
                                    </div>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
