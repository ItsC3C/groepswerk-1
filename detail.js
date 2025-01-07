var x = document.querySelectorAll(".pokémon_ability_results");
var i;

for (i = 0; i < x.length; i++) {
  x[i].computedStyleMap.display = "none";
  x[i].addEventListener("mouseover", function () {
    this.style.display = "block";
  });
}
