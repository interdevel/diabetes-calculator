// Functions that make the calculator work.

document.addEventListener("DOMContentLoaded", () => {
  var button = document.getElementById("calculate");

  button.addEventListener("click", (event) => {
    event.preventDefault();

    var dtcalc_nutrient_grams = parseFloat(document.getElementById("dtcalc_nutrient_grams").value);
    var dtcalc_fat = parseFloat(document.getElementById("dtcalc_fat").value);
    var dtcalc_ch = parseFloat(document.getElementById("dtcalc_ch").value);
    var dtcalc_prot = parseFloat(document.getElementById("dtcalc_prot").value);
   
    var gram_consum_fat = parseFloat((dtcalc_nutrient_grams * dtcalc_fat) / 100);
    var gram_consum_ch = parseFloat((dtcalc_nutrient_grams * dtcalc_ch) / 100);
    var gram_consum_prot = parseFloat((dtcalc_nutrient_grams * dtcalc_prot) / 100);

    var ra_consum_ch = gram_consum_ch;
    var ra_consum_fat = (gram_consum_fat * 9) / 10;
    var ra_consum_prot = (gram_consum_prot * 4) / 10;
    var total_fpu = ra_consum_fat + ra_consum_prot;
    
    document.getElementById("dtcalc_ch_calc").value = gram_consum_ch;
    document.getElementById("dtcalc_ch_ch_calc").value = ra_consum_ch;
    document.getElementById("dtcalc_fat_calc").value = gram_consum_fat;
    document.getElementById("dtcalc_fat_ch_calc").value = ra_consum_fat;
    document.getElementById("dtcalc_prot_calc").value = gram_consum_prot;
    document.getElementById("dtcalc_prot_ch_calc").value = ra_consum_prot;
    document.getElementById("total_fpu").innerHTML = total_fpu + " g. CH";
    document.getElementById("total_ch").innerHTML = gram_consum_ch + " g. CH";
    
  });
});
