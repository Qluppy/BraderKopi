// Script untuk menghilangkan notifikasi setelah 5 detik
setTimeout(function() {
    const successAlert = document.getElementById('success-alert');
    const errorAlert = document.getElementById('error-alert');
    if (successAlert) {
        successAlert.style.display = 'none';
    }
    if (errorAlert) {
        errorAlert.style.display = 'none';
    }
}, 200);

$(document).ready(function() {
// Inisialisasi Select2
$('#bahan').select2({
    placeholder: "Pilih bahan",
    allowClear: true,
    closeOnSelect: false
});

// Event saat bahan dipilih
$('#bahan').on('change', function() {
    let selectedBahan = $(this).val();
    let container = $('#jumlah-bahan-container');
    container.empty();

    if (selectedBahan && selectedBahan.length > 0) {
        selectedBahan.forEach(function(bahanId) {
            let bahanText = $('#bahan option[value="' + bahanId + '"]').text();

            container.append(`
                <div class="mb-3">
                    <label for="jumlah_bahan_${bahanId}" class="form-label">${bahanText}</label>
                    <input type="number" class="form-control" id="jumlah_bahan_${bahanId}" name="jumlah_stok[]" placeholder="Masukkan jumlahnya..." required>
                </div>
            `);
        });
    }
});

// Menambahkan event listener untuk input pencarian
$('#search').on('input', function() {
    const query = $(this).val();
    const suggestions = $('#suggestions');

    if (query.length > 0) {
        $.ajax({
            url: `/transaksi/cari-produk`,
            type: 'GET',
            data: { query: query },
            success: function(data) {
                let html = '';
                data.forEach(function(item) {
                    html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center" 
                            style="cursor: pointer;" 
                            data-id="${item.id}" 
                            data-nama="${item.nama_produk}" 
                            data-harga="${item.harga_produk}">
                            ${item.nama_produk} - Rp ${item.harga_produk}
                        </li>
                    `;
                });
                suggestions.html(html).show();
            }
        });
    } else {
        suggestions.hide();
    }
});

// Menangani klik pada saran produk
$('#suggestions').on('click', 'li', function() {
    const idProduk = $(this).data('id');
    const namaProduk = $(this).data('nama');
    const hargaProduk = $(this).data('harga');

    // Menambahkan produk ke keranjang
    $.ajax({
        url: `/keranjang/tambah/${idProduk}`,
        type: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({
            id: idProduk,
            nama_produk: namaProduk,
            harga_produk: hargaProduk,
            jumlah: 1
        }),
        success: function() {
            // Menyembunyikan saran dan mengosongkan kolom pencarian
            $('#search').val('');
            $('#suggestions').hide();

            // Refresh halaman untuk memperbarui keranjang
            location.reload();
        }
    });
});
});