@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
    @php $link = url('') @endphp
    @for($i = 1; $i <= count(Request::segments()); $i++)
        @if($i < count(Request::segments()) && $i > 0)
            @php $link .= "/" . Request::segment($i); @endphp
            <a href="{{ $link }}">{{ ucwords(str_replace('-',' ',Request::segment($i)))}}</a> >
        @else {{ucwords(str_replace('-',' ',Request::segment($i)))}}
        @endif
    @endfor
@stop

@section('content')
    <div class="row pt-3">
        <div class="col-md-6">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title text-bold"><i class="fas fa-shield-alt mr-2"></i> Keamanan Akun</h3>
                </div>
                
                <form action="{{ route('admin.password.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="icon fas fa-check"></i> {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label>Password Saat Ini</label>
                            <input type="password" name="current_password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   placeholder="Masukkan password lama" required>
                            @error('current_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Gunakan kombinasi yang kuat" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" 
                                   placeholder="Ulangi password baru" required>
                        </div>
                    </div>

                    <div class="card-footer bg-white text-right">
                        <button type="submit" class="btn btn-danger btn-flat">
                            <i class="fas fa-save mr-1"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-5">
            <div class="callout callout-info shadow-sm">
                <h5><i class="fas fa-lightbulb text-warning mr-2"></i> Tips</h5>
                <p class="text-muted text-sm">
                    Setelah password berhasil diubah, pastikan Anda mengingatnya dengan baik. Sistem tidak akan melakukan logout otomatis kecuali Anda mengaturnya secara manual di Controller.
                </p>
            </div>
        </div>
    </div>
@stop