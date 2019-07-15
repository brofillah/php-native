$(document).ready(function(){

    //sembunyikan tombol cari
    $('#tombol-cari').hide()

    // event ketika keyword ditulis
    $('#keyword').keyup(function(){
        //munculkan event loading
        $('.loader').show()

        // ajax menggunakan load
        //$('#container').load('ajax/mahasiswa.php?keyword=' + $('#keyword').val())

        $.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data){
            $('#container').html(data)
            $('.loader').hide()
        })
    })

})