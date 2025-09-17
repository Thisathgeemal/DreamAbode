<x-guest-layout>

    <!-- Main Content -->
    <section class="flex items-center justify-center mt-16 px-4 sm:px-6 lg:px-0">
        <div class="w-full max-w-2xl p-6 sm:p-10 bg-white rounded-2xl shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-800 mb-6 sm:mb-8">
                Select Your Role
            </h2>

            @php
                // Allowed roles in order
                $allowedRoles = ['admin', 'agent', 'member'];

                // Only display roles the user has
                $displayRoles = array_values(array_filter($allowedRoles, fn($role) => in_array($role, $roles)));

                // Icons for roles
                $icons = [
                    'admin' => 'fa-solid fa-user-tie',
                    'agent' => 'fa-solid fa-briefcase',
                    'member' => 'fa-solid fa-user',
                ];

                $roleCount = count($displayRoles);
            @endphp

            @if ($roleCount > 0)
                <form action="{{ route('role.selection.store') }}" method="POST">
                    @csrf

                    <div @class([
                        'grid gap-4 sm:gap-6',
                        'grid-cols-1 sm:grid-cols-1 justify-items-center' => $roleCount === 1,
                        'grid-cols-1 sm:grid-cols-2 justify-items-center' => $roleCount === 2,
                        'grid-cols-1 sm:grid-cols-3 justify-items-center sm:justify-items-stretch' =>
                            $roleCount === 3,
                    ])>
                        @foreach ($displayRoles as $role)
                            @php
                                $lowerRole = strtolower($role);
                            @endphp

                            <button type="submit" name="role" value="{{ $role }}"
                                class="flex flex-col items-center mb-6 justify-center gap-3 p-5 sm:p-6 rounded-xl shadow-md transition-all duration-300 transform bg-white text-gray-800 border border-gray-200 hover:bg-green-50 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full sm:w-48">
                                <i class="{{ $icons[$lowerRole] ?? 'fa-solid fa-user' }} text-3xl sm:text-4xl"></i>
                                <span class="text-base sm:text-lg font-semibold">{{ ucfirst($role) }}</span>
                            </button>
                        @endforeach
                    </div>
                </form>
            @else
                <div class="text-red-600 text-center text-lg mt-4">
                    No roles available.
                </div>
            @endif
        </div>
    </section>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d32f2f'
            });
        </script>
    @endif

</x-guest-layout>
