<x-app-layout data='Projects'>

    			<!-- Row -->
			<div class="row">

				<!-- Dashboard Box -->
				<div class="col-xl-12">
					<div class="dashboard-box margin-top-0">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-material-outline-business-center"></i> My Job Listings</h3>
                            <p> <x-flash-message /> </p>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">
                                @foreach ($projects as $project)


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
												<h3 class="job-listing-title"><a href="{{route('projects.show',$project->id)}}">{{$project->title}}</a> <span class="dashboard-status-button green">{{$project->status}}</span></h3>

												<!-- Job Listing Footer -->
												<div class="job-listing-footer">
													<ul>
														<li><i class="icon-material-outline-date-range"></i> Posted on {{$project->created_at}}</li>
														<li><i class="icon-material-outline-date-range"></i> Category : {{$project->category->parent->name ?? ''}} // {{$project->category->name ?? ''}}</li>
                                                        <li>
                                                            @foreach ($project->tags as $tag)
                                                                <span class="badge rounded-pill text-bg-success">{{$tag->name}}</span>
                                                            @endforeach
                                                        </li>
													</ul>
												</div>
											</div>
										</div>
									</div>

									<!-- Buttons -->
									<div class="buttons-to-right always-visible">
										<a href="{{route('client.candidate',$project->id)}}" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Candidates <span class="button-info">{{$project->proposedFreelnacers()->count()}}</span></a>
										<a href="{{route('client.projects.edit',$project->id)}}" class="button gray ripple-effect ico" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                        <form action="{{route('client.projects.destroy',$project->id)}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="button gray ripple-effect ico" title="Remove" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></button>
                                        </form>
									</div>
								</li>

                                @endforeach

							</ul>
						</div>
                         {{$projects->links()}}
					</div>
				</div>

			</div>
			<!-- Row / End -->

</x-app-layout>
