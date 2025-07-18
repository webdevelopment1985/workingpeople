@extends('admin.layouts.master')

@section('page_title')
    {{ __('user.create.title') }}
@endsection

@push('css')
    <style>
        #output {
            height: 300px;
            width: 300px;
        }
    </style>
@endpush

@section('content')
    <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="page-header">
            <div class="card breadcrumb-card">
                <div class="row justify-content-between align-content-between" style="height: 100%;">
                    <div class="col-md-6">
                        <h3 class="page-title">{{__('user.index.title')}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('settings.index') }}">{{ __('user.index.title') }}</a></li>
                            <li class="breadcrumb-item active-breadcrumb"><a
                                    href="{{ route('settings.create') }}">{{ __('user.create.title') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <div class="create-btn pull-right">
                            <button type="submit"
                                class="btn custom-create-btn">{{ __('default.form.save-button') }}</button>
                        </div>
                    </div>
                </div>
            </div><!-- /card finish -->	
        </div><!-- /Page Header -->


        <section class="crud-body">
			<div class="row">
				<div class="col-md-12">

					<div class="card">

						<div class="card-header">
							<h5 class="card-title">
								Page Information
							</h5>
						</div>
						
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">

									<div class="form-group">
										<label for="meta_key" class="required">{{__('default.form.meta_key')}}:</label>
										<input type="text" name="meta_key" id="meta_key" class="form-control @error('meta_key') form-control-error @enderror" required="required" value="{{old('meta_key')}}">

										@error('meta_key')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="meta_value" class="required">{{__("default.form.meta_value")}}:</label>
										<input type="text" name="meta_value" id="meta_value" class="form-control @error('meta_value') form-control-error @enderror" required="required" value="{{old('meta_value')}}">

										@error('meta_value')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="status" class="required">{{__("cmspage.form.status")}}:</label>

										<select type="text" name="status" id="status" class="form-control @error('status') form-control-error @enderror" required="required">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>

										@error('status')
											<span class="text-danger">{{ $message }}</span>
										@enderror									
									</div>

								</div>
							</div>
						</div>
					</div>  <!-- end card -->


				</div>
			</div>	
		</section>
    </form>
@endsection


@push('scripts')
<script>
	var loadFileImageFront = function(event) {
		var output = document.getElementById('output');
		output.src = URL.createObjectURL(event.target.files[0]);
	};
</script>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		document.getElementById('button-image').addEventListener('click', (event) => {

			event.preventDefault();
			inputId = 'image1';
			window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');

		});
	});

	// input
	let inputId = '';
	let output = 'output';

	// set file link
	function fmSetLink($url) {
		document.getElementById(inputId).value = $url;
		document.getElementById(output).src = $url;
	}
</script>
@endpush
