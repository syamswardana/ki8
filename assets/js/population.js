
//pupulasi
class Population{

  constructor(kontainer,barang){
    //populasi 10 individu
    this.individuals = new Array(20);
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
