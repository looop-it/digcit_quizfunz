	
<div class="section-top col-md-4 col-sm-12 col-xs-12 col-md-pull-8">
	<!--左側最新消息-->
	@if(!Agent::isMobile())
		<div class="section-middle clearfix">
			<div class="col-md-12">
				@include('home.comm.latest_news')
			</div>
		</div>
	@endif

	<!--左側導讀及參考資料-->
	<div class="section-middle clearfix section-other">
		<div class="col-md-12">
			@include('home.comm.referenceMaterial')
		</div>
	</div>
</div>