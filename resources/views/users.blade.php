
<x-layouts.users>
       <div class="flex flex-col">

        

        <!-- first -->
        <div class="grid grid-cols-2  w-full h-[40px] ">
            <div class="flex items-center mr-6 mt-2 selection:bg-green-700 selection:text-white">
                <h1 class="text-green-900 text-xl font-medium">قائمة الموظفين</h1>
            </div>
            <div class="flex justify-end  mt-2 gap-6 ml-6 ">
                <div class="flex items-center h-[6px]  rounded-lg shadow-md border-2 border-gray-200 p-4">
                    <a class="text-center font-medium text-green-900">
                        <i class="fa-solid fa-arrow-down ml-2 mb-1 text-md :text-inherit "></i>

                        تنزيل

                    </a>
                </div>
                <div class="flex items-center bg-green-800 h-[20px] rounded-lg shadow-md  p-4">
                    <a class="text-center font-sm text-white" href="{{route('users.addUser')}}">
                        <i class="fa-solid fa-user-plus ml-2 mb-1 text-sm :text-inherit "></i>
                        اضافة موظف جديد

                    </a>
                </div>

            </div>


        </div>

        <div class="w-full  h-[80px]">
            <div class="grid grid-cols-3 h-[90px] pt-2">
                <div class="flex flex-col bg-white border-l   border-gray-200">
                    <x-card-nav icon="fa-solid fa-users" text="عدد الموظفين" value="5" />
                </div>
                <div class="flex flex-col bg-white border-l   border-gray-200">
                    <x-card-nav icon="fa-solid fa-group-arrows-rotate" text="الحضور اليومي" value="3" />
                </div>
                <div class="flex flex-col bg-white  border-l  border-gray-200">
                    <x-card-nav icon="fa-solid fa-user-plus" text="عدد الموظفين الجدد شهريا" value="0" />
                </div>

            </div>
        </div>

        <div class="mt-8 max-h-[438px] custom-scroll overflow-y-auto  border border-gray-200 w-[1210px]  mx-auto rounded-lg shadow-lg">
            <table id="myTable" class="display  ">
                <thead>
                    <tr>
                        <th class="w-16"></th>
                        <th>الاسم</th>
                        <th>القسم</th>
                        <th class="w-32">الحالة</th>
                        <th>تاريخ الانضمام</th>
                        <th class="w-16">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                   
                    
                      <tr>
                        <td><input type="checkbox" class="accent-green-900 text-white"></td>
                        <td>أحمد</td>
                        <td>موظف</td>
                        <td>
                           <x-green-status text="نشط" />
                        </td>
                        <td>1.2.2025</td>
                        <td><x-menu-table/></td>
                    </tr>
                    
                    <tr>
                        <td><input type="checkbox" class="accent-green-900 text-white"></td>
                        <td>محمد</td>
                        <td>مدير</td>
                        <td>
                           <x-yellow-status text="غادر"/>
                        </td>
                          <td>1.2.2025</td>
                        <td><x-menu-table/></td>
                    </tr>

                    <tr>
                        <td><input type="checkbox" class="accent-green-900 text-white"></td>
                        <td>أحمد</td>
                        <td>موظف</td>
                        <td>
                            <x-red-status text="غائب"/>
                        </td>
                          <td>1.2.2025</td>
                        <td><x-menu-table/></td>
                    </tr>
                </tbody>
            </table>


        </div>


    </div>
</x-layouts.users>