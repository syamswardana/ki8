class Random {
  constructor(barang){
    this.id = new Array(barang.length);
    for (var i = 0; i < barang.length; i++) {
      this.id[i] = barang[i][0];
    }
  }
  pop(){
    var i = Math.floor(Math.random() * this.id.length);
    // console.log();
    return parseInt(this.id.splice(i,1));
  }
}
