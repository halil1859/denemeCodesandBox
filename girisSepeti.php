<?php
// başlangıç işlemleri
    include "baglan.php";

      // giriş ve çıkış sepetinde kayıtları al
          $girisSepeti = array( );
            $sql =" SELECT urunId
                    FROM girisSepeti
                    WHERE durum = 'sepette'
                    ";
            $result = $conn -> query($sql);
              if ($result->num_rows<1) {
                $girisYapilacaklar = count($girisSepeti);
              }
              else {
                while ($row = $result->fetch_assoc()) {

                            array_push($girisSepeti,$row['urunId']);
                  }
                //print_r($girisSepeti);
                $girisYapilacaklar = count($girisSepeti);
              }
      // giriş ve çıkış sepetinde kayıtları al bitti -----!!//>>

// başlangıç işlemleri bitti

?>

<!DOCTYPE html>
<html lang="tr" dir="ltr">
<body>
  <head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- yerel linkler
    <script src="js/jquery.3.4.1.js"></script>
    <script src="js/bootstrap.3.3.7.js"></script>
    -->
    <!-- <script src="js/sayfaFormulleri.js"></script> -->
    <title></title>
  </head>

    <!--  navigasyon section başlangıç-->
      <nav>
        <div class="">
          <p id="navigasyonEkle">buraya navigasyon eklenecek</p>
          <!-- <a type="button" name="button" href="mainn.php">ana sayfaya dön</a> -->
        </div>
      </nav>
    <!--  navigasyon section bitiş-->
    <p id="sonuc"></p>
  <div class="container" name="deneme alanı"></div>
  <form class="" action="index.html" method="post">

  </form>
  <div class="container" id="girisBilgileri"></div>


<!--  Sepetteki Ürünlerin listeleneceği tablo-->
<div class="container">
  <div class="table-responsive" id="sepettekiUrunler">

  </div>
</div>
<!--  Sepetteki Ürünlerin listeleneceği tablo /-->


<!--  sayfa JavaScriptleri-->
    <script type="text/javascript">

      // sayfayla birlikte yüklenecek scriptler
      $(document).ready(function(){

        girisSepetiniYukle();
        girisBilgileriniYukle();

        //  <girişSepetindeki ürünleri sayfada listeleme>
        function girisSepetiniYukle(){
          $.ajax({
      			url:"fetch_cart.php",
      			method:"POST",
      			success:function(data){
      			$('#sepettekiUrunler').html(data)
      			}
		      });
        }
        //  <girişSepetindeki ürünleri sayfada listeleme !!>>>

        //  <girişe ilişkin bilgilerin olduğu div i snip ten çekme>
        function girisBilgileriniYukle(){
          var action = "ilk"
          $.ajax({
      			url:"snippGirisBilgileri.html",
            data:{action:action},
      			method:"POST",
      			success:function(data){
      			$('#girisBilgileri').html(data)
      			}
		      });
        }
        //  <girişSepetindeki ürünleri sayfada listeleme !!>>>

        //  <ürün miktarı td sini türk sayı tipine çevşrmek için formül>
        function turkSayiFormat(){

          var deger = $("#miktari");
          var deger = deger.toFixed(2);
        }
        //  <ürün miktarı td sini türk sayı tipine çevşrmek için formül !!>>>>



        // tüm giriş sepetini sil formülü
          $(document).on('click', '.tumunuSil', function(){
            var action = 'tumunuSil';
            if(confirm("Tüm ürünleri silmek istediğinizden emin misiniz")){
              $.ajax({
                url:"islem.php",
                method:"POST",
                data:{action:action},
                success:function(){
                girisSepetiniYukle();
                }
              })
            }
            else{
              return false;
            }
          }); // tüm giriş sepetini sil formülü />
          // tüm giriş sepetini sil formülü --!!///>>

          // seciliUrunuSil fonksiyonu
          $(document).on('click', '.tekUrunSil', function(){
            var secilenUrun = (event.target.id);
            console.log(secilenUrun);
            var action = 'sil';
            if(confirm("Bu ürünü listeden çıkartmak istediğinizden emin misiniz?")){
              $.ajax({
                url:"islem.php",
                method:"POST",
                data:{secilenUrun:secilenUrun, action:action},
                success:function(data){
                  $('#sonuc').html(data);
                  girisSepetiniYukle();
                }
              })
            }
            else{
              return false;
            }
          });
          // seciliUrunuSil fonksiyonu />

          // giriş yap butonu ile giriş tifinin oluşturulması

          $(document).on('click', '#kaydetButon', function(){
            if(confirm("ürünler kayıt yapılacak")){
              var diziGirisYapilacakUrunler = [];
              var diziUrunMiktari = [];

              var x = document.getElementsByClassName("id");
              // console.log(x);
              // console.log(x.length);
              var y = document.getElementsByClassName("urunMiktari");
              // console.log(y);
              // console.log(y.length);

                for (var i = 0; i < x.length; i++) {
                  // console.log(x[i].innerHTML);
                  diziGirisYapilacakUrunler.push(x[i].innerHTML);
                }
                for (var i = 0; i < y.length; i++) {
                  // console.log(y[i].value);
                  diziUrunMiktari.push(y[i].value);
                }
                // console.log(seri.length);
                // console.log(seri);
                // console.log(diziUrunMiktari.length);
                // console.log(diziUrunMiktari);
                var girisBilgileri = [];
                girisBilgileri.push(document.getElementById("girisTarihi").value);
                girisBilgileri.push(document.getElementById("girisTuru").value);
                girisBilgileri.push(document.getElementById("depo").value);
                girisBilgileri.push(document.getElementById("yukleniciAdi").value);

                console.log(girisBilgileri);

                var action = 'kaydet'
                var giriseGonderilenUrunler = diziGirisYapilacakUrunler;
                var urunMiktari = diziUrunMiktari;
                var girisBilgileri = girisBilgileri;
                $.ajax({
                  url:"islem.php",
                  method:"POST",
                  // dataType:"json"
                  data:{girisBilgileri:girisBilgileri,
                        giriseGonderilenUrunler:giriseGonderilenUrunler,
                        urunMiktari:urunMiktari,
                        action:action},
                  success:function(data){
                    $('#sonuc').html(data);
                  }
              });
            }
            else {
              return false;
            }
          });

          // giriş yap butonu ile giriş tifinin oluşturulması! />


    }); //sayfayla birlikte yüklenecek scriptler (document ready) bitimi /

    </script>
<!--  sayfa JavaScriptleri-->



</body>
</html>
