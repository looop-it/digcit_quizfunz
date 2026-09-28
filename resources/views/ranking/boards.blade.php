<div class="row ranking-section">
	@forelse ($rankings as $ranking)
		@include('ranking.list', [
			'type' => $ranking['type'],
			'title' => $ranking['title'],
			'ranks' => $ranking['ranks']
		])
	@empty
		<p class="ranking-empty">暫時未有排行資料。</p>
	@endforelse
</div>
