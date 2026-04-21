@extends('adminlte::page')

@section('title', 'Dashboard Wedding')

@section('content_header')
    <h1>Monitoring Undangan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalTamu }}</h3>
                    <p>Total Daftar Tamu</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.guests.index') }}" class="small-box-footer">
                    Kelola Data <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $waTerkirim }}</h3>
                    <p>WA Terkirim</p>
                </div>
                <div class="icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="small-box-footer">
                    Progress: {{ $totalTamu > 0 ? round(($waTerkirim / $totalTamu) * 100) : 0 }}%
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $sudahIsi }}</h3>
                    <p>Sudah Isi RSVP</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <a href="{{ route('admin.guests.index') }}?filter=sudah_isi" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $belumIsi }}</h3>
                    <p>Belum Isi RSVP</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <a href="{{ route('admin.guests.index') }}?filter=belum_isi" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Petunjuk Cepat</h5>
                <p>Gunakan tombol <b>WA Terkirim</b> untuk memantau tamu mana saja yang belum menerima link undangan digital. Pastikan semua tamu mendapatkan pesan sebelum H-14.</p>
            </div>
        </div>
    </div>
@stop