@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>Hasil Perhitungan SAW</h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <h4>Alternatif:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <th>Harga</th>
                    <th>Biji kopi</th>
                    <th>Terjual</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alternatives as $index => $alternative)
                <tr>
                    <td>A{{ $index + 1 }}</td>
                    @foreach ($alternative as $value)
                    <td>{{ $value }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Alternatif Ternormalisasi:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <th>Harga</th>
                    <th>Biji kopi</th>
                    <th>Terjual</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($normalizedAlternatives as $index => $normalized)
                <tr>
                    <td>A{{ $index + 1 }}</td>
                    @foreach ($normalized as $value)
                    <td>{{ number_format($value, 4) }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Skor Akhir:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <th>Skor Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($finalScores as $index => $score)
                <tr>
                    <td>A{{ $index + 1 }}</td>
                    <td>{{ number_format($score, 4) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
