<x-app-layout data='Change Password'>
    <x-flash-message />
    <form action="{{route('freelancer.password.edit')}}" method="POST">
        @csrf
    				<!-- Dashboard Box -->
                    <div class="col-xl-12">
                        <div id="test1" class="dashboard-box">

                            <!-- Headline -->
                            <div class="headline">
                                <h3><i class="icon-material-outline-lock"></i> Password & Security</h3>
                            </div>

                            <div class="content with-padding">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Current Password</h5>
                                            <input type="password" class="with-border" name="current_pass">
                                        </div>
                                        @error('current_pass')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>New Password</h5>
                                            <input type="password" class="with-border" name="password">
                                        </div>
                                        @error('password')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Repeat New Password</h5>
                                            <input type="password" class="with-border" name="password_confirmation">
                                        </div>
                                        @error('password_confirmation')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <button type="submit" class="button ripple-effect big margin-top-30">Save Changes</button>
                    </div>

    </form>
</x-app-layout>
