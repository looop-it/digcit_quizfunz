<div class="col-md-4 col-sm-12">
    <div class="row mb-3">
        <div class="col-xs-12">
            <div class="section-container">
                <div class="section-title mb-3">Hi {{Auth::user()->name}}</div>
        
                <div class="section-content profile">
                    <div class="profile-item">
                        <a href="{{route('user.profile')}}" class="title">
                            個人資料
                        </a>
                    </div>
                    <hr>
                    <div class="profile-item">
                        <a href="{{route('competition.records')}}" class="title">
                            參賽記錄
                        </a>
                    </div>
                    <hr>
                </div>
        </div>
        </div>
    </div>
</div>