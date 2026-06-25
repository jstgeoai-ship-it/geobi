<x-guest-layout>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- EMAIL -->
        <div>
            <label>Email</label>

            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="w-full border p-2 rounded"
                   required>

            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- PASSWORD -->
        <div class="mt-4">
            <label>Password</label>

            <input type="password"
                   name="password"
                   class="w-full border p-2 rounded"
                   required>

            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- BUTTON -->
        <div class="mt-6">
            <button class="bg-orange-500 text-white px-4 py-2 rounded">
                Login
            </button>
        </div>

    </form>

</x-guest-layout>