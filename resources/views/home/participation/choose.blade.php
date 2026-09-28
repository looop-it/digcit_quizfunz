@extends('layouts.app')

@section('style')
<style>
	.season-pick {
		margin-top: 12px;
		padding: 28px 32px 36px;
	}

	.season-pick .section-title {
		margin-bottom: 0;
		padding: 12px 18px;
	}

	.season-pick-lead {
		margin: 22px 4px 28px;
		color: #414549;
		font-size: 16px;
		line-height: 1.6;
	}

	.season-card-grid {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 16px;
	}

	.season-card-form {
		margin: 0;
		min-width: 0;
	}

	.season-card {
		display: flex;
		width: 100%;
		height: 100%;
		text-align: left;
		border: 1px solid rgba(186, 230, 255, 0.75);
		border-radius: 16px;
		padding: 0;
		cursor: pointer;
		color: #fff;
		background:
			linear-gradient(180deg, rgba(255, 255, 255, 0.28), rgba(255, 255, 255, 0) 46%),
			linear-gradient(160deg, #3aa7f5 0%, #1574d6 46%, #0b4ea3 100%);
		box-shadow: 0 12px 28px rgba(10, 58, 140, 0.24);
		overflow: hidden;
		transition: transform .15s ease, box-shadow .15s ease;
	}

	.season-card:hover,
	.season-card:focus {
		transform: translateY(-3px);
		box-shadow: 0 16px 32px rgba(12, 90, 190, 0.34);
		outline: none;
	}

	.season-card:focus {
		box-shadow: 0 0 0 3px #fff, 0 0 0 6px #3ec6ff;
	}

	.season-card.is-open {
		background:
			linear-gradient(180deg, rgba(255, 255, 255, 0.32), rgba(255, 255, 255, 0) 46%),
			linear-gradient(160deg, #49c8ff 0%, #1a86e8 48%, #0c5cb8 100%);
	}

	.season-card.is-school {
		background:
			linear-gradient(180deg, rgba(255, 255, 255, 0.18), rgba(255, 255, 255, 0) 46%),
			linear-gradient(160deg, #2458c8 0%, #16367f 52%, #0a1f52 100%);
	}

	.season-card-body {
		display: flex;
		flex-direction: column;
		width: 100%;
		padding: 24px 22px 20px;
	}

	.season-badge {
		display: inline-block;
		align-self: flex-start;
		margin-bottom: 14px;
		padding: 6px 14px;
		border-radius: 999px;
		background: rgba(255, 255, 255, 0.22);
		font-size: 13px;
		font-weight: bold;
		letter-spacing: 0.04em;
	}

	.season-card-name {
		display: block;
		margin: 0 0 12px;
		font-size: 26px;
		font-weight: bold;
		line-height: 1.3;
	}

	.season-card-desc {
		display: block;
		margin: 0 0 20px;
		font-size: 15px;
		line-height: 1.65;
		flex: 1;
		color: rgba(255, 255, 255, 0.92);
	}

	.season-card-meta {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 16px;
		padding-top: 16px;
		border-top: 1px solid rgba(255, 255, 255, 0.28);
		font-size: 14px;
	}

	.season-card-go {
		flex: none;
		font-weight: bold;
		font-size: 15px;
	}

	@media (max-width: 767px) {
		.season-card-grid {
			grid-template-columns: 1fr;
		}

		.season-pick {
			padding: 18px 16px 24px;
		}

		.season-card-body {
			padding: 22px 20px 18px;
		}

		.season-card-name {
			font-size: 22px;
		}

		.season-card-meta {
			flex-direction: column;
			align-items: flex-start;
		}
	}
</style>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="content-container">
                <div class="row">
					@include('left_panel')

					<div class="col-md-8 col-sm-12">
                        <div class="section-container season-pick">
							<div class="section-title mb-3">選擇比賽</div>
							<p class="season-pick-lead">現時有多個比賽同時進行，請選擇要參加的比賽。</p>

							@if ($errors->any())
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif

							<div class="season-card-grid">
							@foreach ($seasons as $season)
								@php $isSchool = $season->requiresSchoolCode(); @endphp
								<form class="season-card-form" action="{{ route('competition.choose.store') }}" method="post">
									{{ csrf_field() }}
									<input type="hidden" name="season_id" value="{{ $season->id }}">
									<button type="submit" class="season-card {{ $isSchool ? 'is-school' : 'is-open' }}">
										<span class="season-card-body">
											<span class="season-badge">{{ $isSchool ? '校際賽' : '公開賽' }}</span>
											<span class="season-card-name">{{ $season->name }}</span>
											<span class="season-card-desc">
												@if ($isSchool)
													只供報名學校的學生參加，需輸入學校參賽代碼。
												@else
													所有已登入學生均可參加，無需參賽代碼。
												@endif
											</span>
											<span class="season-card-meta">
												<span>
													{{ \Carbon\Carbon::parse($season->start_at)->format('Y年m月d日') }}
													至
													{{ \Carbon\Carbon::parse($season->end_at)->format('Y年m月d日') }}
												</span>
												<span class="season-card-go">進入這場比賽 →</span>
											</span>
										</span>
									</button>
								</form>
							@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
