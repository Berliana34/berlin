<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Buku</title>

    <!-- import file "style.css" -->
    <link rel="stylesheet" href="<?php echo base_url("ext/style.css")?>" />
</head>
<body>
    <!-- buat area menu -->
    <nav class="area-menu">
        <button id="btn_lihat" class="btn-primary">Lihat Data</button>
        <button id="btn_refresh" class="btn-secondary" onclick="return setRefresh()">Refresh Data</button>
    </nav>

    <!-- buat area untuk entry data buku -->
    <main class="area-grid">
        <section class="item-label1">
            <label id="lbl_id" for="txt_id">
                ID :
            </label>
        </section>
        <section class="item-input1">
            <input type="text" id="txt_id" class="text-input" maxlength="9">
        </section>
        <section class="item-error1">
            <p id="err_id" class="error-info"></p>
        </section>

        <section class="item-label2">
            <label id="lbl_judul" for="txt_judul">
                Judul Buku :
            </label>
        </section>
        <section class="item-input2">
            <input type="text" id="txt_judul" class="text-input" maxlength="100">
        </section>
        <section class="item-error2">
            <p id="err_judul" class="error-info"></p>
        </section>

        <section class="item-label4">
            <label id="lbl_jenis" for="cbo_jenis">
               Jenis Buku :
            </label>
        </section>
        <section class="item-input4">
            <select id="cbo_Jenis" class="select-input">
                <option value="-">Pilih Jenis Buku</option>
                <option value="Novel">Novel</option>
                <option value="Dongeng">Dongeng</option>
                <option value="Komik">Komik</option>
                <option value="Biografi">Biografi</option>
            </select>
        </section>
        <section class="item-error4">
            <p id="err_jenis" class="error-info"></p>
        </section>
    </main>

    <!-- buat area menu -->
    <nav class="area-menu" style="margin-top: 10px;">
        <button id="btn_ubah" class="btn-primary">Ubah Data</button>        
    </nav>
    
    <!-- import file "script.js" -->
    <script src="<?php echo base_url("ext/script.js"); ?>"></script>

    <script>
        // insialisasi object dan ambil data
        let txt_id = document.getElementById("txt_id");
        let txt_judul = document.getElementById("txt_judul");
        let cbo_jenis = document.getElementById("cbo_jenis");
        let token = '<?php echo $token; ?>';

        txt_id.value = '<?php echo $id; ?>';
        txt_judul.value = '<?php echo $judul; ?>';       
        cbo_jenis.value = '<?php echo $jenis; ?>';        

        // inisialisasi object
        let btn_lihat = document.getElementById("btn_lihat");
        let btn_ubah = document.getElementById("btn_ubah");

        // buat event untuk "btn_lihat"
        btn_lihat.addEventListener('click',function(){
            // alihkan ke halaman view buku
            location.href='<?php echo base_url(); ?>'
        });

        // buat fungsi untuk refresh
        function setRefresh()
        {
            location.href='<?php echo site_url("Buku/updateBuku"); ?>'+'/'+txt_id.value
        }

        // buat event untuk "btn_ubah"
        btn_ubah.addEventListener('click',function(){
            // inisialisasi object
            let lbl_id = document.getElementById("lbl_id");            
            let err_id = document.getElementById("err_id");

            let lbl_judul = document.getElementById("lbl_judul");            
            let err_judul = document.getElementById("err_judul");


            let lbl_jenis = document.getElementById("lbl_jjenis");            
            let err_jenis = document.getElementById("err_jenis");
            

            // jika id tidak diisi
            if(txt_id.value === "")
            {
                err_id.style.display = 'unset';
                err_id.innerHTML = "Id Harus Diisi !";
                lbl_id.style.color = "#FF0000";
                txt_id.style.borderColor = "#FF0000";
            }
            // jika id diisi
            else
            {
                err_judul.style.display = 'none';
                err_judul.innerHTML = "";
                lbl_judul.style.color = "unset";
                txt_judul.style.borderColor = "unset";
            }
            
            // ternary operator
            const judul = (txt_judul.value === "") ?
            [
                err_judul.style.display = 'unset',
                err_judul.innerHTML = "Judul Buku Harus Diisi !",
                lbl_judul.style.color = "#FF0000",
                txt_judul.style.borderColor = "#FF0000",            
            ]
            :
            [
                err_judul.style.display = 'none',
                err_judul.innerHTML = "",
                lbl_judul.style.color = "unset",
                txt_judul.style.borderColor = "unset",                
            ]

            const jenis = (cbo_jenis.selectedIndex === 0) ?
            [
                err_jenis.style.display = 'unset',
                err_jenis.innerHTML = "Jenis Buku Harus Dipilih !",
                lbl_jenis.style.color = "#FF0000",
                cbo_jenis.style.borderColor = "#FF0000",            
            ]
            :
            [
                err_jenis.style.display = 'none',
                err_jenis.innerHTML = "",
                lbl_jenis.style.color = "unset",
                cbo_jenis.style.borderColor = "unset",                
            ]
            
            // jika semua komponen terisi
            if(err_id.innerHTML === "" && judul[1]  === "" && jenis[1] === "")
            {
                // panggil method setUpdate
                setUpdate(txt_id.value,txt_judul.value,cbo_jenis.value,token);
            }            
        });
        
        const setUpdate = async(id,judul,jenis,token) => {
            // buat variabel untuk form
            let form = new FormData();

            // isi/tambah nilai untuk form
            form.append("idnya",id);
            form.append("judulnya",judul);
            form.append("jenisnya",junis);
            form.append("tokennya",token);

            try {
                // kirim data ke controller
                let response = await fetch('<?php echo site_url("Buku/setUpdate"); ?>',{
                    method: "POST",
                    body: form
                });

                // proses pembacaan hasil
                let result = await response.json();
                // tampilkan hasil
                alert(result.statusnya)
            }
            catch
            {
                alert("Data Gagal Dikirim !")
            }                        
            
            
            
            
            
    //         // proses kirim data ke controller
    //         fetch('<?php echo site_url("Buku/setSave"); ?>',{
    //             method: "POST",
    //             body: form
    //         })
    // .then((response) => response.json())        
    // .then((result) => alert(result.statusnya))    
    // .catch((error) => alert("Data Gagal Dikirim !"))
        }        
        
                
    </script>
</body>
</html>