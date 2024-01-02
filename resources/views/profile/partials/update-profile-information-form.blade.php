<section>
    <header>
        <h2 class="text-lg font-medium">
            @lang('Profile Information')
        </h2>

        <p class="mt-1 text-sm">
            @lang("Update your account's profile information and email address.")
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 row">
        @csrf
        @method('patch')

        <table>
            <tr>
                <td>
                    <x-input-label for="profile_image" :value="__('Profile Image')" />
                </td>
                <td>
                    <x-file-input id="profile_image" name="profile_image" type="file" class="mt-1 block w-full"
                        :value="old('profile_img', $user->profile_img)" required autofocus autocomplete="name" />
                </td>
                <td>
                    <x-input-label for="nickname" :value="__('Nickname')" />
                </td>
                <td>
                    <x-text-input id="nickname" name="nickname" type="text" class="mt-1 block w-full"
                        :value="old('nickname', $user->nickname)" required autofocus autocomplete="nickname" />
                </td>
            </tr>
            <tr>
                <td>
                    <x-input-label for="biography" :value="__('Biography')" />
                </td>
                <td>
                    <textarea id="biography" name="biography" class="mt-1 block w-full" required>{{ old('biography', $user->biography) }}</textarea>
                </td>
                <td>
                    <x-input-label for="email" :value="__('Email')" />
                </td>
                <td>
                    <x-text-input id="email" name="email" type="emai" class="mt-1 block w-full"
                        :value="old('email', $user->email)" required autocomplete="username" />
                </td>
            </tr>
        </table>
        <div>
            <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
            <x-input-error :messages="$errors->get('biography')" class="mt-2" />
            <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
            @if ($user->nickname !== old('nickname', $user->nickname))
                @if (session('status') === 'nickname-not-unique')
                    <p class="mt-2 font-medium text-sm text-red-600">
                        @lang('The provided nickname is already in use by another user.')
                    </p>
                @endif
            @endif
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 ">
                        @lang('Your email address is unverified.')

                        <!-- Resend Verification Email Button -->
                        <button form="send-verification"
                            class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            @lang('Click here to re-send the verification email.')
                        </button>
                    </p>

                    <!-- Verification Link Sent Success Message -->
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            @lang('A new verification link has been sent to your email address.')
                        </p>
                    @endif
                </div>
            @endif

            <!-- Email Uniqueness Check -->
            @if ($user->email !== old('email', $user->email) && session('status') === 'email-not-unique')
                <p class="mt-2 font-medium text-sm text-red-600">
                    @lang('The provided email is already in use by another user.')
                </p>
            @endif
        </div>
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm">
                    @lang('Saved.')</p>
            @endif
        </div>
    </form>
</section>
