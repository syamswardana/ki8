
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
      console.table(this.population.individuals);
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
  }
}
