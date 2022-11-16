<x-front-layout>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>{{__('Log In')}}</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">{{__('Home')}}</a></li>
						<li>{{__('Log In')}}</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Page Content
================================================== -->
<div class="container">
	<div class="row">
		<div class="col-xl-5 offset-xl-3">


			<div class="login-register-page">
				<!-- Welcome Text -->

                @if (Route::has('register'))

				<div class="welcome-text">
					<h3>{{__("We're glad to see you again!")}}</h3>
					<span>{{__("Don't have an account?")}} <a href="{{route('register')}}">{{__('Sign Up!')}}</a></span>
				</div>
                @endif

				<!-- Form -->
				{{-- <form method="post" id="login-form" action="{{route($routePrefix.'login')}}"> --}}
                    <form method="post" id="login-form" action="{{route('login')}}">
                    @csrf
					<div class="input-with-icon-left">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="email" class="input-text with-border" name="email" id="emailaddress" placeholder="Email Address" required/>
					</div>

					<div class="input-with-icon-left">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
					</div>

                    @if (Route::has('password.request'))

					<a href="{{route('password.request')}}" class="forgot-password">{{__('Forgot Password?')}}</a>
                    @endif
				</form>

				<!-- Button -->
				<button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" form="login-form">{{__('Log In')}}<i class="icon-material-outline-arrow-right-alt"></i></button>

				<!-- Social Login -->
				{{-- <div class="social-login-separator"><span>or</span></div>
				<div class="social-login-buttons">
					<button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Log In via Facebook</button>
					<button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Log In via Google+</button>
				</div> --}}
			</div>

		</div>
	</div>
</div>


<!-- Spacer -->
<div class="margin-top-70"></div>
<!-- Spacer / End-->



        {{-- <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form> --}}


</x-front-layout>
