<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="footer text-center">
				@if(Agent::isMobile())
					<img src="/home/img/organization.jpg" class="img-fluid" usemap="#image-map-mobile"/>

					{{-- <map name="image-map-mobile">
						<area target="_blank" alt="青識教育基金會" title="青識教育基金會" coords="72,32,341,138" shape="rect">
						<area target="_blank" alt="史檔" title="史檔" href="https://shifiles.hk/" coords="70,319,339,414" shape="rect">
						<area target="_blank" alt="圈傳媒" title="圈傳媒" href="https://www.looop.hk" coords="71,484,336,586" shape="rect">
					</map> --}}
				@else
					<img src="/home/img/organization.jpg" class="img-fluid" usemap="#image-map"/>
{{-- 
					<map name="image-map">
						<area target="_blank" alt="青識教育基金會" title="青識教育基金會" coords="51,28,184,88" shape="rect">
						<area target="_blank" alt="史檔" title="史檔" href="https://shifiles.hk/" coords="383,27,540,79" shape="rect">
						<area target="_blank" alt="香港青年聯會" title="香港青年聯會" href="http://www.hkuya.org.hk/web15/web" coords="383,27,540,79" shape="rect">
						<area target="_blank" alt="圈傳媒" title="圈傳媒" href="https://www.looop.hk" coords="600,27,745,85" shape="rect">
					</map> --}}

				@endif

				<div class="links">
					<ul class="horizontal">
						<li>
							<a href="{{ route('page.detail', ['slug' => '私隱聲明']) }}">{{trans('home.footer.privacy')}}</a>
							<div class="line"></div>
						</li>
						<li>
							<a href="{{ route('page.detail', ['slug' => '免責條款']) }}">{{trans('home.footer.disclaimer')}}</a>
							<div class="line"></div>
						</li>
						<li>
							<a href="{{ route('page.detail', ['slug' => '關於我們']) }}">{{trans('home.footer.about_us')}}</a>
							<div class="line"></div>
						</li>
						<li>
							<a href="{{ route('page.detail', ['slug' => '聯絡我們']) }}">{{trans('home.footer.contact_us')}}</a>
						</li>
					</ul>
				</div>

				<div class="copyright">
					<p> 版權所有 &copy; 青識教育發展中心</p>
				</div>
			</div>
		</div>
	</div>
</div>
