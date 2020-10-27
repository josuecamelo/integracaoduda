<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo/>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <p class="criar-conta-text">Criar Conta</p>

            <div class="my-3">
                <x-jet-label class="text-base text-base-800" for="name" value="{{ __('Nome') }}"/>
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                             autofocus autocomplete="name"/>
            </div>

            <div class="mt-4">
                <x-jet-label class="text-base text-base-800" for="email" value="{{ __('Email') }}"/>
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                             required/>
            </div>

            <div class="mt-4">
                <x-jet-label class="text-base text-base-800" for="password" value="{{ __('Senha') }}"/>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                             autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <x-jet-label  class="text-base text-base-800" for="password_confirmation" value="{{ __('Confirme sua Senha') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label class="text-base text-base-800" for="whatsapp" value="{{ __('Seu Whatsapp') }}"/>
                <x-jet-input id="whatsapp" class="block mt-1 w-full" type="text" name="whatsapp" required
                             autocomplete="whatsapp"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button
                    class="buttons w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded
                            shadow-lg hover:shadow-xl rounded-full mr-2 transition duration-200"
                    type="submit">Criar Conta
                </button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
