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
			var sisapanjang = this.kontainer[0]*100 ;
			var sisalebar = this.kontainer[1]*100 ;
			var sisatinggi = this.kontainer[2]*100;
			var barangmasuk = [];
			// console.log("genes : "+this.genes);
			//id,panjang,lebar,tinggi, berat
			for (var i = 0; i < this.barang.length; i++) {
				var brg = this.barang[this.genes[i]];
				if (brg[4]<kberat) {
					if (brg[2]<sisalebar) {
						if (brg[3]<sisatinggi) {
							if (brg[1]<sisapanjang) {
								barangmasuk.push(this.genes[i]);
								kberat-=brg[4];
								sisalebar-=brg[2];
								sisatinggi-=brg[3];
								sisapanjang-=brg[1];
							} //panjang
						} //tinggi
					} //lebar
					else {
						if (brg[2]<klebar&&brg[3]<sisatinggi) {
							barangmasuk.push(this.genes[i]);
							kberat-=brg[4];
							sisatinggi-=brg[3];
						} else if (brg[2]<klebar&&brg[3]<ktinggi&&brg[1]<sisapanjang) {
							barangmasuk.push(this.genes[i]);
							kberat-=brg[4];
							sisapanjang-=brg[1];
							sisatinggi=ktinggi-brg[3];
							sisalebar=klebar-brg[2];

						}
					}
				} //berat
			}
			// console.log("barang masuk : " +barangmasuk);
			//hitung volume barang/volume kontainer * 100%
			var vol_total_barang = 0
			var vol_kontainer = kpanjang*klebar*ktinggi;
			for (var i = 0; i < barangmasuk.length; i++) {
				var vol_barang = this.barang[barangmasuk[i]][1]*this.barang[barangmasuk[i]][2]*this.barang[barangmasuk[i]][3];
				vol_total_barang+=vol_barang;
			}
			this.fitness = (vol_total_barang/vol_kontainer)*100;
			// console.log(this.fitness);
		}

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
				barang[i][0] = data[i].id;
				barang[i][1] = data[i].panjang;
				barang[i][2] = data[i].lebar;
				barang[i][3] = data[i].tinggi;
				barang[i][4] = data[i].berat;
			}
			// console.log(barang);
			var algoritma = new Genetik(kontainer,barang);
			algoritma.start();
			var fittest = algoritma.fittest.genes;
			visual(fittest);
			function visual(fittest) {

				var kpanjang = this.kontainer[0]*100 ;
				var klebar = this.kontainer[1]*100 ;
				var ktinggi = this.kontainer[2]*100;
				var kberat = this.kontainer[3];
				var sisapanjang = this.kontainer[0]*100 ;
				var sisalebar = this.kontainer[1]*100 ;
				var sisatinggi = this.kontainer[2]*100;
				//id,panjang,lebar,tinggi, berat
				for (var i = 0; i < barang.length; i++) {
					var brg = barang[fittest[i]];
					if (brg[4]<kberat) {
						if (brg[2]<sisalebar) {
							if (brg[3]<ktinggi) {
								if (brg[1]<sisapanjang) {

									var geometry = new THREE.BoxGeometry( brg[1], brg[3], brg[2]);
									var material = new THREE.MeshBasicMaterial( { color: Math.random() * 0xffffff } );
									var cube = new THREE.Mesh( geometry, material );
									//kontainer p : 1000, l : 300, t : 300
									//position p,t,l
									cube.position.set((sisapanjang/2)-(brg[1]/2),((ktinggi/2*-1)+(brg[3]/2)),(sisalebar/2)-(brg[2]/2));
									scene.add( cube );
									kberat-=brg[4];
									sisalebar-=brg[2];
									sisatinggi-=brg[3];
									sisapanjang-=brg[1];
									console.log("normal");

								} //panjang
							} //tinggi
						} //lebar
						else {
							//diatas
							if (brg[2]<klebar&&brg[3]<sisatinggi) {
								var geometry = new THREE.BoxGeometry( brg[1], brg[3], brg[2]);
								var material = new THREE.MeshBasicMaterial( { color: Math.random() * 0xffffff } );
								var cube = new THREE.Mesh( geometry, material );
								//kontainer p : 1000, l : 300, t : 300
								//position p,t,l
								cube.position.set((sisapanjang/2)-(brg[1]/2),((sisatinggi/2)-(brg[3]/2))*-1,(klebar/2)-(brg[2]/2));
								scene.add( cube );
								kberat-=brg[4];
								sisatinggi-=brg[3];
								console.log("diatas");
								//dibelakang
							} else if (brg[2]<klebar&&brg[3]<ktinggi&&brg[1]<sisapanjang) {
								var geometry = new THREE.BoxGeometry( brg[1], brg[3], brg[2]);
								var material = new THREE.MeshBasicMaterial( { color: Math.random() * 0xffffff } );
								var cube = new THREE.Mesh( geometry, material );
								//kontainer p : 1000, l : 300, t : 300
								//position p,t,l
								cube.position.set((sisapanjang/2)-(brg[1]/2),((ktinggi/2)-(brg[3]/2))*-1,(klebar/2)-(brg[2]/2));
								scene.add( cube );
								kberat-=brg[4];
								sisapanjang-=brg[1];
								sisatinggi=ktinggi-brg[3];
								sisalebar=klebar-brg[2];
								console.log("barisbaru");
							}
						}
					} //berat
				}

			}
			// var geometry = new THREE.BoxGeometry( 50, 70, 40);
			// var material = new THREE.MeshBasicMaterial( { color: 0x00fa9a } );
			// var cube = new THREE.Mesh( geometry, material );
			// //kontainer p : 1000, l : 300, t : 300
			// //position p,t,l
			//
			// cube.position.set(475,-115,130);
			// scene.add( cube );
		}//success
	});

	// var geometry = new THREE.BoxGeometry( 50, 70, 40);
	// var material = new THREE.MeshBasicMaterial( { color: 0x00fa9a } );
	// var cube = new THREE.Mesh( geometry, material );
	// //kontainer p : 1000, l : 300, t : 300
	// //position p,t,l
	// cube.position.set(475,-115,130);
	// scene.add( cube );



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