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
	//id,panjang,lebar,tinggi, berat
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
			var sisapanjang = this.kontainer[0] ;
			var sisalebar = this.kontainer[1] ;
			var sisatinggi = this.kontainer[2];

			var genes = this.genes;
			var barangmasuk = [];
			//id,panjang,lebar,tinggi, berat
			for (var i = 0; i < this.barang.length; i++) {
				if (this.barang[genes[i]][4]<kberat) {
					if (barang[genes[i]][2]<sisalebar) {
						if (barang[genes[i]][3]<sisatinggi) {
							if (barang[genes[i]][1]<sisapanjang) {
								barangmasuk.push(genes[i]);
								kberat-=this.barang[genes[i]][4];
								sisalebar-=this.barang[genes[i]][2];
								sisatinggi-=this.barang[genes[i]][3];
								sisapanjang-=this.barang[genes[i]][1];
							} //panjang
						} //tinggi
					} //lebar
					else {
						if (barang[genes[i]][2]<klebar&&barang[genes[i]][3]<sisatinggi) {
							barangmasuk.push(genes[i]);
							kberat-=this.barang[genes[i]][4];
							sisatinggi-=this.barang[genes[i]][3];
						} else if (barang[genes[i]][2]<klebar&&barang[genes[i]][3]<ktinggi&&barang[genes[i]][1]<sisapanjang) {
							barangmasuk.push(genes[i]);
							kberat-=this.barang[genes[i]][4];
							sisapanjang-=this.barang[genes[i]][1];
						}
					}
				} //berat
			}

			//hitung volume barang/volume kontainer * 100%
			var vol_total_barang = 0
			var vol_kontainer = kpanjang*klebar*ktinggi;
			for (var i = 0; i < barangmasuk.length; i++) {
				var vol_barang = barang[barangmasuk[i]][1]*barang[barangmasuk[i]][2]*barang[barangmasuk[i]][3];
				vol_total_barang+=vol_barang;
			}
			this.fitness = vol_total_barang/vol_kontainer*100;
		}

	}

	//pupulasi
	class Population{

		constructor(kontainer,barang){
			//populasi 10 individu
			this.individuals = new Individual[10];
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
			this.fittest = individuals[maxFitIndex].fitness;
			return individuals[maxFitIndex];
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
			return individuals[maxFit2];
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
			getFittest();
		}


	}
	//mulai algoritma
	var population = new Population(kontainer,barang);
  var fittest;
  var secondFittest;
	var generationCount = 0;
	population.calculateFitness();
	//Selection
	void selection() {

		//Select the most fittest individual
		fittest = population.getFittest();

		//Select the second most fittest individual
		secondFittest = population.getSecondFittest();
	}

	//Crossover
	void crossover() {
		//nentukan crossOverPoint
		var crossOverPoint = Math.floor(Math.random() * population.individuals[0].length);

		//Swap values among parents
		for (var i = 0; i < crossOverPoint; i++) {
			var temp = fittest.genes[i];
			fittest.genes[i] = secondFittest.genes[i];//set gene 1 = gene 2
			for (var j = 0; j < fittest.genes.length; j++) {
				if (fittest.genes[j]==fittest.genes[i] && j!=i) {
					fittest.genes[j] = temp;
				}
			}
			secondFittest.genes[i] = temp; //set gene 2 = gene 1
			for (var j = 0; j < fittest.genes.length; j++) {
				if (secondFittest.genes[j]==temp && j!=i) {
					secondFittest.genes[j] = fittest.genes[i];
				}
			}
		}

	}

	//Mutation
	void mutation() {
		Random rn = new Random();

		//Select a random mutation point
		int mutationPoint = rn.nextInt(population.individuals[0].geneLength);

		//Flip values at the mutation point
		if (fittest.genes[mutationPoint] == 0) {
			fittest.genes[mutationPoint] = 1;
		} else {
			fittest.genes[mutationPoint] = 0;
		}

		mutationPoint = rn.nextInt(population.individuals[0].geneLength);

		if (secondFittest.genes[mutationPoint] == 0) {
			secondFittest.genes[mutationPoint] = 1;
		} else {
			secondFittest.genes[mutationPoint] = 0;
		}
	}

	//Get fittest offspring
	Individual getFittestOffspring() {
		if (fittest.fitness > secondFittest.fitness) {
			return fittest;
		}
		return secondFittest;
	}


	//Replace least fittest individual from most fittest offspring
	void addFittestOffspring() {

		//Update fitness values of offspring
		fittest.calcFitness();
		secondFittest.calcFitness();

		//Get index of least fit individual
		int leastFittestIndex = population.getLeastFittestIndex();

		//Replace least fittest individual from most fittest offspring
		population.individuals[leastFittestIndex] = getFittestOffspring();
	}
	console.log("Generation: " + generationCount + " Fittest: " + population.fittest);

	//Barang
	// var barang = [];
	$.ajax({
		type : "GET",
		url  : "<?php echo site_url("Visual3d/barang")?>",
		dataType : "JSON",
		success: function(data){
			// barang = data;
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
