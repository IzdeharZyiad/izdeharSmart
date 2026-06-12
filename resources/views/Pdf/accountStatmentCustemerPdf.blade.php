@extends('Pdf.pdfFile')
@section('title')
    كشف حساب للزبون
@endSection

@section('header')
    كشف حساب {{ $cutemer_name }}
@endSection

@section('info custemer')
    <p><strong>التاريخ:</strong> {{ now()->format('Y-m-d') }} </p>
    <p><strong>مجموع الديون:</strong> {{ $sumSale }} شيكل</p>
    <p><strong>المبلغ المدفوع:</strong> {{ $sumTransiction }} شيكل</p>
    <p><strong> المتبقي:</strong> {{ $reset }} شيكل</p>
@endSection

@section('table')
    <table class="table">
        <thead>
            <tr>
                <th>التاريخ</th>
                <th>النوع</th>
                <th>البيان</th>
                <th>الدين</th>
                <th>المبلغ المدفوع</th>
                <th>المتبقي</th>
            </tr>
        </thead>

        <tbody>


            @foreach ($statements as $statement)
                <tr class="border-b border-gray-200">
                    <td>{{ $statement['date'] }}</td>
                    <td>{{ $statement['type'] }}</td>
                    <td>{{ $statement['info'] }}</td>
                    <td>{{ $statement['debit'] }}</td>
                    <td>{{ $statement['credit'] }}</td>
                    <td>{{ $statement['balance'] }}</td>
                </tr>
            @endforeach


        </tbody>


    </table>
@endSection
