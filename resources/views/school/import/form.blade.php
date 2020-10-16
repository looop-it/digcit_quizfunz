@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="bg-white" style="padding:50px;">
                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <table class="table">
                            <thead>
                                <th colspan="2">學校資料</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>學校名稱</td>
                                    <td>{{ $registration->school->name }}</td>
                                </tr>
                                <tr>
                                    <td>負責老師</td>
                                    <td>{{ $registration->name }}</td>
                                </tr>
                                <tr>
                                    <td>聯絡電話</td>
                                    <td>{{ $registration->phone }}</td>
                                </tr>
                                <tr>
                                    <td>聯絡電郵</td>
                                    <td>{{ $registration->email }}</td>
                                </tr>

                                <tr>
                                    <td colspan="2" align="center">
                                        <form method="post" action="{{ route('student_account_import.logout') }}">
                                            {{ csrf_field() }}
                
                                            <button type="submit" class="btn btn-danger">登出</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-7 col-sm-12" >
                        <div class="row">
                            <div class="col-md-12">
                                <div id="upload-zone">
                                    <strong>上載學生名單 （<a href="/documents/template.xlsx" class="small">下載範本</a>）</strong>
                                    
                                    <form id="student-list-dropzone" class="dropzone" method="post" action="{{ route('student_account_import.store') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="school_registration_id" name="school_registration_id" value="{{ $registration->id }}">
                                    </form>
        
                                    <p class="small">支援csv, xls及xlsx檔案，大小限制：2 MB</p>
                                    <p class="small text-danger">*如學生帳號已存在，新資料將會覆蓋現有資料</p>
                                </div>
        
                                <div id="result" class="hidden">
                                    <strong>名單已成功上傳，請返回查看上載進度</strong>

                                    <p class="text-center">
                                        <a href="{{ route('student_account_import.index') }}" class="btn btn-info">返回</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if (count($registration->importLogs) > 0)
                        <div class="row" id="records">
                            <div class="col-md-12">
                                <hr />

                                <strong>上載紀錄</strong>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>上載時間</th>
                                            <th>處理狀態</th>
                                            <th>學生人數</td>
                                            <th class="text-success">成功</th>
                                            <th class="text-danger">失敗</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registration->importLogs as $log)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $log->created_at }}</td>
                                            <td>{{ $log->status == 'processing' ? "處理中" : ($log->status =='new' ? '未處理' : '已完成') }}</td>
                                            <td>{{ $log->statistics['total_count'] ?? '-' }}</td>
                                            <td>{{ $log->statistics['imported_count'] ?? '-' }}</td>
                                            <td>{{ $log->statistics['failed_count'] ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    var studentListDropzone = new Dropzone("#student-list-dropzone", {
        maxFiles: 1,
        acceptedFiles: ".xlsx,.xls,.csv",
        dictDefaultMessage: "將檔案拖到這裡上載 或 點擊這裡上載",
        maxFilesize: 3,
        addRemoveLinks: true,
        dictInvalidFileType: '不支援此類型的文件',
        dictRemoveFile: '移除文件',
        success: function (file, response) {
            $("#upload-zone").addClass("hidden");
            $("#records").addClass("hidden");

            $("#result").removeClass("hidden");

            // $("#total_count").html(response.total_count);
            // $("#imported_count").html(response.imported_count);
            // $("#failed_count").html(response.failed_count);
        }
    });
</script>
@endsection