<html>
<head>
	<title>My first three.js app</title>
	<style>
	body { margin: 0; }
	canvas { width: 100%; height: 100% }
	table {
		color: white;
		width: 100%;
		text-align: center;
	}
	table {
    width: 100%;
    display:block;
	}
	thead {
	    display: inline-block;
	    width: 100%;
			table-layout: fixed;
	}
	tbody {
	    height: 80%;
	    display: inline-block;
	    width: 100%;
	    overflow: auto;
			table-layout: fixed;
			scrollbar-width:thin;
	}
	.scroll {
		overflow-y: auto;
		overflow: scroll;
		height: 85%;
		overflow-x: hidden;
		scrollbar-width:thin;
	}
	.info {
		position:fixed;
		color: white;
		height:400px;
		width:220px;padding: 10px;
		font-size: 4px;
		background-color:rgb(26, 26, 26);
		/* opacity:40%; */
		top: 50%;
		-ms-transform: translateY(-50%);
		transform: translateY(-50%);
	}
	.icon {
		font-size: 26px;
	}
	.ket-kontainer {
		position:absolute;
		height:auto;
		width:auto;
		padding: 10px;
		font-size: 10pt;
		background-color:rgb(26, 26, 26);
		color: rgb(255, 255, 255);
		/* opacity:40%; */
		bottom: 0;
		overflow-y: auto;
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
			<thead>
				<tr>
					<th width="50">Warna</th>
					<th width="25">ID</th>
					<th width="25">P</th>
					<th width="25">L</th>
					<th width="25">T</th>
					<th width="25">B</th>
				</tr>
			</thead>
			<tbody id="isiInfo" rules="cols">
				<!-- isi -->
			</tbody>
		</table>
	</div>
	<div class="ket-kontainer">
		<script type="text/javascript">
		var size = Cookies.getJSON('kontainer');
		document.write("Panjang : "+size[0]+" m, Lebar : "+size[1]+" m, Tinggi : "+size[2]+" m, Berat maks : "+size[3]+" kg");
		</script>
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
// var kontainer = [6,3,3,400];
var kontainer = Cookies.getJSON('kontainer');
for (var i = 0; i < kontainer.length; i++) {
	kontainer[i] = parseFloat(kontainer[i]);
}
console.log(kontainer);
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
		console.log(pilihan);
		var barang = [];
		for (var i = 0; i < data.length; i++) {
			for (var j = 0; j < pilihan.length; j++) {
				if (data[i].id==pilihan[j]) {
					barang.push([]);
					barang[j][0] = parseFloat(data[i].id);
					barang[j][1] = parseFloat(data[i].panjang);
					barang[j][2] = parseFloat(data[i].lebar);
					barang[j][3] = parseFloat(data[i].tinggi);
					barang[j][4] = parseFloat(data[i].berat);
				}
			}
		}
		// console.log(pilihan);
		var algoritma = new Genetik(kontainer,barang);
		algoritma.start();
		var fittest = algoritma.fittest.genes;
		var rotasi = algoritma.fittest.rotasi;
		// console.log(fittest);

		//test
		// var fittest = [38,39,40,41,42,43];
		// var rotasi = [0,0,0,0,0,0];
		//rotasi
		// 0. x, y, z => p, l, t
		// 1. x, y, z => t, p, l
		// 2. x, y, z => l, t, p
		// 3. x, y, z => l, p, t
		// 4. x, y, z => t, l, p
		// 5. x, y, z => p, t, l
		for (var i = 0; i < rotasi.length; i++) {
			for (var j = 0; j < barang.length; j++) {
				if (barang[j][0] == fittest[i]) {
					if (rotasi[i] == 0) {
						//tetap
					} else if (rotasi[i] == 1) {
						var temp = barang[j][1];
						barang[j][1] = barang[j][3];
						barang[j][3] = barang[j][2];
						barang[j][2] = temp;
					} else if (rotasi[i] == 2) {
						var temp = barang[j][1];
						barang[j][1] = barang[j][2];
						barang[j][2] = barang[j][3];
						barang[j][3] = temp;
					} else if (rotasi[i] == 3) {
						var temp = barang[j][1];
						barang[j][1] = barang[j][2];
						barang[j][2] = temp;
					} else if (rotasi[i] == 4) {
						var temp = barang[j][1];
						barang[j][1] = barang[j][3];
						barang[j][3] = temp;
					} else if (rotasi[i] == 5) {
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
					// console.log("awal :"+brg);
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
								cube.position.set((kpanjang/2)-(brg[1]/2)-layerPanjang,((ktinggi/2*-1)+(brg[3]/2)),(klebar/2)-lebarterpakai-(brg[2]/2));
								// console.log(klebar/2+","+lebarterpakai+","+brg[2]/2);
								grubBarang.add( cube );
								// console.log(brg);
								// console.log("alas");
								// console.log(panjangterpakai);
								kberat-=brg[4];
								//lihat lagi
								//add info
								var element = $("#isiInfo");
								element.append("<tr>");
								element.append("<td width='50'><span class=\"icon oi oi-media-stop\" style=\"color:"+color+";\"></span></td>");
								element.append("<td width='25'>"+brg[0]+"</td>");
								element.append("<td width='25'>"+brg[1]+"</td>");
								element.append("<td width='25'>"+brg[2]+"</td>");
								element.append("<td width='25'>"+brg[3]+"</td>");
								element.append("<td width='25'>"+brg[4]+"</td>");
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
									if (brgLanjutan[2]<=lebar&&brgLanjutan[1]<=panjang&&brgLanjutan[3]<=ktinggi-tinggiterpakai&&brgLanjutan[4]<=kberat) {
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
										cube.position.set((kpanjang/2)-(brgLanjutan[1]/2)-layerPanjang,(((ktinggi/2)*-1)+(brgLanjutan[3]/2)+tinggiterpakai),(klebar/2)-(brgLanjutan[2]/2)-lebarterpakai);
										grubBarang.add( cube );
										// console.log(brgLanjutan);
										// console.log("atas");
										// console.log(panjangterpakai);
										kberat-=brgLanjutan[4];
										tinggiterpakai+=brgLanjutan[3];
										panjang = brgLanjutan[1];//
										lebar = brgLanjutan[2];
										//add info
										var element = $("#isiInfo");
										element.append("<tr>");
										element.append("<td><span class=\"icon oi oi-media-stop\" style=\"color:"+color+";\"></span></td>");
										element.append("<td>"+brgLanjutan[0]+"</td>");
										element.append("<td>"+brgLanjutan[1]+"</td>");
										element.append("<td>"+brgLanjutan[2]+"</td>");
										element.append("<td>"+brgLanjutan[3]+"</td>");
										element.append("<td>"+brgLanjutan[4]+"</td>");
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
								if (brg[1]<=kpanjang-(layerPanjang+panjangterpakai)&&brg[2]<=klebar&&brg[3]<=ktinggi&&brg[4]<=kberat) {
									// console.log("ket:"+brg[2]+"<="+(klebar));
									// console.log(brg);
									layerPanjang+=panjangterpakai;
									panjangterpakai = 0;
									lebarterpakai = 0;
									tinggiterpakai = 0;
									i--;
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

	window.addEventListener( 'resize', onWindowResize, false );

	function onWindowResize() {

		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();
		renderer.setSize( window.innerWidth, window.innerHeight );
		render();
	}
</script>
</body>
</html>
