@extends('storefront::public.layout')

@section('title', trans('storefront::messages.no_internet'))

@section('content')
	<section class="error-page-wrap">
		<div class="container">
			<div class="row error-page">
				<div class="col-xl-7 col-lg-8 col-md-18 error-page-left">
					<h1 class="section-title">{{ trans('storefront::messages.no_internet') }}</h1>

					<p>{{ trans('storefront::messages.connection_lost') }}</p>

					<a onClick="window.location.reload();" class="btn btn-default btn-back-to-home">
						{{ trans('storefront::storefront.try_again') }}
					</a>
				</div>

				<div class="col-xl-6 col-lg-7 col-md-18 error-page-right">
				    <!--Offline View Picture-->
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 570 466.01">
						<circle class="cls-1" cx="285" cy="233" r="150.91"/>
						<path class="cls-2"
								d="M273.08,264.07v90.59a28.4,28.4,0,0,1-28.4,28.4H107.54a21.11,21.11,0,0,0-21.11,21.11V462.6a3.65,3.65,0,0,1-3.64,3.65h0a3.65,3.65,0,0,1-3.64-3.65V404.17a28.39,28.39,0,0,1,28.39-28.4H244.68a21.11,21.11,0,0,0,21.11-21.11V264.07Z"/>
						<path class="cls-3"
								d="M281.28,283.62v14.52a6.27,6.27,0,0,1-6.28,6.27H263.87a6.24,6.24,0,0,1-4.77-2.2h0a6.24,6.24,0,0,1-1.5-4.07V283.62Z"/>
						<path class="cls-4"
								d="M293.65,249.78v29a8.11,8.11,0,0,1-8.11,8.11h-32.2a8.11,8.11,0,0,1-8.11-8.11v-29Z"/>
						<rect class="cls-5" x="241.28" y="243.39" width="56.31" height="6.38" rx="2.35"
								transform="translate(538.87 493.17) rotate(-180)"/>
						<path class="cls-6"
								d="M262.17,243.39h-8.25V223.66a4.13,4.13,0,0,1,4.12-4.13h0a4.13,4.13,0,0,1,4.13,4.13Z"/>
						<path class="cls-6"
								d="M279.74,219.53h2.19a3,3,0,0,1,3,3v20.83a0,0,0,0,1,0,0H276.7a0,0,0,0,1,0,0V222.57A3,3,0,0,1,279.74,219.53Z"/>
						<path class="cls-5"
								d="M293.65,249.78v29a8.11,8.11,0,0,1-8.11,8.11h-32.2a8.11,8.11,0,0,1-8.11-8.11c34.77-2.42,38-29,38-29Z"/>
						<rect class="cls-3" x="245.23" y="249.78" width="48.42" height="2.34"/>
						<path class="cls-3"
								d="M293.65,262v16.74a8.11,8.11,0,0,1-8.11,8.11H262.93C285.76,286.89,293.65,262,293.65,262Z"/>
						<rect class="cls-6" x="257.6" y="286.89" width="23.68" height="1.52"/>
						<rect class="cls-7" x="253.92" y="240.51" width="8.25" height="2.89"/>
						<rect class="cls-7" x="276.7" y="240.51" width="8.25" height="2.89"/>
						<path class="cls-6"
								d="M281.28,286.89v11.25a6.27,6.27,0,0,1-6.28,6.27H263.87a6.24,6.24,0,0,1-4.77-2.2h0c17.34,2.13,20-15.32,20-15.32Z"/>
						<path class="cls-2"
								d="M490.86,3.41h0a3.64,3.64,0,0,1-3.64,3.64h-193a21.11,21.11,0,0,0-21.11,21.11V123.9h-7.29V28.16a28.41,28.41,0,0,1,28.4-28.4h193A3.65,3.65,0,0,1,490.86,3.41Z"/>
						<path class="cls-3"
								d="M281.28,115.7V101.18A6.27,6.27,0,0,0,275,94.91H263.87a6.24,6.24,0,0,0-4.77,2.2h0a6.24,6.24,0,0,0-1.5,4.07V115.7Z"/>
						<path class="cls-4"
								d="M293.65,149.54v-29a8.11,8.11,0,0,0-8.11-8.11h-32.2a8.11,8.11,0,0,0-8.11,8.11v29Z"/>
						<rect class="cls-5" x="241.28" y="149.54" width="56.31" height="6.38" rx="2.35"
								transform="translate(538.87 305.47) rotate(-180)"/>
						<path class="cls-5"
								d="M293.65,149.54v-29a8.11,8.11,0,0,0-8.11-8.11h-32.2a8.11,8.11,0,0,0-8.11,8.11c34.77,2.42,38,29,38,29Z"/>
						<rect class="cls-3" x="245.23" y="147.2" width="48.42" height="2.34"/>
						<path class="cls-3"
								d="M293.65,137.28V120.54a8.11,8.11,0,0,0-8.11-8.11H262.93C285.76,112.43,293.65,137.28,293.65,137.28Z"/>
						<rect class="cls-6" x="257.6" y="110.92" width="23.68" height="1.52"/>
						<path class="cls-6"
								d="M281.28,112.43V101.18A6.27,6.27,0,0,0,275,94.91H263.87a6.24,6.24,0,0,0-4.77,2.2h0c17.34-2.13,20,15.32,20,15.32Z"/>
						<path class="cls-4" d="M205.93,181.25h-15a2.07,2.07,0,1,1,0-4.13h15a2.07,2.07,0,0,1,0,4.13Z"/>
						<path class="cls-4"
								d="M225,162.22a2.07,2.07,0,0,1-2.07-2.07v-15a2.07,2.07,0,0,1,4.13,0v15A2.07,2.07,0,0,1,225,162.22Z"/>
						<path class="cls-4"
								d="M211.2,167.49a2,2,0,0,1-1.46-.61l-10.3-10.29a2.06,2.06,0,0,1,2.92-2.92l10.3,10.3a2.07,2.07,0,0,1-1.46,3.52Z"/>
						<path class="cls-4" d="M333,227.68h15a2.07,2.07,0,0,1,0,4.13H333a2.07,2.07,0,1,1,0-4.13Z"/>
						<path class="cls-4"
								d="M313.92,246.71a2.06,2.06,0,0,1,2.06,2.06v15a2.07,2.07,0,1,1-4.13,0v-15A2.07,2.07,0,0,1,313.92,246.71Z"/>
						<path class="cls-4"
								d="M327.67,241.44a2.06,2.06,0,0,1,1.46.6l10.3,10.3a2.06,2.06,0,1,1-2.92,2.92L326.22,245a2.06,2.06,0,0,1,1.45-3.52Z"/>
					    <style>
                    		.cls-1 {
                    			fill: #f6f5f8;
                    		}

                    		.cls-2 {
                    			fill: #2c447d;
                    		}

                    		.cls-3 {
                    			fill: #2b3872;
                    		}

                    		.cls-4 {
                    			fill: #4656a1;
                    		}

                    		.cls-5 {
                    			fill: #38488c;
                    		}

                    		.cls-6 {
                    			fill: #232851;
                    		}

                    		.cls-7 {
                    			fill: #15172d;
                    		}
                        </style>
					</svg>
				</div>
			</div>
		</div>
	</section>
@endsection
