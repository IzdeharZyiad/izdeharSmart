@extends('Pdf.pdfFile')
@section('title')
    ديون الزبائن
@endSection

@section('header')
    دين الزبائن
@endSection

@section('info custemer')
    <p><strong>التاريخ:</strong> {{ now()->format('Y-m-d') }} </p>
@endSection

@section('table')
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>اسم الزبون</th>
                <th>مبلغ الديون</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($custemers as $custemer)
                <tr class="border-b border-gray-200">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $custemer->name }}</td>
                    <td>{{ $custemer->balance }}</td>
                </tr>
            @endforeach



        </tbody>


    </table>
@endSection

@section('sum')
    <p><strong>المجموع:</strong> {{ $custemers->sum('balance') }} شيكل</p>
@endSection
