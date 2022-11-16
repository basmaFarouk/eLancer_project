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

                    <h2>Send Verify Code</h2>

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

                    <!-- Form -->
                    <form method="post" id="login-form" action="{{ route('otp.create') }}">
                        @csrf
                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-lock"></i>
                            <input type="text" class="input-text with-border" name="mobile_number" id="mobile_number"
                                placeholder="Enter your Mobile" required />
                        </div>


                    </form>

                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit"
                        form="login-form">Send <i class="icon-material-outline-arrow-right-alt"></i></button>

                </div>

            </div>
        </div>
    </div>


    <!-- Spacer -->
    <div class="margin-top-70"></div>
    <!-- Spacer / End-->





</x-front-layout>
