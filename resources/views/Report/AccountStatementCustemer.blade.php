@extends('welcome')

@section('title')
    كشف حساب الزبائن
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">
            <x-link-nav :href="route('accountStatementCustemer')" :active="request()->routeIs('accountStatementCustemer')" icon="fa fa-soild fa-file">كشف حساب الزبائن</x-link-nav>
        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">
            <x-link-nav :href="route('accountStatementCustemer')" :active="request()->routeIs('accountStatementCustemer')" icon="fa fa-soild fa-file">كشف حساب الزبائن</x-link-nav>


        </div>




    </div>
@endSection


@section('content')
    <livewire:reports.account-statment-custemer :custmers="$custmers" />
@endSection

@section('script')
    <script>
        document.addEventListener('livewire:init', () => {

            let table = $('#account_id').DataTable({
                order: [],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                    search: "",
                    searchPlaceholder: "بحث"
                },
                columnDefs: [{
                    targets: 0,
                    orderable: false,
                    className: 'text-center',
                }],
                pageLength: 5,
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "الكل"]
                ]
            });

            Livewire.on('refreshTable', () => {

                table.destroy();

                setTimeout(() => {

                    table = $('#account_id').DataTable({
                        order: [],
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                            search: "",
                            searchPlaceholder: "بحث"
                        },
                        columnDefs: [{
                            targets: 0,
                            orderable: false,
                            className: 'text-center',
                        }],
                        pageLength: 5,
                        lengthMenu: [
                            [5, 10, 25, 50, 100, -1],
                            [5, 10, 25, 50, 100, "الكل"]
                        ]
                    });

                }, 100);

            });

        });
    </script>
@endSection
