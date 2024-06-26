<?= $this->extend('layouts/template') ?>

<?= $this->section('page_title') ?>
    Course Page | Damri Course
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Section Course -->
    <section class="w-full mx-auto px-5 mt-12 py-8 sm:px-20 sm:py-10 sm:mt-20">
        <div class="w-full mx-auto text-3xl font-bold">
           <h1>Course</h1> 
        </div>

        <div class="w-full mx-auto mt-8">
            <div class="flex flex-row justify-between">
                <div class="flex flex-row">
                    <button class="px-6 bg-blue-800 text-sm text-white rounded-full hover:shadow-lg">Wajib</button>
                    <button class="px-4 bg-gray-300 text-sm text-gray-700 rounded-full ml-2 hover:shadow-lg">Opsional</button>
                </div>
                <!-- filter dropdown -->
                <div class="relative">
                    <select class="block appearance-none w-full bg-white border border-gray-400 text-sm hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option>Semua</option>
                        <option>Soft Skill</option>
                        <option>Hard Skill</option>
                    </select>
                </div>
            </div>
            <!-- Card Course -->
            <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-0 py-4 mx-auto mt-4">
                <!-- Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Card -->
                    <a class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70" href="#">
                        <div class="h-52 flex flex-col justify-center items-center bg-amber-500 rounded-t-xl"> 
                        <img src="https://img.freepik.com/free-photo/leader-authority-boss-coach-director-manager-concept_53876-133859.jpg?t=st=1717953192~exp=1717956792~hmac=4dd5765ea65682eedc1c253d21d25a05e86a8d1d01f85b03b61d1073303b46a5&w=900" class="rounded-t-lg h-full w-full object-cover" alt="Thumbnail">
                        </div>
                        <div class="p-4 md:p-6">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                            Kepemimpinan
                            </h3>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500" style="display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user" style="margin-right: 8px;">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                1196 Peserta
                            </p>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500" style="display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-video" style="margin-right: 8px;">
                                    <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"/>
                                    <rect x="2" y="6" width="14" height="12" rx="2"/>
                                </svg>
                                10 Video
                            </p>
                        </div>
                    </a>
                    <!-- End Card -->
                    <!-- Card -->
                    <a class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70" href="#">
                        <div class="h-52 flex flex-col justify-center items-center bg-amber-500 rounded-t-xl">
                            <img src="https://img.freepik.com/free-photo/young-network-engineer-working-server-room_23-2148323441.jpg?t=st=1717953355~exp=1717956955~hmac=61ff9810b79c17ca50af24472750ed57cc66c18bccc3fc842b8c287267047f9b&w=996" class="rounded-t-lg h-full w-full object-cover" alt="Thumbnail">
                        </div>
                        <div class="p-4 md:p-6">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                                Perawatan Server
                            </h3>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500" style="display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user" style="margin-right: 8px;">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                1196 Peserta
                            </p>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500" style="display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-video" style="margin-right: 8px;">
                                    <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"/>
                                    <rect x="2" y="6" width="14" height="12" rx="2"/>
                                </svg>
                                10 Video
                            </p>
                        </div>
                    </a>

                    <!-- End Card -->
                    <!-- Card -->
                    <a class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70" href="#">
                        <div class="h-52 flex flex-col justify-center items-center bg-amber-500 rounded-t-xl">
                            <img src="https://img.freepik.com/free-photo/finance-economics-work-male-discussion-laptop_1418-79.jpg?t=st=1717953531~exp=1717957131~hmac=f043f181b430ae8c243c1499cc24c70ddf67598b232e0456eacee4c8d73e8d65&w=996" class="rounded-t-lg h-full w-full object-cover" alt="Thumbnail">
                        </div>
                        <div class="p-4 md:p-6">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                            Strategi Pemasaran
                            </h3>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500" style="display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user" style="margin-right: 8px;">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                1196 Peserta
                            </p>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500" style="display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-video" style="margin-right: 8px;">
                                    <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"/>
                                    <rect x="2" y="6" width="14" height="12" rx="2"/>
                                </svg>
                                10 Video
                            </p>
                        </div>
                    </a>
                    <!-- End Card -->
                </div>
                <!-- End Grid -->
            </div>
            <!-- End Card Course -->
        </div>
    </section>
    <!-- End Section Course -->

    <!-- Section Learning Path -->
    <section class="w-full mx-auto px-5 py-8 sm:px-20 sm:py-0">
        <div class="w-full mx-auto text-3xl font-bold">
           <h1>Learning Path Saya</h1> 
        </div>
        <div class="h-full mt-4 bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="p-4 md:p-6 grid sm:grid-cols-2 md:grid-cols-2 llg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4">
                <!-- Card -->
                <a class="group flex flex-row bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800" href="#">
                <img src="https://img.freepik.com/free-vector/money-income-attraction_74855-6573.jpg?t=st=1717938878~exp=1717942478~hmac=8dfa8f37cb5c38675655c3306f3cb77a53729a53c7dda74fbd003b20ba2a3659&w=900" alt="Deskripsi Gambar" class="w-1/4 object-cover rounded-l-xl" />
                <div class="flex flex-col justify-between p-4 md:p-5 w-3/4">
                    <div>
                        <h3 class="text-lg group-hover:text-lg text-black font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                            Akuntansi
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-neutral-500">
                            Progress Saya
                        </p>
                    </div>
                    <!-- Progress -->
                    <div class="flex items-center gap-x-3 whitespace-nowrap mt-4">
                        <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                            <div class="flex flex-col justify-center rounded-full overflow-hidden bg-[#FBB926] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 50%"></div>
                        </div>
                        <div class="w-10 text-end">
                            <span class="text-sm text-gray-800 dark:text-white">50%</span>
                        </div>
                    </div>
                    <!-- End Progress -->
                </div>
            </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="group flex flex-row bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800" href="#">
                <img src="https://img.freepik.com/free-vector/people-analyzing-growth-charts_23-2148866843.jpg?t=st=1717938991~exp=1717942591~hmac=88926764172001ec7b3326aa95860a134b2fd528b2c4df4ccf3578f2cde1101b&w=996" alt="Deskripsi Gambar" class="w-1/4 object-cover rounded-l-xl" />
                <div class="flex flex-col justify-between p-4 md:p-5 w-3/4">
                    <div>
                        <h3 class="text-lg group-hover:text-lg text-black font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                            Management
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-neutral-500">
                            Progress Saya
                        </p>
                    </div>
                    <!-- Progress -->
                    <div class="flex items-center gap-x-3 whitespace-nowrap mt-4">
                        <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                            <div class="flex flex-col justify-center rounded-full overflow-hidden bg-[#FBB926] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 50%"></div>
                        </div>
                        <div class="w-10 text-end">
                            <span class="text-sm text-gray-800 dark:text-white">50%</span>
                        </div>
                    </div>
                    <!-- End Progress -->
                </div>
            </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="group flex flex-col items-center bg-gray-200 border shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800" href="<?= base_url('learning-path') ?>">
                    <div class="p-4 pt-2 md:p-4 pt-2 flex flex-col items-center justify-center">
                        <div class="flex items-center justify-center w-10 h-10 mb-2 text-white-500 rounded-full dark:bg-blue-800 dark:text-blue-200">
                            <span class="text-3xl font-bold">+</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-neutral-300 group-hover:text-gray-900 dark:group-hover:text-white">
                                Ajukan Learning Path
                            </p>
                        </div>
                    </div>
                </a>
                <!-- End Card -->
            </div>
        </div>
    </section>
    <!-- End Section Learning Path -->

    <!-- Section Course Saya -->
    <section class="w-full mx-auto px-5 py-8 sm:px-20 sm:py-14">
        <div class="text-3xl font-bold">
           <h1>Course Saya</h1> 
        </div>
        
        <!-- Card Course -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-0 py-4 mx-auto">
                <!-- Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Card -->
                    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="h-52 flex flex-col justify-center items-center bg-[#FBB926] rounded-t-xl">
                        <img src="https://img.freepik.com/free-photo/people-working-call-center_23-2149288184.jpg?t=st=1717836311~exp=1717839911~hmac=6e8159fdbd6575776d5718f8abc25d091d211f9fc1584b9e8814ebaf2c785d8d&w=996" class="rounded-t-lg h-full w-full object-cover" alt="Thumbnail">
                    </div>
                    <div class="p-4 md:p-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                        Pelayanan Pelanggan
                        </h3>
                        <h2 class="text-md font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                        Akuntansi
                        </h2>
                        <p class="text-sm mt-2 text-gray-500 dark:text-neutral-500">
                            Progress Saya
                        </p>
                        <!-- Progress -->
                        <div class="flex items-center gap-x-3 whitespace-nowrap">
                            <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                <div class="flex flex-col justify-center rounded-full overflow-hidden bg-[#FBB926] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 50%"></div>
                            </div>
                            <div class="w-10 text-end">
                                <span class="text-sm text-gray-800 dark:text-white">50%</span>
                            </div>
                        </div>
                        <!-- End Progress -->
                        <!-- Button Lanjut Belajar --> 
                        <div class="flex justify-center mt-4">
                            <button class="w-full px-4 py-2 bg-blue-900 text-white rounded-md hover:shadow-lg">Lanjut Belajar</button>
                        </div>
                    </div>
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="h-52 flex flex-col justify-center items-center bg-rose-500 rounded-t-xl">
                        <img src="https://img.freepik.com/free-photo/professional-car-mechanic-repair-shop_342744-262.jpg?t=st=1717836180~exp=1717839780~hmac=c44709f1de012f4fd001335fd85989d194aab0e3cd024cd3525ce3bb6348eb07&w=996" class="rounded-t-lg h-full w-full object-cover" alt="Thumbnail">
                    </div>
                    <div class="p-4 md:p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                        Perawatan Armada
                        </h3>
                        <h2 class="text-md font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                        Akuntansi
                        </h2>
                        <p class="text-sm mt-2 text-gray-500 dark:text-neutral-500">
                            Progress Saya
                        </p>
                        <!-- Progress -->
                        <div class="flex items-center gap-x-3 whitespace-nowrap">
                            <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="flex flex-col justify-center rounded-full overflow-hidden bg-[#FBB926] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 50%"></div>
                            </div>
                            <div class="w-10 text-end">
                                <span class="text-sm text-gray-800 dark:text-white">50%</span>
                            </div>
                        </div>
                        <!-- End Progress -->
                        <!-- Button Lanjut Belajar --> 
                        <div class="flex justify-center mt-4">
                            <button class="w-full px-4 py-2 bg-blue-900 text-white rounded-md hover:shadow-lg">Lanjut Belajar</button>
                        </div>
                    </div>
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="h-52 flex flex-col justify-center items-center bg-amber-500 rounded-t-xl">
                        <img src="https://img.freepik.com/free-photo/colleagues-with-safety-equipment-working-with-blueprints_23-2148908431.jpg?t=st=1717836460~exp=1717840060~hmac=8845f2595ea53eab452ddaf4aa1c15087acda922acd0113bc1b1a100cba0d463&w=996" class="rounded-t-lg h-full w-full object-cover" alt="Thumbnail">
                    </div>
                    <div class="p-4 md:p-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                            Keselamatan Kerja
                        </h3>
                        <h2 class="text-md font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                            Akuntansi
                        </h2>
                        <p class="text-sm mt-2 text-gray-500 dark:text-neutral-500">
                            Progress Saya
                        </p>
                        <!-- Progress -->
                        <div class="flex items-center gap-x-3 whitespace-nowrap">
                            <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="flex flex-col justify-center rounded-full overflow-hidden bg-[#FBB926] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 50%"></div>
                            </div>
                            <div class="w-10 text-end">
                                <span class="text-sm text-gray-800 dark:text-white">50%</span>
                            </div>
                        </div>
                        <!-- End Progress -->
                        <!-- Button Lanjut Belajar --> 
                        <div class="flex justify-center mt-4">
                            <button class="w-full px-4 py-2 bg-blue-900 text-white rounded-md hover:shadow-lg">Lanjut Belajar</button>
                        </div>
                    </div>
                    </div>
                    <!-- End Card -->
                </div>
                <!-- End Grid -->
            </div>
            <!-- End Card Course -->
     </section>

<?= $this->endSection() ?>