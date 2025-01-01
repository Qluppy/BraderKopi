@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>Hasil Perhitungan SAW</h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Form untuk memilih bulan dan tahun -->
        <form action="{{ route('saw.calculate') }}" method="GET">
            <div class="form-row align-items-center mb-4">
                <div class="col-auto">
                    <label for="bulan" class="col-form-label">Bulan:</label>
                    <select name="bulan" id="bulan" class="form-control">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-auto">
                    <label for="tahun" class="col-form-label">Tahun:</label>
                    <select name="tahun" id="tahun" class="form-control">
                        @for ($year = now()->year; $year >= 2000; $year--)
                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mt-2">Tampilkan</button>
                </div>
            </div>
        </form>

        <!-- Menampilkan alternatif -->
        <h4>Alternatif:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Biji Kopi</th>
                    <th>Terjual</th>
                </tr>
            </thead>
            <tbody>
                @if (is_array($alternatives) && count($alternatives) > 0)
                    @foreach ($alternatives as $index => $alternative)
                        <tr>
                            <td>{{ $alternativeLabels[$index]['nama_produk'] ?? '-' }}</td>
                            <td>{{ number_format($alternative['harga_produk'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($alternative['biji_kopi'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($alternative['terjual'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data alternatif.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Menampilkan alternatif ternormalisasi -->
        <h4>Alternatif Ternormalisasi:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Biji Kopi</th>
                    <th>Terjual</th>
                </tr>
            </thead>
            <tbody>
                @if (is_array($normalizedAlternatives) && count($normalizedAlternatives) > 0)
                    @foreach ($normalizedAlternatives as $index => $normalized)
                        <tr>
                            <td>{{ $alternativeLabels[$index]['nama_produk'] ?? '-' }}</td>
                            <td>{{ number_format($normalized['harga_produk'] ?? 0, 4) }}</td>
                            <td>{{ number_format($normalized['biji_kopi'] ?? 0, 4) }}</td>
                            <td>{{ number_format($normalized['terjual'] ?? 0, 4) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data untuk ditampilkan.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Menampilkan skor akhir -->
        <h4>Skor Akhir:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Skor Akhir</th>
                </tr>
            </thead>
            <tbody>
                @if (is_array($finalScores) && count($finalScores) > 0)
                    @foreach ($finalScores as $index => $score)
                        <tr>
                            <td>{{ $alternativeLabels[$index]['nama_produk'] ?? '-' }}</td>
                            <td>{{ number_format($score ?? 0, 4) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">Tidak ada skor akhir untuk ditampilkan.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <h4>Produk dengan Skor Paling Sedikit:</h4>
@if (!empty($lowestScore))
    <p>
        Nama Produk: <strong>{{ $lowestScore['nama_produk'] }}</strong><br>
        Skor: <strong>{{ number_format($lowestScore['skor'], 4) }}</strong>
    </p>
@else
    <p class="text-danger">Tidak ada data skor untuk ditampilkan.</p>
@endif

    </div>
</section>
@endsection
