
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
	var kontainer = [10,3,3,400];
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

	class Random {
		constructor(angka){
			this.angka = new Array(angka);
			for (var i = 0; i < angka; i++) {
				this.angka[i] = i;
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
			for (var i = 0; i < this.barang.length; i++) {
				var brg = this.barang[i];
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
					if (brg[1]<=kpanjang-layerPanjang) {
						if (brg[2]<=klebar-lebarterpakai&&brg[3]<=ktinggi) {
							barangmasuk.push(brg[0]);
							//kontainer p : 1000, l : 300, t : 300
							//position p,t,l
							kberat-=brg[4];
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
							for (var j = 0; j < this.barang.length; j++) {
								var brgLanjutan = this.barang[j];
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
							layerPanjang+=panjangterpakai;
							panjangterpakai = 0;
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

	//pupulasi
	class Population{

		constructor(kontainer,barang){
			//populasi 10 individu
			this.individuals = new Array(10);
			for (var i = 0; i < this.individuals.length; i++) {
				//buat individu
				this.individuals[i] = new Individual(kontainer,barang);
			}
		}
		//Get the fittest individual
		getFittest() {
			var maxFit = 0;
			var maxFitIndex = 0;
			for (var i = 0; i < this.individuals.length; i++) {
				if (maxFit <= this.individuals[i].fitness) {
					maxFit = this.individuals[i].fitness;
					maxFitIndex = i;
				}
			}
			// console.log(maxFitIndex);
			// this.fittest = this.individuals[maxFitIndex].fitness;
			this.fittest = maxFit;
			return this.individuals[maxFitIndex];
		}
		//Get the second most fittest individual
		getSecondFittest() {
			var maxFit1 = 0;
			var maxFit2 = 0;
			for (var i = 0; i < this.individuals.length; i++) {
				if (this.individuals[i].fitness > this.individuals[maxFit1].fitness) {
					maxFit2 = maxFit1;
					maxFit1 = i;
				} else if (this.individuals[i].fitness > this.individuals[maxFit2].fitness) {
					maxFit2 = i;
				}
			}
			return this.individuals[maxFit2];
		}
		//Get index of least fittest individual
		getLeastFittestIndex() {
			var minFitVal = 100;
			var minFitIndex = 0;
			for (var i = 0; i < this.individuals.length; i++) {
				if (minFitVal >= this.individuals[i].fitness) {
					minFitVal = this.individuals[i].fitness;
					minFitIndex = i;
				}
			}
			return minFitIndex;
		}
		//Calculate fitness of each individual
		calculateFitness() {

			for (var i = 0; i < this.individuals.length; i++) {
				this.individuals[i].calcFitness();
			}
			this.getFittest();
		}


	}

	class Genetik {
		constructor(kontainer,barang) {
			//mulai algoritma
			this.population = new Population(kontainer,barang);
			this.fittest;
			this.secondFittest;
			this.generationCount = 0;
		}
		//Selection
		selection() {

			//Select the most fittest individual
			this.fittest = this.population.getFittest();

			//Select the second most fittest individual
			this.secondFittest = this.population.getSecondFittest();
		}

		//Crossover
		crossover() {
			//nentukan crossOverPoint
			// console.log(this.population.individuals);
			var crossOverPoint = Math.floor(Math.random() * this.population.individuals[0].length);

			//Swap values among parents
			for (var i = 0; i < crossOverPoint; i++) {
				var temp = this.fittest.genes[i];
				this.fittest.genes[i] = this.secondFittest.genes[i];//set gene 1 = gene 2
				for (var j = 0; j < this.fittest.genes.length; j++) {
					if (this.fittest.genes[j]==this.fittest.genes[i] && j!=i) {
						this.fittest.genes[j] = temp;
					}
				}
				this.secondFittest.genes[i] = temp; //set gene 2 = gene 1
				for (var j = 0; j < this.fittest.genes.length; j++) {
					if (this.secondFittest.genes[j]==temp && j!=i) {
						this.secondFittest.genes[j] = this.fittest.genes[i];
					}
				}
			}
		}

		//Mutation
		mutation() {

			//Select a random mutation point
			var mutationPoint = Math.floor(Math.random() * this.population.individuals[0].length);
			var mutationPoint2 = Math.floor(Math.random() * this.population.individuals[0].length);
			// 1,2,3,4
			//Flip values at the mutation point
			while (mutationPoint == mutationPoint2) {
				mutationPoint2 = Math.floor(Math.random() * this.population.individuals[0].length);
			}
			var temp = this.fittest.genes[mutationPoint];
			this.fittest.genes[mutationPoint] = this.fittest.genes[mutationPoint2];
			this.fittest.genes[mutationPoint2] = temp;

			//Select a random mutation point
			mutationPoint = Math.floor(Math.random() * this.population.individuals[0].length);
			mutationPoint2 = Math.floor(Math.random() * this.population.individuals[0].length);

			//Flip values at the mutation point
			while (mutationPoint == mutationPoint2) {
				mutationPoint2 = Math.floor(Math.random() * this.population.individuals[0].length);
			}
			var temp = this.secondFittest.genes[mutationPoint];
			this.secondFittest.genes[mutationPoint] = this.secondFittest.genes[mutationPoint2];
			this.secondFittest.genes[mutationPoint2] = temp;

		}

		//Get fittest offspring
		getFittestOffspring() {
			if (this.fittest.fitness > this.secondFittest.fitness) {
				return this.fittest;
			}
			return this.secondFittest;
		}


		//Replace least fittest individual from most fittest offspring
		addFittestOffspring() {

			//Update fitness values of offspring
			this.fittest.calcFitness();
			this.secondFittest.calcFitness();

			//Get index of least fit individual
			var leastFittestIndex = this.population.getLeastFittestIndex();

			//Replace least fittest individual from most fittest offspring
			this.population.individuals[leastFittestIndex] = this.getFittestOffspring();
		}
		start(){
			this.population.calculateFitness();
			console.log("Generation: " + this.generationCount + " Fittest: " + this.population.fittest);
			//While population gets an individual with maximum fitness
			while (this.population.fittest < 100 && this.generationCount<100) {
				console.log(this.population.individuals);
				this.generationCount++;

				//Do selection
				this.selection();

				//Do crossover
				this.crossover();

				//Do mutation under a random probability
				if (Math.floor(Math.random() * 100)+1 < 5) {
					this.mutation();
				}

				//Add fittest offspring to population
				this.addFittestOffspring();

				//Calculate new fitness value
				this.population.calculateFitness();

				console.log("Generation: " + this.generationCount + " Fittest: " + this.population.fittest);
			}
			console.log("\nSolution found in generation " + this.generationCount);
			console.log("Fitness: "+this.population.getFittest().fitness);
			console.log("Genes: "+this.population.getFittest().genes.join());
			console.log("");
		}
	}

	//Barang
	// var barang = [];
	$.ajax({
		type : "GET",
		url  : "<?php echo site_url("Visual3d/barang")?>",
		dataType : "JSON",
		success: function(data){
			//id,panjang,lebar,tinggi, berat
			var barang = [];
			for (var i = 0; i < data.length; i++) {
				barang.push([]);
				barang[i][0] = parseInt(data[i].id);
				barang[i][1] = parseInt(data[i].panjang);
				barang[i][2] = parseInt(data[i].lebar);
				barang[i][3] = parseInt(data[i].tinggi);
				barang[i][4] = parseInt(data[i].berat);
			}
			// console.log(barang);
			var algoritma = new Genetik(kontainer,barang);
			algoritma.start();
			var fittest = algoritma.fittest.genes;
			// var fittest = [0,1,2,3,4,5];
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
				var warna = [0xFA000F,0xFCC419,0x36B14D,0x5C7CFA,0x868E96];
				//id,panjang,lebar,tinggi, berat
				for (var i = 0; i < barang.length; i++) {
					var brg = barang[fittest[i]];
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
								kberat-=brg[4];
								//lihat lagi
								//add info
								var element = $("#isiInfo");
								element.append("<tr>");
								element.append("<td><span class=\"icon oi oi-media-stop\" style=\"color:"+color+";\"></span></td>");
								element.append("<td><span>id : "+brg[0]+"</span></td>");
								element.append("<td>-> "+brg[1]+"x"+brg[2]+"x"+brg[3]+"</td>");
								element.append("</tr>");
								console.log("alas");

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
								for (var j = 0; j < barang.length; j++) { //for brg atas
									var brgLanjutan = barang[fittest[j]];
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
										kberat-=brgLanjutan[4];
										tinggiterpakai+=brgLanjutan[3];
										panjang = brgLanjutan[1];//
										lebar = brgLanjutan[2];
										console.log("tumpuk");
										console.log(tinggiterpakai);
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
								console.log("tinggi"+tinggiterpakai);
							}//lebar dan tinggi
							else {
								layerPanjang+=panjangterpakai;
								panjangterpakai = 0;
								lebarterpakai = 0;
								tinggiterpakai = 0;
								barangmasuk.push(brg[0]);
							}
						}//panjang
					}
				}
				scene.add(grubBarang);
				render();
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
