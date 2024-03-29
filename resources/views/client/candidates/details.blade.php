<x-app-layout data='Candidate Details'>

    			<!-- Row -->
			<div class="row">

				<!-- Dashboard Box -->
				<div class="col-xl-12">
					<div class="dashboard-box margin-top-0">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-material-outline-gavel"></i> Proposal Details</h3>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">


								<li>
									<!-- Job Listing -->
									<div class="job-listing width-adjustment">

										<!-- Job Listing Details -->
										<div class="job-listing-details">

											<!-- Details -->
											<div class="job-listing-description">
                                                <h3 class="job-listing-title"><a href="#">{{$freelancer->name }}</a>  <span class="dashboard-status-button green">{{$freelancer->pivot->status}}</span></h3>
												<h3 class="job-listing-title"><a href="#">{{$freelancer->pivot->description}}</a></h3>
											</div>
										</div>
									</div>

									<!-- Task Details -->
									<ul class="dashboard-task-info">
										<li><strong>{{$freelancer->pivot->cost}}$</strong><span>Hourly Rate</span></li>
										<li><strong>{{$freelancer->pivot->duration}} {{$freelancer->pivot->duration_unit}}</strong><span>Duration Time</span></li>
									</ul>

									<!-- Buttons -->
									<div class="buttons-to-right always-visible">

                                        @if ($freelancer->pivot->status == 'pending')

                                        <a href="{{route('client.candidate.accept',[$freelancer->id,$freelancer->pivot->id,$freelancer->pivot->project_id])}}" class="button green ripple-effect"><i class="icon-feather-file-text"></i> Accept Proposal</a>
                                        @endif
                                        <a href="{{route('freelancer.profile.show',$freelancer->id)}}" class="button blue ripple-effect"><i class="icon-feather-file-text"></i> View Profile</a>

										{{-- <a href="#" class="button red ripple-effect ico" title="Cancel Bid" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a> --}}
									</div>
								</li>
								{{-- <li>
									<!-- Job Listing -->
									<div class="job-listing width-adjustment">

										<!-- Job Listing Details -->
										<div class="job-listing-details">

											<!-- Details -->
											<div class="job-listing-description">
												<h3 class="job-listing-title"><a href="#">Build me a website in Angular JS</a></h3>
											</div>
										</div>
									</div>

									<!-- Task Details -->
									<ul class="dashboard-task-info">
										<li><strong>$2,550</strong><span>Fixed price</span></li>
										<li><strong>14 Days</strong><span>Delivery Time</span></li>
									</ul>

									<!-- Buttons -->
									<div class="buttons-to-right always-visible">
										<a href="#small-dialog" class="popup-with-zoom-anim button dark ripple-effect ico" title="Edit Bid" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
										<a href="#" class="button red ripple-effect ico" title="Cancel Bid" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
									</div>
								</li>
								<li>
									<!-- Job Listing -->
									<div class="job-listing width-adjustment">

										<!-- Job Listing Details -->
										<div class="job-listing-details">

											<!-- Details -->
											<div class="job-listing-description">
												<h3 class="job-listing-title"><a href="#">Android and iOS React Appe</a></h3>
											</div>
										</div>
									</div>

									<!-- Task Details -->
									<ul class="dashboard-task-info">
										<li><strong>$3,000</strong><span>Fixed Price</span></li>
										<li><strong>21 Days</strong><span>Delivery Time</span></li>
									</ul>

									<!-- Buttons -->
									<div class="buttons-to-right always-visible">
										<a href="#small-dialog" class="popup-with-zoom-anim button dark ripple-effect ico" title="Edit Bid" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
										<a href="#" class="button red ripple-effect ico" title="Cancel Bid" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
									</div>
								</li>
								<li>
									<!-- Job Listing -->
									<div class="job-listing width-adjustment">

										<!-- Job Listing Details -->
										<div class="job-listing-details">

											<!-- Details -->
											<div class="job-listing-description">
												<h3 class="job-listing-title"><a href="#">Write Simple Python Script</a></h3>
											</div>
										</div>
									</div>

									<!-- Task Details -->
									<ul class="dashboard-task-info">
										<li><strong>$30</strong><span>Hourly Rate</span></li>
										<li><strong>1 Day</strong><span>Delivery Time</span></li>
									</ul>

									<!-- Buttons -->
									<div class="buttons-to-right always-visible">
										<a href="#small-dialog" class="popup-with-zoom-anim button dark ripple-effect ico" title="Edit Bid" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
										<a href="#" class="button red ripple-effect ico" title="Cancel Bid" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
									</div>
								</li> --}}

							</ul>
						</div>
					</div>
				</div>

			</div>
			<!-- Row / End -->
</x-app-layout>
