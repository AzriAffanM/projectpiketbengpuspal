<x-app-layout>
    <!-- Header -->
    <div class="bg-gradient-to-br from-emerald-900 to-emerald-800">
        <div class="max-w-7xl mx-auto px-6 py-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/Logo_Pusat_Peralatan_Angkatan_Darat.png') }}" alt="Bengpuspal" class="w-12 h-12 object-contain">
                    <div>
                        <h1 class="text-2xl font-bold font-sans">Sistem Piket Bengpuspal</h1>
                        <p class="text-emerald-200 text-sm">Piket jaga malam terjadwal dan otomatis</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-4">
                    <span class="text-emerald-100">{{ auth()->user()->name }}</span>
                    <div class="w-10 h-10 rounded-full bg-emerald-700 flex items-center justify-center">
                        <span class="text-white font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Halo, {{ auth()->user()->name }}</h2>
                <p class="text-gray-600">Selamat datang di Sistem Piket Bengpuspal</p>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Tanggal Jaga -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 mb-1">TANGGAL JAGA</div>
                        <div class="text-2xl font-bold text-gray-900">{{ isset($jadwalHariIni) ? \Illuminate\Support\Carbon::parse($jadwalHariIni->tanggal_jaga)->format('d M Y') : '-' }}</div>
                    </div>
                </div>
                
                <!-- Petugas -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 mb-1">PETUGAS</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $jadwalHariIni->petugas->nama ?? '-' }}</div>
                    </div>
                </div>
                
                <!-- Status -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 mb-1">STATUS</div>
                        @php $isOn = ($status === 'Sedang Bertugas'); @endphp
                        <div class="mt-1">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $isOn ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' }}">
                                <span class="h-2.5 w-2.5 rounded-full {{ $isOn ? 'bg-emerald-500' : 'bg-gray-500' }} mr-2"></span>
                                {{ $status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Daftar Petugas</h3>
                <a href="{{ route('jadwal-jaga.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-600 text-white font-medium hover:bg-emerald-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    Lihat Jadwal Piket
                </a>
            </div>

            <!-- Tabel Petugas -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PANGKAT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JABATAN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO. TELEPON</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URUTAN</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $petugas = [
                                    ['nama' => 'candra', 'pangkat' => 'Bintara', 'jabatan' => 'Kepala Staf Angkatan Darat (KSAD)', 'no_telp' => '08976546', 'urutan' => 1],
                                    ['nama' => 'pasha', 'pangkat' => 'Bintara', 'jabatan' => 'Sersan Mayor', 'no_telp' => '0976567', 'urutan' => 2],
                                    ['nama' => 'habibi', 'pangkat' => 'TNI', 'jabatan' => 'Bintara', 'no_telp' => '0898765467', 'urutan' => 3],
                                    ['nama' => 'Azri Affan M', 'pangkat' => 'PERWIRA', 'jabatan' => 'PNS', 'no_telp' => '6789654675', 'urutan' => 4],
                                    ['nama' => 'JOKO spd mpd', 'pangkat' => 'Bengkel', 'jabatan' => 'Tamtama', 'no_telp' => '685436', 'urutan' => 5],
                                    ['nama' => 'DWI TJAHLJO DUMAD', 'pangkat' => 'bintang', 'jabatan' => 'PNS', 'no_telp' => '5647865', 'urutan' => 6],
                                ];
                            @endphp
                            
                            @foreach($petugas as $index => $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $p['nama'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p['pangkat'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $p['jabatan'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p['no_telp'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p['urutan'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Hanya tampilkan untuk admin -->
            @if(auth()->user() && auth()->user()->role === 'admin')
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kartu Ringkasan Admin -->
                    <div class="p-4 rounded-lg border border-lime-900/30 bg-lime-50">
                        <div class="text-xs uppercase tracking-widest text-lime-900 font-semibold">Ringkasan Admin</div>
                        <dl class="mt-3 space-y-2 text-sm text-lime-950">
                            <div class="flex items-center justify-between border-b border-lime-100 pb-1">
                                <dt>Jumlah Petugas</dt>
                                <dd class="font-bold text-lg">{{ $totalPetugas ?? 0 }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt>Laporan Menunggu Approval</dt>
                                <dd class="font-bold text-lg text-red-700">{{ $pendingLaporan ?? 0 }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Kartu Aksi Cepat Admin -->
                    <div class="p-4 rounded-lg border border-lime-900/30 bg-lime-50 flex flex-col gap-2">
                        <div class="text-xs uppercase tracking-widest text-lime-900 font-semibold">Aksi Cepat Admin</div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <a href="{{ route('laporan-piket.approval') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-lime-900 text-white text-sm font-semibold hover:bg-lime-800 transition duration-150 ease-in-out shadow-md">
                                Kelola Approval Laporan ({{ $pendingLaporan ?? 0 }})
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>