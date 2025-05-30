// hitung stok
let page = segment;
let satuan = $('#satuan');
let stok = $('#stok');
let total = $('#total_stok');
let jumlah = page == 'barangmasuk' ? $('#jumlah_masuk') : $('#jumlah_keluar');

$(document).on('change', '#barang_id', function() {
    let stok = $(this).find(':selected').data('stok');

    $('#stok').val(stok);
});

$(document).on('keyup', '#jumlah_masuk', function() {
    let totalStok = parseInt(stok.val()) + parseInt(this.value);
    total.val(Number(totalStok));
});

$(document).on('keyup', '#jumlah_keluar', function() {
    let totalStok = parseInt(stok.val()) - parseInt(this.value);
    total.val(Number(totalStok));
});