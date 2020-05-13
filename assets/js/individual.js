//Individual class
class Individual {

  //kontainer,genes,rotasi

  constructor(kontainer,barang) {
    // console.log(jumlah);
    var rn = new Random(barang);
    this.barang = barang;
    this.kontainer = kontainer;
    this.genes = new Array(barang.length);
    this.rotasi = new Array(barang.length);
    //Set genes randomly for each individual
    for (var i = 0; i < barang.length; i++) {
      this.genes[i] = rn.pop();
      // console.log(rn.pop());
    }

    for (var i = 0; i < this.rotasi.length; i++) {
      this.rotasi[i] = Math.floor(Math.random() * 6)+1;
    }
    this.fitness = 0;
  }

  //Calculate fitness
  calcFitness() {
    var kpanjang = this.kontainer[0]*100 ;
    var klebar = this.kontainer[1]*100 ;
    var ktinggi = this.kontainer[2]*100;
    var kberat = this.kontainer[3];
    var lebarterpakai = 0;
    var tinggiterpakai = 0;
    var panjangterpakai = 0;
    var layerPanjang = 0;
    var lebar= 0 ;
    var panjang = 0 ;
    var barangmasuk = [];
    //id,panjang,lebar,tinggi, berat
    for (var i = 0; i < this.genes.length; i++) {
      var brg = null;
      for (var o = 0; o < this.barang.length; o++) {
        if (this.barang[o][0]==this.genes[i]) {
          brg = this.barang[o];
        }
      }
      var berhenti = false;
      for (var l = 0; l < barangmasuk.length; l++) {
        if (brg[0]==barangmasuk[l]) {
          berhenti = true;
        }
      }//for barang sudah ditata
      if (berhenti == true) {
        continue;
      }
      if (brg[4]<=kberat) {
        if (brg[1]<=kpanjang-panjangterpakai) {
          if (brg[2]<=klebar-lebarterpakai&&brg[3]<=ktinggi) {
            barangmasuk.push(brg[0]);
            //kontainer p : 1000, l : 300, t : 300
            //position p,t,l
            kberat-=brg[4];
            if (brg[1]>layerPanjang) {
              layerPanjang=brg[1];
            }
            tinggiterpakai = brg[3];
            //lebar dan panjang alas
            lebar = brg[2];
            panjang = brg[1];

            for (var j = 0; j < this.genes.length; j++) {
              var brgLanjutan = null;
              for (var o = 0; o < this.barang.length; o++) {
                if (this.barang[o][0]==this.genes[i]) {
                  brgLanjutan = this.barang[o];
                }
              }
              var stop = false;
              for (var k = 0; k < barangmasuk.length; k++) {
                if (brgLanjutan[0]==barangmasuk[k]) {
                  stop = true;
                }
              }
              if (stop == true) {
                continue;
              }
              if (brgLanjutan[2]<=lebar&&brgLanjutan[1]<=panjang&&brgLanjutan[3]<=ktinggi-tinggiterpakai) {
                barangmasuk.push(brgLanjutan[0]);
                //kontainer p : 1000, l : 300, t : 300
                //position p,t,l
                kberat-=brgLanjutan[4];
                tinggiterpakai+=brgLanjutan[3];
                panjang = brgLanjutan[1];//
                lebar = brgLanjutan[2];
              } else {
                // console.log("barang p,l,t : "+brgLanjutan[1]+", "+brgLanjutan[2]+", "+brgLanjutan[3]);
                // console.log("alas p,l,t : "+panjang+", "+lebar+", "+(ktinggi-tinggiterpakai));
              }
            }
            lebarterpakai+=brg[2];
            tinggiterpakai=0;
          }//lebar dan tinggi
          else {
            panjangterpakai+=layerPanjang;
            layerPanjang = 0;
            lebarterpakai = 0;
            tinggiterpakai = 0;
            barangmasuk.push(brg[0]);
          }
        }//panjang
      }
    }
    //hitung volume barang/volume kontainer * 100%
    var vol_total_barang = 0
    var vol_kontainer = kpanjang*klebar*ktinggi;
    for (var i = 0; i < barangmasuk.length; i++) {
       var brg;
      for (var j = 0; j < this.barang.length; j++) {
        if (barangmasuk[i]==this.barang[j][0]) {
          brg = this.barang[i];
        }
      }
      var vol_barang = brg[1]*brg[2]*brg[3];
      vol_total_barang+=vol_barang;
    }
    this.fitness = (vol_total_barang/vol_kontainer)*100;
    // console.log(this.fitness);

  }//calcFitness

}
