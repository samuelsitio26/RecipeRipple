<!-- Bagian tambahan untuk kategori -->
<h2>Daftar Kategori</h2>
<table class="recipe-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- Looping data kategori dari backend -->
        @foreach ($kategori as $kategori)
        <tr>
            <td>{{ $kategori->id }}</td>
            <td>{{ $kategori->nama }}</td>
            <td>
                <button class="btn-edit" onclick="editkategori({{ $kategori->id }})">Edit</button>
                <button class="btn-delete" onclick="deletekategori({{ $kategori->id }})">Hapus</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- Tombol untuk menambahkan kategori -->
<a href="/admin/kategori/tambah" class="btn-add-recipe">Tambah Kategori</a>

<script>
    // Fungsi untuk mengedit kategori
    function editkategori(id) {
        window.location.href = `/admin/kategori/edit/${id}`;
    }

    // Fungsi untuk menghapus kategori
    function deletekategori(id) {
        if (confirm("Apakah Anda yakin ingin menghapus kategori ini?")) {
            // Kirim permintaan penghapusan kategori
            fetch(`/admin/kategori/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Kategori berhasil dihapus!");
                    location.reload(); // Reload halaman
                } else {
                    alert("Terjadi kesalahan saat menghapus kategori.");
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>
