@extends('Pdf.pdfFile')
@section('title')
    المنتجات المتوفرة
@endSection

@section('header')
    المنتجات المتوفرة
@endSection

@section('info custemer')
    <p><strong>التاريخ:</strong> {{ now()->format('Y-m-d') }} </p>
    <p><strong>القسم</strong> {{ $type->name }} </p>
@endSection

@section('table')
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم المنتج</th>
                <th>الكمية المتوفرة</th>
            </tr>
        </thead>

        <tbody>




            @foreach ($products as $product)
                <tr class="border-b border-gray-200">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->productDetail->sum('Quantity') }}</td>
                </tr>
            @endforeach


        </tbody>


    </table>
@endSection
