
class Genetik {
  constructor(kontainer,barang) {
    //mulai algoritma
    this.population = new Population(kontainer,barang);
    this.fittest;
    this.secondFittest;
    this.generationCount = 0;
    this.cr = 0;
    this.mr = 1;
    this.os = [];
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
    var crossover = 0;
    var ocr = this.cr * this.population.individuals.length;
    var p1,p2;
    if (ocr % 2 == 0) {
      crossover = ocr/2;
    } else {
      crossover = (ocr+1)/2;
    }
    for (var j = 0; j < crossover; j++) {
      p1 = this.fittest;
      p2 = this.secondFittest;
      //nentukan crossOverPoint
      // console.log(this.population.individuals);
      var crossOverPoint = Math.floor(Math.random() * this.population.individuals[0].length);
      //Swap values among parents
      for (var i = 0; i < crossOverPoint; i++) {
        var temp = this.p1.genes[i];
        var tempRotasi =this.p1.rotasi[i];
        this.p1.genes[i] = this.p2.genes[i];//set gene 1 = gene 2
        this.p1.rotasi[i] = this.p2.rotasi[i];//set gene 1 = gene 2
        for (var j = 0; j < this.p1.genes.length; j++) {
          if (this.p1.genes[j]==this.p1.genes[i] && j!=i) {
            this.p1.genes[j] = temp;
            this.p1.rotasi[j] = tempRotasi;
          }
        }
        this.p2.genes[i] = temp; //set gene 2 = gene 1
        this.p2.rotasi[i] = tempRotasi; //set gene 2 = gene 1
        for (var j = 0; j < this.p1.genes.length; j++) {
          if (this.p2.genes[j]==temp && j!=i) {
            this.p2.genes[j] = this.p1.genes[i];
            this.p2.rotasi[j] = this.p1.rotasi[i];
          }
        }
      }//crossOverPoint
      this.os.push(p1);
      this.os.push(p2);
    }//crossover
  }

  //Mutation
  mutation() {

    var mutation = this.mr*this.population.individuals.length;
    var p1,p2;
    for (var i = 0; i < mutation; i++) {
      p1 = this.fittest;
      //Select a random mutation point
      var mutationPoint = Math.floor(Math.random() * this.population.individuals[0].length);
      var mutationPoint2 = Math.floor(Math.random() * this.population.individuals[0].length);
      // 1,2,3,4
      //Flip values at the mutation point
      while (mutationPoint == mutationPoint2) {
        mutationPoint2 = Math.floor(Math.random() * this.population.individuals[0].length);
      }
      var temp = p1.genes[mutationPoint];
      var tempRotasi = p1.rotasi[mutationPoint];
      p1.genes[mutationPoint] = p1.genes[mutationPoint2];
      p1.genes[mutationPoint2] = temp;
      p1.rotasi[mutationPoint] = p1.rotasi[mutationPoint2];
      p1.rotasi[mutationPoint2] = tempRotasi;

      this.os.push(p1);
      // //Select a random mutation point
      // mutationPoint = Math.floor(Math.random() * this.population.individuals[0].length);
      // mutationPoint2 = Math.floor(Math.random() * this.population.individuals[0].length);
      //
      // //Flip values at the mutation point
      // while (mutationPoint == mutationPoint2) {
      //   mutationPoint2 = Math.floor(Math.random() * this.population.individuals[0].length);
      // }
      // var temp = this.secondFittest.genes[mutationPoint];
      // var tempRotasi = this.secondFittest.rotasi[mutationPoint];
      // this.secondFittest.genes[mutationPoint] = this.secondFittest.genes[mutationPoint2];
      // this.secondFittest.genes[mutationPoint2] = temp;
      // this.secondFittest.rotasi[mutationPoint] = this.secondFittest.rotasi[mutationPoint2];
      // this.secondFittest.rotasi[mutationPoint2] = tempRotasi;
    }

  }

  //Get fittest offspring
  getFittestOffspring() {
    var maxFitness = 0;
    var fittestOffspring;
    // if (this.fittest.fitness > this.secondFittest.fitness) {
    //   return this.fittest;
    // }
    // return this.secondFittest;
    for (var i = 0; i < this.os.length; i++) {
      if (this.os[i].fitness > maxFitness) {
        fittestOffspring = this.os[i];
      }
    }
    return fittestOffspring;
  }


  //Replace least fittest individual from most fittest offspring
  addFittestOffspring() {

    // //Update fitness values of offspring
    // this.fittest.calcFitness();
    // this.secondFittest.calcFitness();

    for (var i = 0; i < this.os.length; i++) {
      this.os[i].calcFitness();
    }

    //Get index of least fit individual
    var leastFittestIndex = this.population.getLeastFittestIndex();

    //Replace least fittest individual from most fittest offspring
    this.population.individuals[leastFittestIndex] = this.getFittestOffspring();
  }
  start(){
    this.population.calculateFitness();
    console.log("Generation: " + this.generationCount + " Fittest: " + this.population.fittest);
    //While population gets an individual with maximum fitness
    while (this.population.fittest < 100 && this.generationCount< 50) {
      // console.table(this.population.individuals);
      this.generationCount++;

      //Do selection
      this.selection();

      //Do crossover
      this.crossover();

      //Do mutation under a random probability
      // if (Math.floor(Math.random() * 100)+1 < 5) {
        this.mutation();
      // }

      //Add fittest offspring to population
      this.addFittestOffspring();

      //Calculate new fitness value
      this.population.calculateFitness();

      console.log("Generation: " + this.generationCount + " Fittest: " + this.population.fittest);
    }
    console.log("\nSolution found in generation " + this.generationCount);
    console.log("Fitness: "+this.population.getFittest().fitness);
    console.log("Genes: "+this.population.getFittest().genes.join());
  }
}
