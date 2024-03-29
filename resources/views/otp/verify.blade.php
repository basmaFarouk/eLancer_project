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

                    <h2>Verify Code</h2>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li>Log In</li>
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
                            <h3>We're glad to see you again!</h3>

                        </div>
                    @endif

                    <!-- Form -->
                    {{-- <form method="post" id="login-form" action="{{route($routePrefix.'login')}}"> --}}
                    <form method="post" id="login-form" action="{{ route('otp.verify') }}">
                        @csrf


                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-lock"></i>
                            <input type="text" class="input-text with-border" name="code" id="code"
                                placeholder="Enter the Code" required />
                        </div>


                    </form>

                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit"
                        form="login-form">Verify <i class="icon-material-outline-arrow-right-alt"></i></button>

                </div>

            </div>
        </div>
    </div>


    <!-- Spacer -->
    <div class="margin-top-70"></div>
    <!-- Spacer / End-->





</x-front-layout>
