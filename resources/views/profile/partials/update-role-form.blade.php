<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update User Role') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Change the role of a registered user by entering their email address.') }}
        </p>
    </header>

    <!-- Feedback -->
    @if (session('status'))
        <div class="mt-4 bg-green-100 text-green-700 p-4 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <!-- Form Update Role -->
    <form method="POST" action="{{ route('update.role') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('User Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required
                placeholder="Enter the user's email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="role" :value="__('New Role')" />
            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="user">{{ __('User') }}</option>
                <option value="admin">{{ __('Admin') }}</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update Role') }}</x-primary-button>
        </div>
    </form>

    <!-- Data User dengan Role Admin -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            {{ __('Users with Admin Role') }}
        </h3>

        @if ($adminUsers->isNotEmpty())
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 text-left">No</th>
                            <th class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 text-left">{{ __('Name') }}</th>
                            <th class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 text-left">{{ __('Email') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adminUsers as $index => $user)
                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="px-4 py-2 border border-gray-300 text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border border-gray-300 text-sm text-gray-700">{{ $user->name }}</td>
                                <td class="px-4 py-2 border border-gray-300 text-sm text-gray-700">{{ $user->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-600">{{ __('No users with admin role found.') }}</p>
        @endif
    </div>
</section>
