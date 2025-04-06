<!-- resources/views/auth/login.blade.php -->
<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium leading-6 text-gray-900" />
                    <div class="mt-2">
                        <x-text-input id="email" class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between">
                        <x-input-label for="password" :value="__('Mot de passe')" class="block text-sm font-medium leading-6 text-gray-900" />
                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-semibold text-blue-600 hover:text-blue-500">Mot de passe oublié?</a>
                            </div>
                        @endif
                    </div>
                    <div class="mt-2">
                        <x-text-input id="password" class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                      type="password"
                                      name="password"
                                      required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">{{ __('Se souvenir de moi') }}</label>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        {{ __('Se connecter') }}
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Pas encore de compte?
                <a href="{{ route('register') }}" class="font-semibold leading-6 text-blue-600 hover:text-blue-500">S'inscrire</a>
            </p>
        </div>
    </div>
</x-guest-layout>