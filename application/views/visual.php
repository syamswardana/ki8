<html>
<head>
	<title>My first three.js app</title>
	<style>
	body { margin: 0; }
	canvas { width: 100%; height: 100% }
	.info {
		position:fixed;
		height:400px;
		width:220px;padding: 10px;
		font-size: 4px;
		background-color:rgb(255, 255, 255);
		/* opacity:40%; */
		top: 50%;
		-ms-transform: translateY(-50%);
		transform: translateY(-50%);
		overflow-y: auto;
	}
	.icon {
		font-size: 26px;
	}
	</style>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/open-iconic-bootstrap.css">
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/three.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/OrbitControls.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/dat.gui.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/random.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/individual.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/population.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/genetik.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/js.cookie-2.2.1.min.js"></script>
</head>
<body>
	<div class="info">
		<h4 style="font-size: 20px; margin:10px;text-align:center;">Info</h4>
		<table>
			<tbody id="isiInfo">
				<!-- isi -->
			</tbody>
		</table>
	</div>
</div>
<script>

var scene = new THREE.Scene();
var color = new THREE.Color( 0x444444 );
scene.background = color;
var camera = new THREE.PerspectiveCamera( 75, window.innerWidth/window.innerHeight, 1, 2000 );

var renderer = new THREE.WebGLRenderer();
renderer.setSize( window.innerWidth, window.innerHeight );
document.body.appendChild( renderer.domElement );

//grub barang
var grubBarang = new THREE.Object3D();

//kontainer
var kontainer = [6,3,3,400];
var geometryKontainer = new THREE.BoxGeometry( kontainer[0]*100, kontainer[1]*100, kontainer[2]*100);
var edges = new THREE.EdgesGeometry( geometryKontainer );
var line = new THREE.LineSegments( edges, new THREE.LineBasicMaterial( { color: 0xffffff } ) );
scene.add( line );

//Barang
//id,panjang,lebar,tinggi, berat
// var barang = [
// 	[0,10,21,9,1],
// 	[0,4,8,7,1],
// 	[0,11,20,10,1],
// 	[0,12,5,7,1],
// 	[0,13,8,20,1]
// ];



//Barang
// var barang = [];
$.ajax({
	type : "GET",
	url  : "<?php echo site_url("Visual3d/barang")?>",
	dataType : "JSON",
	success: function(data){
		//id,panjang,lebar,tinggi, berat
		var pilihan = Cookies.getJSON('barang');
		var barang = [];
		for (var i = 0; i < data.length; i++) {
			// for (var j = 0; j < pilihan.length; j++) {
			// 	if (data[i].id==pilihan[j]) {
			barang.push([]);
			barang[i][0] = parseInt(data[i].id);
			barang[i][1] = parseInt(data[i].panjang);
			barang[i][2] = parseInt(data[i].lebar);
			barang[i][3] = parseInt(data[i].tinggi);
			barang[i][4] = parseInt(data[i].berat);
			// }
			// }
		}
		// console.log(pilihan);
		// var algoritma = new Genetik(kontainer,barang);
		// algoritma.start();
		// var fittest = algoritma.fittest.genes;
		// console.log(fittest);
		var fittest = [38,39,40,41,42,43];
		var posisi = [0,0,0,0,0,0];
		// var posisi = [0,2,3,4,5,5];

		//posisi
		// 0. x, y, z => p, l, t
		// 1. x, y, z => t, p, l
		// 2. x, y, z => l, t, p
		// 3. x, y, z => l, p, t
		// 4. x, y, z => t, l, p
		// 5. x, y, z => p, t, l
		for (var i = 0; i < posisi.length; i++) {
			for (var j = 0; j < barang.length; j++) {
				if (barang[j][0] == fittest[i]) {
					if (posisi[i] == 0) {
							//tetap
					} else if (posisi[i] == 1) {
						var temp = barang[j][1];
						barang[j][1] = barang[j][3];
						barang[j][3] = barang[j][2];
						barang[j][2] = temp;
					} else if (posisi[i] == 2) {
						var temp = barang[j][1];
						barang[j][1] = barang[j][2];
						barang[j][2] = barang[j][3];
						barang[j][3] = temp;
					} else if (posisi[i] == 3) {
						var temp = barang[j][1];
						barang[j][1] = barang[j][2];
						barang[j][2] = temp;
					} else if (posisi[i] == 4) {
						var temp = barang[j][1];
						barang[j][1] = barang[j][3];
						barang[j][3] = temp;
					} else if (posisi[i] == 5) {
						var temp = barang[j][2];
						barang[j][2] = barang[j][3];
						barang[j][3] = temp;
				}
			}
		}}
		visual(fittest);
		function visual(fittest) {

			var kpanjang = this.kontainer[0]*100 ;
			var klebar = this.kontainer[1]*100 ;
			var ktinggi = this.kontainer[2]*100;
			var kberat = this.kontainer[3];
			var lebarterpakai = 0;
			var tinggiterpakai = 0;
			var panjangterpakai = 0;
			var layerPanjang = 0;
			var lebar = 0 ;
			var panjang = 0 ;
			var barangmasuk = [];
			//merah, kuning, hijau, biru, abu
			// var warna = [0xFA000F,0xFCC419,0x36B14D,0x5C7CFA,0x868E96];
			//id,panjang,lebar,tinggi, berat
			for (var i = 0; i < fittest.length; i++) {
				var brg = null;
				for (var o = 0; o < barang.length; o++) {
					if (barang[o][0]==fittest[i]) {
						brg = barang[o];
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
				if (brg[4]<=kberat) { //tanya
					if (brg[1]<=kpanjang-layerPanjang) {
						// console.log("lebar = "+brg[2]+"<="+(klebar-lebarterpakai));
						if (brg[2]<=klebar-lebarterpakai&&brg[3]<=ktinggi) {
							barangmasuk.push(brg[0]);
							//buat objek
							var color = "#" + ((Math.random() * 0xffffff) << 0).toString(16);
							var geometry = new THREE.BoxGeometry( brg[1], brg[3], brg[2]);
							var material = new THREE.MeshBasicMaterial( {
								color: color,
								transparent: true,
								opacity: 1
							} );
							// var material = new THREE.MeshBasicMaterial( { color: warna[barangmasuk.length-1] } );
							var cube = new THREE.Mesh( geometry, material );
							//kontainer p : 1000, l : 300, t : 300
							//position p,t,l
							cube.position.set((kpanjang/2)-(brg[1]/2)-layerPanjang,((ktinggi/2*-1)+(brg[3]/2)),150-lebarterpakai-(brg[2]/2));
							grubBarang.add( cube );
							console.log(brg);
							console.log("alas");
							console.log(panjangterpakai);
							kberat-=brg[4];
							//lihat lagi
							//add info
							var element = $("#isiInfo");
							element.append("<tr>");
							element.append("<td><span class=\"icon oi oi-media-stop\" style=\"color:"+color+";\"></span></td>");
							element.append("<td><span>id : "+brg[0]+"</span></td>");
							element.append("<td>-> "+brg[1]+"x"+brg[2]+"x"+brg[3]+"</td>");
							element.append("</tr>");

							if (brg[1]>panjangterpakai) {
								panjangterpakai=brg[1];
							}
							if (tinggiterpakai==0) {
								tinggiterpakai=brg[3];
								lebar = brg[2];
								panjang = brg[1];
							} else {
								tinggiterpakai+=brg[3];
							}
							for (var j = 0; j < fittest.length; j++) { //for brg atas
								var brgLanjutan = null;
								for (var o = 0; o < barang.length; o++) {
									if (barang[o][0]==fittest[j]) {
										brgLanjutan = barang[o];
									}
								}
								let stop = false;
								for (var k = 0; k < barangmasuk.length; k++) {
									if (brgLanjutan[0]==barangmasuk[k]) {
										stop = true;
									}
								}
								if (stop==true) {
									continue;
								}
								if (brgLanjutan[2]<=lebar&&brgLanjutan[1]<=panjang&&brgLanjutan[3]<=ktinggi-tinggiterpakai) {
									barangmasuk.push(brgLanjutan[0]);
									//buat objek
									var color = "#" + ((Math.random() * 0xffffff) << 0).toString(16);
									var geometry = new THREE.BoxGeometry( brgLanjutan[1], brgLanjutan[3], brgLanjutan[2]);
									var material = new THREE.MeshBasicMaterial( {
										color: color,
										transparent: true,
										opacity: 1
									} );
									// var material = new THREE.MeshBasicMaterial( { color: warna[barangmasuk.length-1] } );
									var cube = new THREE.Mesh( geometry, material );
									//kontainer p : 1000, l : 300, t : 300
									//position p,t,l
									cube.position.set((kpanjang/2)-(brgLanjutan[1]/2)-layerPanjang,(((ktinggi/2)*-1)+(brgLanjutan[3]/2)+tinggiterpakai),150-(brgLanjutan[2]/2)-lebarterpakai);
									grubBarang.add( cube );
									console.log(brgLanjutan);
									console.log("atas");
									console.log(panjangterpakai);
									kberat-=brgLanjutan[4];
									tinggiterpakai+=brgLanjutan[3];
									panjang = brgLanjutan[1];//
									lebar = brgLanjutan[2];
									//add info
									var element = $("#isiInfo");
									element.append("<tr>");
									element.append("<td><span class=\"icon oi oi-media-stop\" style=\"color:"+color+";\"></span></td>");
									element.append("<td><span>id : "+brgLanjutan[0]+"</span></td>");
									element.append("<td>-> "+brgLanjutan[1]+"x"+brgLanjutan[1]+"x"+brgLanjutan[1]+"</td>");
									element.append("</tr>");

								} else {
									// console.log("barang p,l,t : "+brgLanjutan[1]+", "+brgLanjutan[2]+", "+brgLanjutan[3]);
									// console.log("alas p,l,t : "+panjang+", "+lebar+", "+(ktinggi-tinggiterpakai));
								}
							} // for brg atas
							lebarterpakai+=brg[2];
							tinggiterpakai=0;
						}//lebar dan tinggi
						else {
							//baris baru
							layerPanjang+=panjangterpakai;
							console.log("ket:"+brg[1]+"<="+(kpanjang-layerPanjang));
							if (brg[1]<=kpanjang-layerPanjang&&brg[2]<=klebar&&brg[3]<=ktinggi&&brg[4]<=kberat) {
								panjangterpakai = 0;
								lebarterpakai = 0;
								tinggiterpakai = 0;

								barangmasuk.push(brg[0]);
								//buat objek
								var color = "#" + ((Math.random() * 0xffffff) << 0).toString(16);
								var geometry = new THREE.BoxGeometry( brg[1], brg[3], brg[2]);
								var material = new THREE.MeshBasicMaterial( {
									color: color,
									transparent: true,
									opacity: 1
								} );
								// var material = new THREE.MeshBasicMaterial( { color: warna[barangmasuk.length-1] } );
								var cube = new THREE.Mesh( geometry, material );
								//kontainer p : 1000, l : 300, t : 300
								//position p,t,l
								cube.position.set((kpanjang/2)-(brg[1]/2)-layerPanjang,((ktinggi/2*-1)+(brg[3]/2)),150-lebarterpakai-(brg[2]/2));
								grubBarang.add( cube );
								console.log(brg);
								console.log("barisbaru");
								console.log(panjangterpakai);
								kberat-=brg[4];
								//lihat lagi
								//add info
								var element = $("#isiInfo");
								element.append("<tr>");
								element.append("<td><span class=\"icon oi oi-media-stop\" style=\"color:"+color+";\"></span></td>");
								element.append("<td><span>id : "+brg[0]+"</span></td>");
								element.append("<td>-> "+brg[1]+"x"+brg[2]+"x"+brg[3]+"</td>");
								element.append("</tr>");

								if (brg[1]>panjangterpakai) {
									panjangterpakai=brg[1];
								}
								if (tinggiterpakai==0) {
									tinggiterpakai=brg[3];
									lebar = brg[2];
									panjang = brg[1];
								} else {
									tinggiterpakai+=brg[3];
								}
								lebarterpakai=brg[2];
							}
						}
					}//panjang
				}
			}
			scene.add(grubBarang);
			render();
			// console.log(barangmasuk);
		}//visual
	}//success
});


//controller
var FizzyText = function() {
	this.wireframe = false;
	this.transparent = 1.0;
};

window.onload = function() {
	var text = new FizzyText();
	var gui = new dat.GUI();
	gui.add(text, 'wireframe');
	gui.add(text, 'transparent', 0, 1).onChange(val => {
		setOpacity(grubBarang, val);
	});
};

function setOpacity(obj, opacity) {
	obj.traverse(child => {
		if (child instanceof THREE.Mesh) {
			child.material.opacity = opacity;
			render();
		}
	});
}

//OrbitControls
var controls;
renderer.render( scene, camera );
controls = new THREE.OrbitControls( camera, renderer.domElement );
controls.addEventListener( 'change', render );
controls.enableZoom = true;
// camera.position.set( 10, 5, 7 );
camera.position.set( 1000, 500, 700 );
controls.update();

function update(event)
{
	controls.update();
}

function render() {
	renderer.render( scene, camera );
}
</script>
</body>
</html>
