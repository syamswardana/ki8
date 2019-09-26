<html>
<head>
	<title>My first three.js app</title>
	<style>
	body { margin: 0; }
	canvas { width: 100%; height: 100% }
	</style>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/three.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/OrbitControls.js"></script>
</head>
<body>
	<script>

	var scene = new THREE.Scene();
	var color = new THREE.Color( 0x444444 );
	scene.background = color;
	var camera = new THREE.PerspectiveCamera( 75, window.innerWidth/window.innerHeight, 1, 2000 );

	var renderer = new THREE.WebGLRenderer();
	renderer.setSize( window.innerWidth, window.innerHeight );
	document.body.appendChild( renderer.domElement );

	//kontainer
	var kontainer = [10,3,3,400];
	var geometryKontainer = new THREE.BoxGeometry( 10, 3, 3);
	var edges = new THREE.EdgesGeometry( geometryKontainer );
	var line = new THREE.LineSegments( edges, new THREE.LineBasicMaterial( { color: 0xffffff } ) );
	scene.add( line );

	//Barang
	//id,panjang,lebar,tinggi
	var barang = [
			[0,10,21,9,1],
			[0,4,8,7,1],
			[0,11,20,10,1],
			[0,12,5,7,1],
			[0,13,8,20,1]
	];

	class Random {
		constructor(angka){
			this.angka = new Array(angka);
			for (var i = 0; i < angka; i++) {
				this.angka[i] = i+1;
			}
		}
		pop(){
			var i = Math.floor(Math.random() * this.angka.length);
			// console.log();
			return parseInt(this.angka.splice(i,1));
		}
	}

	//Individual class
	class Individual {

		//kontainer,genes,rotasi

		constructor(kontainer,barang) {
			// console.log(jumlah);
			var rn = new Random(barang.length);
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
			var kpanjang = this.kontainer[0] ;
			var klebar = this.kontainer[1] ;
			var ktinggi = this.kontainer[2];
			var kberat = this.kontainer[3];


			for (var i = 0; i < this.barang.length; i++) {
				if (barang[i][1]<kpanjang && barang[i][2]<klebar && barang[i][3]<ktinggi
				&& barang[i][4]<kberat) {

				}
			}
		}

	}

	var ind = new Individual(kontainer,barang);
	console.log(ind.rotasi);

	//Barang
	var barang = [];
	$.ajax({
		type : "GET",
		url  : "<?php echo site_url("Visual3d/barang")?>",
		dataType : "JSON",
		success: function(data){
			barang = data;
		}
	});
	setTimeout(function(){

	}, 500);

	var geometry = new THREE.BoxGeometry( 1, 1, 1);
	var material = new THREE.MeshBasicMaterial( { color: 0x00fa9a } );
	var cube = new THREE.Mesh( geometry, material );
	scene.add( cube );



	//OrbitControls
	var controls;
	renderer.render( scene, camera );
	controls = new THREE.OrbitControls( camera, renderer.domElement );
	controls.addEventListener( 'change', render );
	controls.enableZoom = true;
	camera.position.set( 10, 5, 7 );
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
