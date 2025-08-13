<div>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th class="text-center">No.</th>
                <th>Siswa</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Kembali</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            @forelse ($logPeminjaman as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}</td>
                    <td>{{ $item->tgl_jatuh_tempo ? \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d M Y') : '-' }}</td>
                    <td>{{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') : 'Belum Kembali' }}</td>
                    <td class="text-center">
                        @if ($item->status == 'Kembali')
                            <span class="badge text-bg-success">Dikembalikan</span>
                        @elseif ($item->tgl_jatuh_tempo && now()->gt($item->tgl_jatuh_tempo))
                            <span class="badge text-bg-danger">Terlambat</span>
                        @else
                            <span class="badge text-bg-primary">Dipinjam</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak Ada Peminjaman Ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>