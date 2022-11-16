<x-app-layout data='My Proposals'>

    <!-- Row -->
<div class="row">

    <!-- Dashboard Box -->
    <div class="col-xl-12">
        <div class="dashboard-box margin-top-0">

            <!-- Headline -->
            <div class="headline">
                <h3><i class="icon-material-outline-business-center"></i> My Proposals</h3>
                <p> <x-flash-message /> <p>
            </div>

            <div class="content">
                <ul class="dashboard-box-list">
                    @foreach ($proposals as $proposal)


                    <li>
                        <!-- Job Listing -->
                        <div class="job-listing">

                            <!-- Job Listing Details -->
                            <div class="job-listing-details">

                                <!-- Logo -->
                                <!-- <a href="#" class="job-listing-company-logo">
                                    <img src="images/company-logo-05.png" alt="">
                                </a> -->

                                <!-- Details -->
                                <div class="job-listing-description">
                                    <h3 class="job-listing-title"><a href="#">{{$proposal->project->title}}</a> <span class="dashboard-status-button green">{{$proposal->status}}</span></h3>

                                    <!-- Job Listing Footer -->
                                    <div class="job-listing-footer">
                                        <ul>
                                            <li><i class="icon-material-outline-date-range"></i> Posted on {{$proposal->created_at}}</li>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="buttons-to-right always-visible">
                            <form action="{{route('freelancer.proposal.delete',$proposal->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="red button ripple-effect" type="submit">Delete</button>
                            </form>
                            {{-- <a href="dashboard-manage-candidates.html" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Candidates <span class="button-info">0</span></a> --}}


                        </div>
                    </li>

                    @endforeach

                </ul>
                {{$proposals->links()}}
            </div>
        </div>
    </div>

</div>
<!-- Row / End -->

</x-app-layout>
