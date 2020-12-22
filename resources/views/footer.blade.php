<div class="container footer">
	{{-- <div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="sponsors text-center">
				<div class="row visible-md-block visible-lg-block">
					<div class="col-md-offset-1 col-md-10">
						<div class="logo-container">
							<div class="col"><img src="/images/footer/logo/logo_1.jpg" class="img-fluid"></div>
							<div class="col"><img src="/images/footer/logo/logo_2.jpg" class="img-fluid"></div>
							<div class="col"><img src="/images/footer/logo/logo_3.jpeg" class="img-fluid"></div>
							<div class="col"><img src="/images/footer/logo/logo_4.jpeg" class="img-fluid"></div>
							<div class="col"><img src="/images/footer/logo/logo_5.jpeg" class="img-fluid"></div>
							<div class="col"><img src="/images/footer/logo/logo_6.jpeg" class="img-fluid"></div>
							<div class="col"><img src="/images/footer/logo/logo_7.jpg" class="img-fluid"></div>
						</div>
					</div>
				</div>

				<div class="row visible-md-block visible-lg-block">
					<div class="col-md-offset-1 col-md-10">
						<div class="logo-container">
							<div class="col"><img src="/images/footer/logo/logo_8.jpg" class="img-fluid"></div>
							<div class="col"><img src="/images/footer/logo/logo_9.jpeg" class="img-fluid"></div>
							<div class="col"><img src="/images/footer/logo/logo_10.jpeg" class="img-fluid"></div>
						</div>
					</div>
				</div>

				<div class="row visible-xs">
					<div class="col-xs-12 title">
						<strong>主辦機構</strong>
					</div>
					<div class="col-xs-12">
						<img src="/images/footer/mobile_logo_1.png" class="img-fluid">
					</div>
					
					<div class="col-xs-12 title"><strong>協辦機構</strong></div>
					<div class="col-xs-12">
						<img src="/images/footer/mobile_logo_2.png" class="img-fluid">
					</div>
					<div class="col-xs-12 title"><strong>全力支持</strong></div>
					<div class="col-xs-10">
						<img src="/images/footer/mobile_logo_3.jpeg" class="img-fluid">
					</div>
					<div class="col-xs-12">
						<img src="/images/footer/mobile_logo_4.jpeg" class="img-fluid">
					</div>
				</div>
			</div>
		</div>
	</div> --}}

	<div class="row">
		<div class="col-md-12">
			<div class="links">
				<ul class="horizontal">
					<li>
						<a href="{{ route('page.detail', ['slug' => '私隱聲明']) }}">{{trans('home.footer.privacy')}}</a>
					</li>
					<li>
						<a href="{{ route('page.detail', ['slug' => '免責條款']) }}">{{trans('home.footer.disclaimer')}}</a>
					</li>
					<li>
						<a href="{{ route('page.detail', ['slug' => '關於我們']) }}">{{trans('home.footer.about_us')}}</a>
					</li>
					<li>
						<a href="{{ route('enquiry') }}">{{trans('home.footer.contact_us')}}</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="copyright">
				青識教育發展中心版權所有 <br> Copyright &copy; 2020 Youthinkers ltd. All rights reserved.
			</div>
		</div>
	</div>
</div>