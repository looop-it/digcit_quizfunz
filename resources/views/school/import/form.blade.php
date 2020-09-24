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
                        <div id="upload-zone">
                            <strong>上載學生名單 （<a href="/documents/template.xlsx" class="small">按我下載範本</a>）</strong>
                            
                            <form id="student-list-dropzone" class="dropzone" method="post" action="{{ route('student_account_import.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" id="school_id" name="school_id" value="{{ $registration->school->id }}">
                            </form>

                            <p class="small">支援csv, xls及xlsx檔案，大小限制：2 MB</p>
                            <p class="small text-danger">*如學生帳號已存在，新資料將會覆盖現有資料</p>
                        </div>

                        <div id="result-zone" class="hidden">
                            <strong>上載結果</strong>
                            <table class="table">
                                <tr>
                                    <td>上載紀錄</td>
                                    <td><span id="total_count">0</span></td>
                                </tr>
                                <tr>
                                    <td class="text-success">成功</td>
                                    <td><span id="imported_count">0</span></td>
                                </tr>
                                <tr>
                                    <td class="text-danger">失敗</td>
                                    <td><span id="failed_count">0</span></td>
                                </tr>
                            </table>

                            <p class="text-center">
                                <a href="{{ route('student_account_import.index') }}" class="btn btn-primary">重新上載</a>
                            </p>
                        </div>

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
            $("#result-zone").removeClass("hidden");

            $("#total_count").html(response.total_count);
            $("#imported_count").html(response.imported_count);
            $("#failed_count").html(response.failed_count);
        }
    });
</script>
@endsection